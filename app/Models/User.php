<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Traits\HasOneProfile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasTenants
{
    use HasApiTokens, HasFactory, SoftDeletes, HasOneProfile,  Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'school_id',
        'current_role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getTenants(Panel $panel): Collection
    {
        return $this->institutions;
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class);
    }



    public function canAccessTenant(Model $tenant): bool
    {
        return $this->institutions->contains($tenant);
    }

    static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            // create unique id for user
            $user->school_id = IdGenerator::generate(['table' => 'users', 'field' => 'school_id', 'length' => 7, 'reset_on_prefix_change' => true, 'prefix' => userNameAbbr($user->current_role) . date('y')]);;
        });


        self::created(function ($user) {
            // create profile alongside user
            $user->profile()->create();

            // automatically associte the user with school
            $user->institutions()->attach($user->current_institution_id);
        });
    }
}

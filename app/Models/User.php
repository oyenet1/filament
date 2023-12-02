<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Traits\HasOneProfile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
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
    use HasRoles, HasApiTokens, HasFactory, SoftDeletes, HasOneProfile,  Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'username',
        'current_role',
        'school_id',
        'email',
        'phone',
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
        return $this->schools;
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class);
    }



    public function canAccessTenant(Model $tenant): bool
    {
        return $this->schools->contains($tenant);
    }

    static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            // create unique id for user
            $user->username = IdGenerator::generate(['table' => 'users', 'field' => 'username', 'length' => 7, 'reset_on_prefix_change' => true, 'prefix' => userNameAbbr($user->current_role) . date('y')]);;
        });


        self::created(function ($user) {
            // create profile alongside user
            $user->profile()->create(['school_id' => $user->school_id]);

            // automatically associte the user with school
            $user->schools()->attach($user->school_id);

            // attach role when creating as well
            if ($user->current_role) {
                $user->assignRole($user->current_role);
            }
        });
    }
}

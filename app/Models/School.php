<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\HasAvatar;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class School extends Model implements HasAvatar
{
    use HasFactory, SoftDeletes;


    function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Active School';
    }

    function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    static function boot()
    {
        parent::boot();
        self::creating(function ($school) {
            // create unique id for user
            $school->code = IdGenerator::generate(['table' => 'schools', 'field' => 'code', 'length' => 7, 'reset_on_prefix_change' => true, 'prefix' => generateUniqueSchoolCode($school->name) . date('y')]);;
        });

        self::created(function ($school) {
            $school->setting()->create([
                'staff_prefix' => generateUniqueSchoolCode($school->code, 0, 3) . "ST",
                'student_prefix' => generateUniqueSchoolCode($school->code, 0, 3) . "STU",
                'parent_prefix' => generateUniqueSchoolCode($school->code, 0, 3) . "PT",
            ]);
        });
    }
}

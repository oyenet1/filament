<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\HasAvatar;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class School extends Model implements HasCurrentTenantLabel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["country_id"];


    function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->logo;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Active School';
    }

    function academicYears(): HasMany
    {
        return $this->hasMany(AcademicYear::class);
    }

    function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }
    function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
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

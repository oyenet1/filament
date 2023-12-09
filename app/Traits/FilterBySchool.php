<?php

namespace App\Traits;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait FilterBySchool
{
    function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public static function boot()
    {
        parent::boot();

        // self::creating(function ($model) {
        //     $model->school_id =  auth()->user()->school_id;
        // });

        self::addGlobalScope(function (Builder $builder) {
            $builder->where('school_id', auth()->user()->school_id);
        });
    }
}

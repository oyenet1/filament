<?php

namespace App\Traits;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait FilterByInstitution
{
    function Institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->Institution_id =  auth()->user()->current_institution_id;
        });

        // self::addGlobalScope(function (Builder $builder) {
        //     $builder->where('Institution_id', auth()->user()->current_Institution_id);
        // });
    }
}

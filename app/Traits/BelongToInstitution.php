<?php

namespace App\Traits;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToInstitution
{
    function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
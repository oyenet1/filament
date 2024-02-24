<?php

namespace App\Traits;

use App\Models\Profile;

trait HasOneProfile
{
    function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}

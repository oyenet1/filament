<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->can('create school settings');
    }

    // public function create(User $user): bool
    // {
    //     return $user->can('create school settings');
    // }
}

<?php

namespace App\Policies;

use App\Models\AcademicYear;
use App\Models\User;

class AcademicYearPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->can('read academic year');
    }

    public function view(User $user, AcademicYear $academicYear)
    {
        return $user->can('read academic year');
    }
    public function create(User $user)
    {
        return $user->can('create academic year');
    }
    public function update(User $user, AcademicYear $academicYear)
    {
        return $user->can('update academic year');
    }
    public function delete(User $user, AcademicYear $academicYear)
    {
        return $user->can('delete academic year');
    }

    public function forceDelete(User $user, AcademicYear $academicYear)
    {
        return $user->hasRole(['superadmin', 'adminyyt']);
    }
}

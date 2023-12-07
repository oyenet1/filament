<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver
{
    function creating(AcademicYear $year)
    {
        // make other academic years not current and update itself to current
        $schoolYears = AcademicYear::all();
        $schoolYears->each->update(['is_current' => false]);
        $year->update(['is_current' => true]);
    }
    function deleted(AcademicYear $year)
    {
        // delete the term as the parent is deleting as well
        $year->terms()->delete();
    }
}

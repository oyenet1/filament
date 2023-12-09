<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver
{
    function created(AcademicYear $year)
    {
        // make other academic years not current and update itself to current
        $schoolyears = AcademicYear::all();
        $schoolyears->each->update(['is_current' => false]);
        $year->update(['is_current' => true]);
    }


    function deleted(AcademicYear $year)
    {
        // make the next in line active
        AcademicYear::latest()->first()->update(['is_current' => true]);
        // delete the term as the parent is deleting as well
        $year->terms()->delete();

        // remove default current session
        $year->update(['is_current' => false]);
    }

    function restored(AcademicYear $year)
    {
        // make other academic years not current and update itself to current
        $schoolyears = AcademicYear::all();
        $schoolyears->each->update(['is_current' => false]);
        $year->update(['is_current' => true]);

        // restore the terms as well
        $year->terms()->update(['is_current' => true]);
        \Log::info('I am working');
    }
}

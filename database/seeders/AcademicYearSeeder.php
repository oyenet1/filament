<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = ["first", "second", "third"];
        for ($i = 20; $i > 0; $i--) {
            $year =    AcademicYear::create([
                'name' => date('Y') - $i . "/" . date('y') - ($i + 1),
                'start' => now()->subYears($i),
                'end' => now()->subYears($i)->addWeeks(random_int(45, 52)),
                'school_id' => random_int(1, 3),
            ]);
            foreach ($terms as $key => $term) {
                $year->terms()->create([
                    'name' => $term,
                    'start' => $year->start->addDay(100),
                    'end' => $year->end->addDay(100),
                    'dso' => random_int(90, 115),
                    'school_id' => $year->school_id
                ]);
            }
        }
    }
}

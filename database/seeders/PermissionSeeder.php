<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            "super-admin" => [
                "school" => ['c', 'r', 'u', 'd'],
                "school settings" => ['c', 'r', 'u', 'd'],
                "user" => ['c', 'r', 'u', 'd'],
                "role" => ['c', 'r', 'u', 'd'],
                "academic year" => ['c', 'r', 'u', 'd'],
                "term" => ['c', 'r', 'u', 'd'],
                "school type" => ['c', 'r', 'u', 'd'],
                "class" => ['c', 'r', 'u', 'd'],
                "section" => ['c', 'r', 'u', 'd'],
                "subject" => ['c', 'r', 'u', 'd'],
                "timetable" => ['c', 'r', 'u', 'd'],
                "student" => ['c', 'r', 'u', 'd'],
                "score" => ['c', 'r', 'u', 'd'],
                "card" => ['c', 'r', 'u', 'd'],
                "grade system" => ['c', 'r', 'u', 'd'],
                "promotion" => ['c', 'r', 'u', 'd'],
                "fee" => ['c', 'r', 'u', 'd'],
                "payment" => ['c', 'r', 'u', 'd'],
                "finance" => ['c', 'r', 'u', 'd'],
                "syllabus" => ['c', 'r', 'u', 'd'],
            ],
        ];

        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    function getOperation($val)
    {
        $ops = ['c' => 'create', "r" => 'read', "u" => 'update', "d" => 'delete'];
        return $ops[$val];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            "admin" => [
                "school" => ['r'],
                "school settings" => ['r', 'u'],
                "user" => ['c', 'r', 'u',],
                "role" => ['r', 'u'],
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

        // assign permision to superadmin role
        foreach ($permissions["super-admin"] as $perm => $ops) {
            foreach ($ops as $op) {
                $permission = Permission::firstOrCreate(['name' => $this->getOperation($op, $perm)]);
            }
        }
        Role::where('name', 'super-admin')->first()->givePermissionTo(Permission::all());

        foreach ($permissions["admin"] as $perm => $ops) {
            foreach ($ops as $op) {
                $permission = Permission::firstOrCreate(['name' => $this->getOperation($op, $perm)]);
                $permission->assignRole("admin"); //assign role of admin o each permission
            }
        }

        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    function getOperation(string $val, string $perm): string
    {
        $ops = ['c' => 'create', "r" => 'read', "u" => 'update', "d" => 'delete'];
        return $ops[$val] . " " . $perm;
    }
}

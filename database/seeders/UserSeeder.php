<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => "superadmin",
            'title' => fake()->title(),
            'phone' => fake()->phoneNumber(),
            'email' => "superadmin@fedums.com.ng",
            'email_verified_at' => now(),
            'password' => bcrypt('superadmin'),
            'current_role' => "super-admin",
            'remember_token' => Str::random(10),
        ]);
        $admin = User::create([
            'name' => "admin",
            'title' => fake()->title(),
            'phone' => fake()->phoneNumber(),
            'email' => "admin@fedums.com.ng",
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'current_role' => "admin",
            'remember_token' => Str::random(10),
        ]);

        $superadmin->schools()->attach([1, 2, 3]);
        $admin->schools()->attach([2]);
        User::factory(100)->create();
    }
}
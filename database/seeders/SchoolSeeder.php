<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name' => "Bonifade International School",
            'domain' => "bonifade",
            'slug' => "bonifade",
            'phone' => "7065720177",
            'email' => "info@bonifade.com",
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->domainName(),
            'slug' => fake()->slug(6),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->domainName(),
            'slug' => fake()->slug(6),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
        ]);
    }
}

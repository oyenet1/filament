<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institution::create([
            'name' => "Bonifade International School",
            'domain' => "bonifade",
            'slug' => "bonifade",
            'phone' => "7065720177",
            'email' => "info@bonifade.com",
        ]);
        Institution::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->domainName(),
            'slug' => fake()->slug(6),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
        ]);
        Institution::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->domainName(),
            'slug' => fake()->slug(6),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
        ]);
    }
}
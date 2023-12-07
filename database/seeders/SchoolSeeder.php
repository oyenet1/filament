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
            'code' => "bonifade",
            'phone' => "7065720177",
            'email' => "info@bonifade.com",
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled", "Active"])
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"])
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"])
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Active", "Inactive", "Disabled", "Active"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(1, 4))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(0, 1))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(1, 5))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(1, 6))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(0, 1))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(0, 1))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(0, 3))
        ]);
        School::create([
            'name' => fake()->unique()->company() . " School",
            'domain' => fake()->unique()->domainName(),
            'code' => fake()->slug(2),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'status' => fake()->randomElement(["Active", "Active", "Disabled", "Inactive", "Disabled"]),
            'created_at' => now()->subYears(random_int(0, 3))
        ]);
    }
}

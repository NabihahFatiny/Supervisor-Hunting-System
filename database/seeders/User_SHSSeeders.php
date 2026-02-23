<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class User_SHSSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Initialize Faker

        foreach (range(1, 5) as $value) {
            // Generate a random raw password with 12 characters (you can adjust length)
            $rawPassword = Str::random(12);

            DB::table('user_shs')->insert([
                'username' => $faker->unique()->userName,
                'temp_password' => Hash::make($rawPassword), // Hashed temporary password
                'new_password' => null, // Set to null initially
                'role' => $faker->randomElement(['Lecturer', 'Student', 'Coordinator']),
                'raw_password' => $rawPassword, // Store raw password for reference (plaintext)
                'CreatedAt' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

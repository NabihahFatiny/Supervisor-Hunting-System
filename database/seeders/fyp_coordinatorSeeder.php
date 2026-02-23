<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class fyp_coordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate a random raw password for the coordinator (optional)
        $rawPassword = Str::random(12);

        // Insert the new Coordinator user into the 'user_shs' table
        $userId = DB::table('user_shs')->insertGetId([
            'username' => $faker->unique()->userName,
            'temp_password' => bcrypt($rawPassword), // Hashed temporary password
            'new_password' => null, // Initially set to null
            'role' => 'Coordinator', // Role set as 'Coordinator'
            'raw_password' => $rawPassword, // Store raw password (plaintext)
            'CreatedAt' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert the same user into the 'fyp_coordinators' table
        DB::table('fyp_coordinators')->insert([
            'Name' => $faker->name,
            'Email' => $faker->unique()->email,
            'user_Id' => $userId, // Use the userId of the newly created user
        ]);
    }
}

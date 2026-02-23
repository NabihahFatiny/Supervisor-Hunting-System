<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class StudentSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Fetch only users with 'Student' role from user_shs table
        $studentUsers = DB::table('user_shs')->where('role', 'Student')->pluck('user_Id')->toArray();

        foreach ($studentUsers as $userId) {
            // Check if the user already exists in the student table
            $existingStudent = DB::table('student')->where('user_Id', $userId)->exists();

            // Only insert if the student with the given user_Id does not already exist
            if (!$existingStudent) {
                DB::table('student')->insert([
                    'studName' => $faker->name,
                    'studEmail' => $faker->unique()->email,
                    'program' => $faker->randomElement([
                        'Software Engineering',
                        'Graphic & Multimedia Technology',
                        'Computer System & Networking',
                        'Cyber Security'
                    ]),
                    'user_Id' => $userId, // Ensure user_Id matches a student user in user_shs
                    'lecturer_Id' => $faker->boolean(50) ? $faker->numberBetween(1, 5) : null, // 50% chance to set a lecturer
                    'title_Id' => $faker->boolean(50) ? $faker->numberBetween(1, 5) : null, // 50% chance to set a title
                    'assignedgroup_id' => $faker->boolean(50) ? $faker->numberBetween(1, 3) : null, // 50% chance to set an assigned group
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

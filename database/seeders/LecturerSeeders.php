<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class LecturerSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
     // Fetch only users with 'Lecturer' role from user_shs table
     $lectUsers = DB::table('user_shs')->where('role', 'Lecturer')->pluck('user_Id')->toArray();

     foreach ($lectUsers as $userId) {
         // Check if the user already exists in the lecturers table
         $existingLect = DB::table('lecturers')->where('user_Id', $userId)->exists();

         // Only insert if the lecturer with the given user_Id does not already exist
         if (!$existingLect) {
             DB::table('lecturers')->insert([
                 'lecturerName' => $faker->name,
                 'email' => $faker->unique()->email,
                 'current_quota' => $faker->numberBetween(1, 5),
                 'user_Id' => $userId,  // Use the userId from $lectUsers
                 'assignedgroup_id' => $faker->numberBetween(1, 3),
                 'assigned_quota' => $faker->numberBetween(1, 10),
             ]);
         }
     }

}
}

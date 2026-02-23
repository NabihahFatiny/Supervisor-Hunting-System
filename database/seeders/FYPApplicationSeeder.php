<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class FYPApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $studentIds = DB::table('student')->pluck('student_Id')->toArray();
        $lecturerIds = DB::table('lecturers')->pluck('lecturerID')->toArray();
        $titleIds = DB::table('fyp_title')->pluck('TitleID')->toArray();

        foreach (range(1, 10) as $index) {
            DB::table('fyp_application')->insert([
                'student_id' => $faker->randomElement($studentIds),
                'lecturer_id' => $faker->randomElement($lecturerIds),
                'title_id' => $faker->randomElement($titleIds),
                'custom_title' => $faker->sentence,
                'description' => $faker->paragraph,
                'file_path' => $faker->url,
                'status' => $faker->randomElement(['Pending', 'Accepted', 'Rejected']),
                'remarks' => $faker->sentence,
                'created_at' => now(),
            ]);
        }
    }
}

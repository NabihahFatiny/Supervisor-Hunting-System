<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class QuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $lecturerIds = DB::table('lecturers')->pluck('lecturerID')->toArray();

        foreach ($lecturerIds as $lecturerId) {
            DB::table('quota')->insert([
                'Lecturer_id' => $lecturerId,
                'Assigned_quota' => $faker->numberBetween(1, 10),
            ]);
        }

    }
}

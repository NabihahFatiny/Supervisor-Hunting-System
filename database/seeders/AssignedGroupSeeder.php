<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class AssignedGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $lecturers = DB::table('lecturers')->get();

        foreach ($lecturers as $lecturer) {
            DB::table('assigned_group')->insert([
                'assignedgroup_id' => $faker->unique()->numberBetween(1, 10),
                'group_name' => $faker->word,
                'lecturer_id' => $lecturer->lecturerID,
                'lecturer_name' => $lecturer->lecturerName,
                'Assigned_quota' => $faker->numberBetween(5, 15),
            ]);
        }
    }
}

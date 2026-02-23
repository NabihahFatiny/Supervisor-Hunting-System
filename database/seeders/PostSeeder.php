<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');

        $categories = [
            'Front-End Development',
            'Back-End Development',
            'Full Stack Development',
            'UI/UX Design',
            'Software Engineering',
            'Mobile App Development',
            'Cloud Computing',
            'Cybersecurity',
            'Data Science',
            'AI & Machine Learning'
        ];
        // Insert dummy posts
        foreach (range(1, 10) as $index) {
            DB::table('posts')->insert([
                'LecturerID' => rand(1, 2), // Adjust based on the number of lecturers you have
                'PostTitle' => $faker->sentence,
                'PostDescription' => $faker->paragraph,
                'PostCategory' => $faker->randomElement($categories), // Random category from the list
                'PostDate' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;
use Carbon\Carbon; // Import Carbo

class FYPTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');

        // Get all post IDs from the posts table
        $postIds = DB::table('posts')->pluck('PostID')->toArray();

        foreach ($postIds as $postId) {
            // Create 3 titles for each post
            foreach (range(1, 3) as $index) {
                DB::table('fyp_title')->insert([
                    'PostID' => $postId,
                    'TitleName' => $faker->sentence,
                    'TitleDescription' => $faker->paragraph,
                    'Quota' => $faker->numberBetween(1, 3),
                    'current_quota' => $faker->numberBetween(0, 3),
                    'TitleStatus' => 'Available',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}

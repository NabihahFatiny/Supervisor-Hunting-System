<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;
use Carbon\Carbon; // Import Carbon

class TimeframeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timeframe')->insert([
            'Start_date' => Carbon::now()->subDays(30),
            'End_date' => Carbon::now()->addDays(30),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            LecturerSeeders::class,
            QuotaSeeder::class,
            StudentSeeders::class,
            TimeframeSeeder::class,
            AssignedGroupSeeder::class,
            Fyp_CoordinatorSeeder::class,
            PostSeeder::class,
            FypTitleSeeder::class,
            FYPApplicationSeeder::class

        ]);
    }
}

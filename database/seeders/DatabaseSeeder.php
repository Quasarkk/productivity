<?php

namespace Database\Seeders;

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
            PillarSeeder::class,
            SubpillarSeeder::class,
            ObjectiveSeeder::class,
            SubobjectiveSeeder::class,
            RoutineSeeder::class,
            TaskSeeder::class,
            UserSeeder::class,
        ]);
    }
}

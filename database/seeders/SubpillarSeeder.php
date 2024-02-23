<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SubpillarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Finance pillar
        DB::table('subpillars')->insert([
            'name' => 'Crypto',
            'description' => 'Long term spot, Mid term swing, Short term shitcoins',
            'pillar_id'=> 1,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'Stocks',
            'description' => 'Very long term spot S&P ETF',
            'pillar_id'=> 1,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'Saving',
            'description' => 'Investing description',
            'pillar_id'=> 1,
        ]);

        //Sport pillar
        DB::table('subpillars')->insert([
            'name' => 'Gym',
            'description' => 'Strenght and hypertrophy training',
            'pillar_id'=> 2,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'Boxing',
            'description' => 'Learn to fight',
            'pillar_id'=> 2,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'Running',
            'description' => 'Boring cardio',
            'pillar_id'=> 2,
        ]);

        //Profesionnal pillar
        DB::table('subpillars')->insert([
            'name' => 'Job',
            'description' => 'Get or keep a job',
            'pillar_id'=> 3,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'freelancing',
            'description' => 'Make some side money',
            'pillar_id'=> 3,
        ]);
        DB::table('subpillars')->insert([
            'name' => 'Coding',
            'description' => 'Get better at coding',
            'pillar_id'=> 3,
        ]);
    }
}

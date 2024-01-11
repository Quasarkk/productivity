<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class ObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Coding
        DB::table('objectives')->insert([
            'name' => '1 project / month for 3 months straight',
            'description' => 'Make a project by month to gain experience',
            'subpillar_id'=> 9,
            'deadline' => Carbon::createFromFormat('d-m-Y', '01-03-2024'),
        ]);

        //Gym
        DB::table('objectives')->insert([
            'name' => 'reach new PR SBD',
            'description' => 'Achieve new goals',
            'subpillar_id'=> 4,
            'deadline' => Carbon::createFromFormat('d-m-Y', '01-03-2024'),
        ]);

        //Job
        DB::table('objectives')->insert([
            'name' => 'Find a job',
            'description' => '',
            'subpillar_id'=> 7,
            'deadline' => Carbon::createFromFormat('d-m-Y', '01-06-2024'),
        ]);
    }
}

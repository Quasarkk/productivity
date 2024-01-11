<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routines')->insert([
            'name' => '2 hours working of dev project',
            'description' => '',
            'subobjective_id'=> 1,
            'when' => 'afternoon',
        ]);
    }
}

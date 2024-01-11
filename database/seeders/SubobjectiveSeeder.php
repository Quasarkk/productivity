<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class SubobjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('subobjectives')->insert([
            'name' => 'January Project Coding',
            'description' => 'Make and publish a portfolio',
            'objective_id'=> 1,
            'deadline' => Carbon::createFromFormat('d-m-Y', '31-01-2024'),
        ]);
        DB::table('subobjectives')->insert([
            'name' => 'February Project Coding',
            'description' => 'MVP productivity app',
            'objective_id'=> 1,
            'deadline' => Carbon::createFromFormat('d-m-Y', '31-02-2024'),
        ]);
        DB::table('subobjectives')->insert([
            'name' => 'March Project Coding',
            'description' => "don't know yet",
            'objective_id'=> 1,
            'deadline' => Carbon::createFromFormat('d-m-Y', '31-03-2024'),
        ]);
    }
}

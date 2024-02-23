<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PillarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pillars')->insert([
            'name' => 'Finances',
            'description' => 'Personnal finances, saving, investing',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Sports',
            'description' => 'Walking, running, boxing, gym',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Professional',
            'description' => 'Job searching, freelancing, coding',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Adult life',
            'description' => 'Papers, dishes, washing, laundries',
        ]);

    }
}

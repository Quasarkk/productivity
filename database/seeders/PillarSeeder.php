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
            'user_id' => '1',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Sports',
            'description' => 'Walking, running, boxing, gym',
            'user_id' => '1',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Professional',
            'description' => 'Job searching, freelancing, coding',
            'user_id' => '1',
        ]);

        DB::table('pillars')->insert([
            'name' => 'Adult life',
            'description' => 'Papers, dishes, washing, laundries',
            'user_id' => '1',
        ]);


        // USER B SEEDERS
        DB::table('pillars')->insert([
            'name' => 'Mister B',
            'description' => 'Papers, dishes, washing, laundries',
            'user_id' => '2',
        ]);
                DB::table('pillars')->insert([
            'name' => 'Mister BB',
            'description' => 'Papers, dishes, washing, laundries',
            'user_id' => '2',
        ]);

    }
}

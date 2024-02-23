<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\Routine;


class RoutineSeeder extends Seeder
{
    public function run(): void
    {
        Routine::create([
            'name' => 'Progressing on the current project everyday',
            'description' => '',
            'subobjective_id' => 1,
            'frequency' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
        ]);
    }
}

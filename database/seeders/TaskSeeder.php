<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Task associated with the routine 2 hours working of dev project (routine_id=1)
        Task::create([
            'name' => '2 hours',
            'dates' => Carbon::createFromFormat('Y-m-d', '2024-01-31'),
            'status' => 'not done',
            'taskable_type' => 'App\Models\Routine', // Associated model, here routine
            'taskable_id' => 1, // routine.id
        ]);

        // Task associated with Sport pillar pillar_id=2
        Task::create([
            'name' => 'Strech for 30 minutes',
            'dates' => Carbon::createFromFormat('Y-m-d', '2024-01-31'),
            'status' => 'not done',
            'taskable_type' => 'App\Models\Pillar', // Associated model, here routine
            'taskable_id' => 1, // routine.id
        ]);
    }
}

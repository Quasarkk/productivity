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
            'name' => 'dev',
            'status' => 'not done',
            'taskable_type' => 'App\Models\Routine', // Associated model, here routine
            'taskable_id' => 1, // routine.id
            'dates' => Carbon::createFromFormat('d-m-Y', '19-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('08:30'),
            'end_hour' => Carbon::createFromTimeString('12:00'),
        ]);

        // Task associated with Sport pillar pillar_id=2
        Task::create([
            'name' => 'Manger',
            'status' => 'not done',
            'taskable_type' => 'App\Models\Pillar', // Associated model, here routine
            'taskable_id' => 1, // routine.id
            'dates' => Carbon::createFromFormat('d-m-Y', '19-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('12:00'),
            'end_hour' => Carbon::createFromTimeString('12:30'),
        ]);

        Task::create([
            'name' => 'muscu',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '18-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('13:30'),
            'end_hour' => Carbon::createFromTimeString('14:30'),
        ]);

        Task::create([
            'name' => 'courses',
            'dates' => Carbon::createFromFormat('Y-m-d', '2024-01-31'),
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '20-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('17:00'),
            'end_hour' => Carbon::createFromTimeString('18:00'),
        ]);

        Task::create([
            'name' => 'courses',
            'dates' => Carbon::createFromFormat('Y-m-d', '2024-01-31'),
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '26-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('17:00'),
            'end_hour' => Carbon::createFromTimeString('18:00'),
        ]);
    }
}

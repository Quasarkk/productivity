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
        // Task associated with Sport pillar pillar_id=2
        Task::create([
            'name' => '27 janvier',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '27-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('13:00'),
            'end_hour' => Carbon::createFromTimeString('14:30'),
            'user_id' => '1',
        ]);

        Task::create([
            'name' => 'Sport',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '29-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('14:00'),
            'end_hour' => Carbon::createFromTimeString('15:00'),
            'user_id' => '1',
        ]);

        Task::create([
            'name' => '28 janvier',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '28-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('13:00'),
            'end_hour' => Carbon::createFromTimeString('14:30'),
            'user_id' => '1',
        ]);

        Task::create([
            'name' => '24 janvier',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '24-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('13:30'),
            'end_hour' => Carbon::createFromTimeString('14:30'),
            'user_id' => '1',
        ]);

        Task::create([
            'name' => '25 janvier',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '25-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('17:00'),
            'end_hour' => Carbon::createFromTimeString('18:00'),
            'user_id' => '1',
        ]);

        Task::create([
            'name' => '26 janvier',
            'status' => 'not done',
            'dates' => Carbon::createFromFormat('d-m-Y', '26-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('17:00'),
            'end_hour' => Carbon::createFromTimeString('18:00'),
            'user_id' => '1',
        ]);

        // Task associated with the routine 2 hours working of dev project (routine_id=1)
        Task::create([
            'name' => 'Working on the current project',
            'status' => 'not done',
            'taskable_type' => 'App\Models\Routine', // Associated model, here routine
            'taskable_id' => 1, // routine.id
            'dates' => Carbon::createFromFormat('d-m-Y', '29-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('08:30'),
            'end_hour' => Carbon::createFromTimeString('12:00'),
            'user_id' => '1',
        ]);

        //USER B
        Task::create([
            'name' => 'MISTER B',
            'status' => 'not done',
            'taskable_type' => 'App\Models\Routine', // Associated model, here routine
            'taskable_id' => 1, // routine.id
            'dates' => Carbon::createFromFormat('d-m-Y', '29-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('08:30'),
            'end_hour' => Carbon::createFromTimeString('12:00'),
            'user_id' => '2',
        ]);
        Task::create([
            'name' => 'MISTER BEAST',
            'status' => 'not done',
            'taskable_type' => 'App\Models\Routine', // Associated model, here routine
            'taskable_id' => 1, // routine.id
            'dates' => Carbon::createFromFormat('d-m-Y', '29-01-2024'),
            'begin_hour' => Carbon::createFromTimeString('08:30'),
            'end_hour' => Carbon::createFromTimeString('12:00'),
            'user_id' => '2',
        ]);
    }
}

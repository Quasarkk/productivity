<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::with('taskable')->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'status' => $task->status,
                'relatedType' => class_basename($task->taskable),
                'relatedName' => $task->taskable ? $task->taskable->name : null,
            ];
        });

        $tasksNotDoneCount = Task::where('status', 'not done')->count();
        $tasksDoneCount = Task::where('status', 'done')->count();

        return Inertia::render('Custom/TasksPage', [
            'tasks' => $tasks,
            'tasksNotDoneCount' => $tasksNotDoneCount,
            'tasksDoneCount' => $tasksDoneCount
        ]);
    }

    public function indexCalendarPage() {
        $tasks = Task::with('taskable')->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'status' => $task->status,
                'relatedType' => class_basename($task->taskable),
                'relatedName' => $task->taskable ? $task->taskable->name : null,

                'dates' => $task->dates,
                'begin_hour' => $task->begin_hour,
                'end_hour' => $task->end_hour,
            ];
        });

        $tasksNotDoneCount = Task::where('status', 'not done')->count();
        $tasksDoneCount = Task::where('status', 'done')->count();

        return Inertia::render('Custom/CalendarPage', [
            'tasks' => $tasks,
            'tasksNotDoneCount' => $tasksNotDoneCount,
            'tasksDoneCount' => $tasksDoneCount
        ]);
    }



    public function store(Request $request)
    {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'dates' => ['required'],
            'begin_hour' => ['nullable'],
            'end_hour' =>['nullable'],

        ])->validate();

        Task::create($valid_data);
    }

    public function update (Request $request, Task $task)
    {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'dates' => ['required'],
            'begin_hour' => ['nullable'],
            'end_hour' =>['nullable'],
        ])->validate();

        $task->update($valid_data);
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }
}


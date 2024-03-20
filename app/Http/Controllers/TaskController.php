<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index() {
        // Récupère uniquement les tâches de l'utilisateur connecté
        $tasks = Task::where('user_id', Auth::id())
                     ->with('taskable')
                     ->get()
                     ->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'name' => $task->name,
                            'status' => $task->status,
                            'relatedType' => class_basename($task->taskable),
                            'relatedName' => $task->taskable ? $task->taskable->name : null,
                        ];
                     });

        // Compte uniquement les tâches de l'utilisateur connecté
        $tasksNotDoneCount = Task::where('user_id', Auth::id())->where('status', 'not done')->count();
        $tasksDoneCount = Task::where('user_id', Auth::id())->where('status', 'done')->count();

        return Inertia::render('App/TasksPage', [
            'tasks' => $tasks,
            'tasksNotDoneCount' => $tasksNotDoneCount,
            'tasksDoneCount' => $tasksDoneCount
        ]);
    }

    public function indexCalendarPage() {
        // Récupérer uniquement les tâches appartenant à l'utilisateur connecté
        $tasks = Task::where('user_id', Auth::id())
                     ->with('taskable')
                     ->get()
                     ->map(function ($task) {
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

        // Compter uniquement les tâches non effectuées et effectuées pour l'utilisateur connecté
        $tasksNotDoneCount = Task::where('user_id', Auth::id())->where('status', 'not done')->count();
        $tasksDoneCount = Task::where('user_id', Auth::id())->where('status', 'done')->count();

        // Retourner la vue avec les tâches et les comptes pour l'utilisateur connecté
        return Inertia::render('App/CalendarPage', [
            'tasks' => $tasks,
            'tasksNotDoneCount' => $tasksNotDoneCount,
            'tasksDoneCount' => $tasksDoneCount
        ]);
    }


    public function store(Request $request)
    {
        $valid_data = Validator::make($request->all(), [
            // Vos règles de validation
        ])->validate();

        // Assurez-vous d'ajouter `user_id` aux données validées
        $valid_data['user_id'] = Auth::id();

        Task::create($valid_data);

        // Redirection ou réponse après la création
    }

    public function update(Request $request, Task $task)
    {
        // Vérifiez si l'utilisateur est autorisé à mettre à jour la tâche
        if ($task->user_id != Auth::id()) {
            // Gérez l'accès non autorisé, par exemple en renvoyant une erreur
        }

        $valid_data = Validator::make($request->all(), [
            // Vos règles de validation
        ])->validate();

        $task->update($valid_data);

        // Redirection ou réponse après la mise à jour
    }

    public function destroy(Task $task)
    {
        // Vérifiez si l'utilisateur est autorisé à supprimer la tâche
        if ($task->user_id != Auth::id()) {
            // Gérez l'accès non autorisé
        }

        $task->delete();

        // Redirection ou réponse après la suppression
    }
}

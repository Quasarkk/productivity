<?php

namespace App\Http\Controllers;

use App\Models\Pillar;
use App\Models\Subpillar;
use App\Models\Objective;
use App\Models\Subobjective;
use App\Models\Routine;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoutineController extends Controller
{
    public function index() {
        $routines = Routine::with('subobjective')->get();
        $subobjectives = Subobjective::all();

        return Inertia::render('Custom/RoutinePage', [
            'routines' => $routines,
            'subobjectives' => $subobjectives
        ]);
    }

    public function store(Request $request) {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'frequency' => ['required'],
            'subobjective' => ['nullable'],
            'subobjective_id' => ['nullable'],
            'begin_hour' => ['required'],
            'end_hour' => ['required'],
        ])->validate();

        $routine = Routine::create($valid_data);
        // Création des tâches récurrentes
        $routine->createRecurringTasks();

        // ...retourner une réponse...
    }

    public function update(Request $request, Routine $routine) {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'frequency' => ['required'],
            'subobjective_id' => ['nullable'],
            'begin_hour' => ['required'],
            'end_hour' => ['required'],
        ])->validate();

        $routine->update($valid_data);

        // Supprimer les tâches futures et créer de nouvelles
        $routine->deleteFutureTasksRoutine();
        $routine->createRecurringTasks();
    }

    public function destroy(Routine $routine)
    {
        $routine->deleteFutureTasksRoutine();
        $routine->delete();
    }
}

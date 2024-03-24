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
        // Récupère seulement les routines appartenant aux subobjectives de l'utilisateur connecté
        $routines = Routine::whereHas('subobjective.objective.subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->with('subobjective')->get();

        // Récupère seulement les subobjectives liées aux objectifs de l'utilisateur connecté
        $subobjectives = Subobjective::whereHas('objective.subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return Inertia::render('App/RoutinePage', [
            'routines' => $routines,
            'subobjectives' => $subobjectives
        ]);
    }


    public function store(Request $request) {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'frequency' => ['required'],
            'subobjective_id' => ['required', 'exists:subobjectives,id'],
            'begin_hour' => ['required'],
            'end_hour' => ['required'],
        ])->validate();

        $valid_data['user_id'] = auth()->id();

        // Vérifie que le subobjective_id appartient à l'utilisateur avant de créer la routine
        $subobjective = Subobjective::whereHas('objective.subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($valid_data['subobjective_id']);

        $routine = Routine::create($valid_data);
        $routine->createRecurringTasks();

        return redirect()->back()->with('success', 'Routine created successfully.');
    }


    public function update(Request $request, Routine $routine) {
        // Vérifie que le subobjective_id (si fourni) et la routine appartiennent à l'utilisateur
        if ($request->input('subobjective_id')) {
            $subobjective = Subobjective::whereHas('objective.subpillar.pillar', function($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($request->input('subobjective_id'));
        }

        if ($routine->subobjective && $routine->subobjective->objective->subpillar->pillar->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'frequency' => ['required'],
            'subobjective_id' => ['nullable', 'exists:subobjectives,id'],
            'begin_hour' => ['required'],
            'end_hour' => ['required'],
        ])->validate();

        $routine->update($valid_data);
        $routine->deleteFutureTasksRoutine();
        $routine->createRecurringTasks();

        return redirect()->back()->with('success', 'Routine updated successfully.');
    }


    public function destroy(Routine $routine)
    {
        if ($routine->subobjective && $routine->subobjective->objective->subpillar->pillar->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $routine->deleteFutureTasksRoutine();
        $routine->delete();

        return redirect()->back()->with('success', 'Routine deleted successfully.');
    }

}

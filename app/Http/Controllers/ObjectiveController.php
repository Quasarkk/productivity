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

class ObjectiveController extends Controller
{
    public function store(Request $request) {
        // Validation initiale
        $valid_data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'subpillar_id' => 'required|exists:subpillars,id',
        ])->validate();

        // Vérifier que le subpillar appartient à l'utilisateur
        $subpillar = Subpillar::whereHas('pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($valid_data['subpillar_id']);

        $objective = Objective::create($valid_data);

        return redirect()->back()->with('success', 'Objective created successfully.');
    }


    public function update(Request $request, Objective $objective)
    {
        // Vérifier que l'objectif appartient à l'utilisateur
        $subpillar = Subpillar::whereHas('pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($objective->subpillar_id);

        $valid_data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'deadline' => 'required|date',
        ])->validate();

        $objective->update($valid_data);

        return redirect()->back()->with('success', 'Objective updated successfully.');
    }


    public function destroy(Objective $objective)
    {
        // Vérifier que l'objectif appartient à l'utilisateur
        $subpillar = Subpillar::whereHas('pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($objective->subpillar_id);

        $objective->delete();

        return redirect()->back()->with('success', 'Objective deleted successfully.');
    }

}

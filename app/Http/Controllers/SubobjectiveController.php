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

class SubobjectiveController extends Controller
{
    public function store(Request $request) {
        $valid_data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'objective_id' => 'required|exists:objectives,id',
        ])->validate();

        // Vérifiez que l'objective appartient à l'utilisateur
        $objective = Objective::whereHas('subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($valid_data['objective_id']);

        $subobjective = Subobjective::create($valid_data);

        return redirect()->back()->with('success', 'Subobjective created successfully.');
    }


    public function update(Request $request, Subobjective $subobjective)
    {
        // Vérifier que le subobjective appartient à l'utilisateur
        $objective = Objective::whereHas('subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($subobjective->objective_id);

        $valid_data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'deadline' => 'required|date',
        ])->validate();

        $subobjective->update($valid_data);

        return redirect()->back()->with('success', 'Subobjective updated successfully.');
    }


    public function destroy(Subobjective $subobjective)
    {
        // Vérifier que le subobjective appartient à l'utilisateur
        $objective = Objective::whereHas('subpillar.pillar', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($subobjective->objective_id);

        $subobjective->delete();

        return redirect()->back()->with('success', 'Subobjective deleted successfully.');
    }
}

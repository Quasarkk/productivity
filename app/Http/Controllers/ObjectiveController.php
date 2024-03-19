<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObjectiveController extends Controller
{
    public function store(Request $request) {
        // Valider la requête et créer le sous-pillier
        $valid_data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'subpillar_id' => 'required|exists:subpillars,id',
        ])->validate();

        $objective = Objective::create($valid_data);

        // Retourner une réponse
        return redirect()->back()->with('success', 'Objective created successfully.');
    }

    public function update(Request $request, Objective $objective)
{
    // Validation des données reçues
    $valid_data = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'deadline' => 'required',
        'subpillar_id' => 'required|exists:pillars,id',

    ])->validate();

    // Mise à jour du pilier
    $objective->update($valid_data);
}
}

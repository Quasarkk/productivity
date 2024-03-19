<?php

namespace App\Http\Controllers;

use App\Models\Subobjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubobjectiveController extends Controller
{
    public function store(Request $request) {
        // Valider la requête et créer le sous-pillier
        $valid_data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'objective_id' => 'required|exists:objectives,id',
        ])->validate();

        $subobjective = Subobjective::create($valid_data);

        // Retourner une réponse
        return redirect()->back()->with('success', 'Subobjective created successfully.');
    }

    public function update(Request $request, Subobjective $subobjective)
    {
        // Validation des données reçues
        $valid_data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'deadline' => 'required',
            'objective_id' => 'required|exists:pillars,id',

        ])->validate();

        // Mise à jour du pilier
        $subobjective->update($valid_data);
    }
}

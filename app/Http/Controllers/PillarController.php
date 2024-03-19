<?php

namespace App\Http\Controllers;

use App\Models\Pillar;
use App\Models\Subpillar;
use App\Models\Objective;
use App\Models\Subobjective;
use App\Models\Routine;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PillarController extends Controller
{
    public function index()
    {
        $pillars = Pillar::with('subpillars.objectives.subobjectives')->get();

        return Inertia::render('Custom/GoalPage', [
            'pillars' => $pillars,
        ]);
    }

    public function store(Request $request) {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'description' => ['required'],
        ])->validate();

        $pillar = Pillar::create($valid_data);
    }

    public function update(Request $request, Pillar $pillar)
{
    // Validation des données reçues
    $valid_data = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
    ])->validate();

    // Mise à jour du pilier
    $pillar->update($valid_data);

    // Redirection ou retour d'une réponse, selon votre application
    // Par exemple, redirigez vers la page d'index avec un message de succès :
    return redirect()->route('pillars.index')->with('success', 'Pillar updated successfully.');
}
}

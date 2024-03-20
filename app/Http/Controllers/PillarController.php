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


class PillarController extends Controller
{
    public function index()
    {
        // Récupère seulement les piliers de l'utilisateur connecté
        $pillars = Pillar::with('subpillars.objectives.subobjectives')
                         ->where('user_id', Auth::id()) // Filtre par user_id
                         ->get();

        return Inertia::render('App/GoalPage', [
            'pillars' => $pillars,
        ]);
    }

    public function store(Request $request) {
        $valid_data = Validator::make($request->all(), [
            'name' => ['required'],
            'description' => ['required'],
        ])->validate();

        $valid_data['user_id'] = auth()->id();

        $pillar = Pillar::create($valid_data);

        return redirect()->route('pillars.index')->with('success', 'Pillar created successfully.');
    }


    public function update(Request $request, Pillar $pillar)
    {
        // Assurez-vous que le pilier appartient à l'utilisateur connecté
        if ($pillar->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $valid_data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ])->validate();

        $pillar->update($valid_data);

        return redirect()->route('pillars.index')->with('success', 'Pillar updated successfully.');
    }

    public function destroy(Pillar $pillar)
    {
        // Vérifie que le pilier appartient à l'utilisateur connecté avant de supprimer
        if ($pillar->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $pillar->delete();

        return redirect()->back()->with('success', 'Pillar deleted successfully.');
    }
}

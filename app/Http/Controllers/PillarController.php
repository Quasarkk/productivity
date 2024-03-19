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
}

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

class SubpillarController extends Controller
{
// SubpillarController.php

public function store(Request $request) {
    // Validation initiale
    $valid_data = Validator::make($request->all(), [
        'name' => 'required',
        'description' => 'required',
        'pillar_id' => 'required|exists:pillars,id',
        ])->validate();

        // Vérifiez que le pilier parent appartient à l'utilisateur connecté
        $pillar = Pillar::where('id', $valid_data['pillar_id'])
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

    $subpillar = Subpillar::create($valid_data);

    return redirect()->back()->with('success', 'Subpillar created successfully.');
}


public function update(Request $request, Subpillar $subpillar)
{
    // Vérifiez que le pilier parent du sous-pillier appartient à l'utilisateur
    $pillar = Pillar::where('id', $subpillar->pillar_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

    $valid_data = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
    ])->validate();

    $subpillar->update($valid_data);

    return redirect()->back()->with('success', 'Subpillar updated successfully.');
}



public function destroy(Subpillar $subpillar)
{
    // Vérifiez que le pilier parent du sous-pillier appartient à l'utilisateur
    $pillar = Pillar::where('id', $subpillar->pillar_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

    $subpillar->delete();

    return redirect()->back()->with('success', 'Subpillar deleted successfully.');
}


}

<?php

namespace App\Http\Controllers;

use App\Models\Subpillar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubpillarController extends Controller
{
// SubpillarController.php

public function store(Request $request) {
    // Valider la requête et créer le sous-pillier
    $valid_data = Validator::make($request->all(), [
        'name' => 'required',
        'description' => 'required',
        'pillar_id' => 'required|exists:pillars,id',
    ])->validate();

    $subpillar = Subpillar::create($valid_data);

    // Retourner une réponse
    return redirect()->back()->with('success', 'Subpillar created successfully.');
}

public function update(Request $request, Subpillar $subpillar)
{
    // Validation des données reçues
    $valid_data = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'pillar_id' => 'required|exists:pillars,id',

    ])->validate();

    // Mise à jour du pilier
    $subpillar->update($valid_data);
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Disease;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::orderBy('name')->get();
        $fongiques = $diseases->filter(fn ($d) => ! $d->isRavageur())->values();
        $ravageurs = $diseases->filter(fn ($d) => $d->isRavageur())->values();

        return view('pages.maladies', compact('diseases', 'fongiques', 'ravageurs'));
    }
}

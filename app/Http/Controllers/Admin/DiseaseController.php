<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiseaseController extends Controller
{
    public const CROPS = [
        'ble_dur' => 'Blé Dur',
        'ble_tendre' => 'Blé Tendre',
        'orge' => 'Orge',
        'triticale' => 'Triticale',
    ];

    public function index(): View
    {
        return view('admin.maladies.index', ['diseases' => Disease::orderBy('name')->get(), 'crops' => self::CROPS]);
    }

    public function create(): View
    {
        return view('admin.maladies.create', ['crops' => self::CROPS]);
    }

    public function store(Request $request): RedirectResponse
    {
        Disease::create($this->validated($request));

        return redirect()->route('admin.maladies.index')->with('success', 'Maladie ajoutée avec succès.');
    }

    public function edit(Disease $disease): View
    {
        return view('admin.maladies.edit', ['disease' => $disease, 'crops' => self::CROPS]);
    }

    public function update(Request $request, Disease $disease): RedirectResponse
    {
        $disease->update($this->validated($request));

        return redirect()->route('admin.maladies.index')->with('success', 'Maladie modifiée avec succès.');
    }

    public function destroy(Disease $disease): RedirectResponse
    {
        $disease->delete();

        return redirect()->route('admin.maladies.index')->with('success', 'Maladie supprimée avec succès.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'affected_crops' => ['required', 'array', 'min:1'],
            'affected_crops.*' => ['in:'.implode(',', array_keys(self::CROPS))],
            'symptoms' => ['nullable', 'string'],
            'cultural_practices' => ['nullable', 'string'],
            'chemical_treatment' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ], [], [
            'name' => 'nom',
            'scientific_name' => 'nom scientifique',
            'affected_crops' => 'céréales sensibles',
            'symptoms' => 'symptômes',
            'cultural_practices' => 'pratiques culturelles',
            'chemical_treatment' => 'traitement chimique',
            'image' => 'image',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'disease-'.uniqid().'.'.strtolower($file->getClientOriginalExtension());
            $file->move(public_path('images/maladies'), $fileName);
            $data['image_path'] = 'images/maladies/'.$fileName;
        }

        return $data;
    }
}

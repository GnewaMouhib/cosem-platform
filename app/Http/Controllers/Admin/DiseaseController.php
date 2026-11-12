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
        'avoine' => 'Avoine',
    ];

    public function index(): View
    {
        return view('admin.maladies.index', ['diseases' => Disease::orderBy('category')->orderBy('name')->get(), 'crops' => self::CROPS]);
    }

    public function create(): View
    {
        return view('admin.maladies.create', ['crops' => self::CROPS]);
    }

    public function store(Request $request): RedirectResponse
    {
        $disease = Disease::create($this->validated($request));

        $label = $disease->isRavageur() ? 'Ravageur' : 'Maladie';
        return redirect()->route('admin.maladies.index')->with('success', "{$label} ajouté(e) avec succès.");
    }

    public function edit(Disease $disease): View
    {
        return view('admin.maladies.edit', ['disease' => $disease, 'crops' => self::CROPS]);
    }

    public function update(Request $request, Disease $disease): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteImage($disease);
        }

        $disease->update($data);

        $label = $disease->isRavageur() ? 'Ravageur' : 'Maladie';
        return redirect()->route('admin.maladies.index')->with('success', "{$label} modifié(e) avec succès.");
    }

    public function destroy(Disease $disease): RedirectResponse
    {
        $this->deleteImage($disease);
        $label = $disease->isRavageur() ? 'Ravageur' : 'Maladie';
        $disease->delete();

        return redirect()->route('admin.maladies.index')->with('success', "{$label} supprimé(e) avec succès.");
    }

    private function deleteImage(Disease $disease): void
    {
        if (! $disease->image_path) {
            return;
        }

        $fullPath = realpath(public_path($disease->image_path));
        $allowed = realpath(public_path('images/maladies'));

        if ($fullPath && $allowed && str_starts_with($fullPath, $allowed) && file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:maladie,ravageur'],
            'affected_crops' => ['required', 'array', 'min:1'],
            'affected_crops.*' => ['in:'.implode(',', array_keys(self::CROPS))],
            'period' => ['nullable', 'string', 'max:255'],
            'symptoms' => ['nullable', 'string'],
            'control_methods' => ['nullable', 'string'],
            'cultural_practices' => ['nullable', 'string'],
            'chemical_treatment' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ], [], [
            'name' => 'nom',
            'scientific_name' => 'nom scientifique',
            'category' => 'catégorie (maladie ou ravageur)',
            'affected_crops' => 'céréales sensibles',
            'period' => 'période à risque',
            'symptoms' => 'symptômes',
            'control_methods' => 'méthodes de lutte',
            'cultural_practices' => 'pratiques culturelles',
            'chemical_treatment' => 'traitement chimique',
            'image' => 'image',
        ]);

        if (!empty($data['affected_crops'])) {
            $data['target_crops'] = implode(', ', array_map(fn($k) => self::CROPS[$k] ?? $k, $data['affected_crops']));
        }

        if (!empty($data['control_methods']) && empty($data['chemical_treatment'])) {
            $data['chemical_treatment'] = $data['control_methods'];
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Extension derived from the detected MIME type, not from the client-supplied filename.
            $fileName = 'disease-'.uniqid().'.'.strtolower($file->extension());
            $file->move(public_path('images/maladies'), $fileName);
            $data['image_path'] = 'images/maladies/'.$fileName;
        }

        return $data;
    }
}

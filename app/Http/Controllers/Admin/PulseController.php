<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pulse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PulseController extends Controller
{
    public function index(): View
    {
        return view('admin.legumineuses.index', [
            'pulses' => Pulse::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.legumineuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request, 'pulse');
        }

        Pulse::create($data);

        return redirect()->route('admin.legumineuses.index')->with('success', 'Légumineuse ajoutée avec succès.');
    }

    public function edit(Pulse $pulse): View
    {
        return view('admin.legumineuses.edit', ['pulse' => $pulse]);
    }

    public function update(Request $request, Pulse $pulse): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $this->deleteImage($pulse);
            $data['image_path'] = $this->storeImage($request, 'pulse');
        }

        $pulse->update($data);

        return redirect()->route('admin.legumineuses.index')->with('success', 'Légumineuse modifiée avec succès.');
    }

    public function destroy(Pulse $pulse): RedirectResponse
    {
        $this->deleteImage($pulse);
        $pulse->delete();

        return redirect()->route('admin.legumineuses.index')->with('success', 'Légumineuse supprimée avec succès.');
    }

    private function deleteImage(Pulse $pulse): void
    {
        if (! $pulse->image_path) {
            return;
        }

        $fullPath = realpath(public_path($pulse->image_path));
        $allowed = realpath(public_path('images/varietes'));

        if ($fullPath && $allowed && str_starts_with($fullPath, $allowed) && file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    private function storeImage(Request $request, string $prefix): string
    {
        $file = $request->file('image');
        // Extension derived from the detected MIME type, not from the client-supplied filename.
        $name = $prefix.'-'.uniqid().'.'.strtolower($file->extension());
        $file->move(public_path('images/varietes'), $name);

        return 'images/varietes/'.$name;
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'variety' => ['nullable', 'string', 'max:255'],
            'optimal_cycle' => ['nullable', 'string', 'max:255'],
            'yield_potential' => ['nullable', 'string', 'max:255'],
            'disease_resistance' => ['nullable', 'string', 'max:255'],
            'grain_quality' => ['nullable', 'string', 'max:255'],
            'targeted_zone' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ], [], [
            'name' => 'nom',
            'variety' => 'variété',
            'optimal_cycle' => 'cycle optimal',
            'yield_potential' => 'potentiel de rendement',
            'disease_resistance' => 'résistance aux maladies',
            'grain_quality' => 'qualité du grain',
            'targeted_zone' => 'zone recommandée',
            'description' => 'description',
            'image' => 'image',
        ]);
    }
}

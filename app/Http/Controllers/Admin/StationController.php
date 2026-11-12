<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StationController extends Controller
{
    public const TYPES = [
        'conditioning_station' => 'Station de conditionnement',
        'storage_center' => 'Centre de stockage',
        'central_lab' => 'Laboratoire central',
        'specialized_station' => 'Station spécialisée',
        'regional_depot' => 'Dépôt régional',
        'warehouse' => 'Entrepôt / Dépôt',
        'multiplication_zone' => 'Zone de multiplication',
    ];

    public function index(): View
    {
        return view('admin.stations.index', [
            'stations' => Station::orderBy('name')->get(),
            'types' => self::TYPES,
        ]);
    }

    public function create(): View
    {
        return view('admin.stations.create', ['types' => self::TYPES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data += $this->handleUpload($request);
        }

        Station::create($data);

        return redirect()->route('admin.stations.index')->with('success', 'Station ajoutée avec succès.');
    }

    public function edit(Station $station): View
    {
        return view('admin.stations.edit', ['station' => $station, 'types' => self::TYPES]);
    }

    public function update(Request $request, Station $station): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $this->deleteImage($station);
            $data += $this->handleUpload($request);
        }

        $station->update($data);

        return redirect()->route('admin.stations.index')->with('success', 'Station modifiée avec succès.');
    }

    public function destroy(Station $station): RedirectResponse
    {
        $this->deleteImage($station);
        $station->delete();

        return redirect()->route('admin.stations.index')->with('success', 'Station supprimée avec succès.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:'.implode(',', array_keys(self::TYPES))],
            'badge' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'governorate' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'surface' => ['nullable', 'integer', 'min:0'],
            'installation_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'description' => ['nullable', 'string'],
        ], [
            'capacity.between' => 'La capacité doit être un nombre positif.',
            'latitude.between' => 'La latitude doit être comprise entre -90 et 90.',
            'longitude.between' => 'La longitude doit être comprise entre -180 et 180.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPG, PNG ou WebP.',
            'image.max' => 'L\'image ne doit pas dépasser 10 Mo.',
        ], [
            'name' => 'nom',
            'type' => 'type',
            'badge' => 'badge',
            'city' => 'ville',
            'governorate' => 'gouvernorat',
            'capacity' => 'capacité (QX)',
            'surface' => 'surface (m²)',
            'installation_year' => 'année d\'installation',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'description' => 'description',
            'image' => 'photo',
        ]);
    }

    private function handleUpload(Request $request): array
    {
        if (! $request->hasFile('image')) {
            return [];
        }

        $file = $request->file('image');
        // Extension derived from the detected MIME type, not from the client-supplied filename.
        $fileName = 'station-'.uniqid().'.'.strtolower($file->extension());
        $file->move(public_path('images/stations'), $fileName);

        return ['image_path' => 'images/stations/'.$fileName];
    }

    private function deleteImage(Station $station): void
    {
        if (! $station->image_path) {
            return;
        }

        $fullPath = realpath(public_path($station->image_path));
        $allowed = realpath(public_path('images/stations'));

        if ($fullPath && $allowed && str_starts_with($fullPath, $allowed) && file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
}

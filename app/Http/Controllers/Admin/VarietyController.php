<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cereal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VarietyController extends Controller
{
    public const CATEGORIES = [
        'ble_dur' => 'Blé Dur',
        'ble_tendre' => 'Blé Tendre',
        'orge' => 'Orge',
        'triticale' => 'Triticale',
    ];

    public function index(Request $request): View
    {
        $filter = $request->query('categorie', 'tous');

        $cerealsQuery = Cereal::orderBy('category')->orderBy('order_index');

        if (in_array($filter, array_keys(self::CATEGORIES), true)) {
            $cerealsQuery->where('category', $filter);
        }

        return view('admin.varietes.index', [
            'cereals' => $cerealsQuery->get(),
            'filter' => $filter,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function create(): View
    {
        return view('admin.varietes.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request, 'cereal');
        }

        Cereal::create($data);

        return redirect()->route('admin.cereales.index')->with('success', 'Variété ajoutée avec succès.');
    }

    public function edit(Cereal $cereal): View
    {
        return view('admin.varietes.edit', ['cereal' => $cereal, 'categories' => self::CATEGORIES]);
    }

    public function update(Request $request, Cereal $cereal): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request, 'cereal');
        }

        $cereal->update($data);

        return redirect()->route('admin.cereales.index')->with('success', 'Variété modifiée avec succès.');
    }

    public function destroy(Cereal $cereal): RedirectResponse
    {
        if ($cereal->image_path && str_starts_with($cereal->image_path, 'images/') && file_exists(public_path($cereal->image_path))) {
            @unlink(public_path($cereal->image_path));
        }

        $cereal->delete();

        return redirect()->route('admin.cereales.index')->with('success', 'Variété supprimée avec succès.');
    }

    private function storeImage(Request $request, string $prefix): string
    {
        $file = $request->file('image');
        $name = $prefix.'-'.uniqid().'.'.strtolower($file->getClientOriginalExtension());
        $file->move(public_path('images/varietes'), $name);

        return 'images/varietes/'.$name;
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category' => ['required', 'in:'.implode(',', array_keys(self::CATEGORIES))],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'breeder' => ['nullable', 'string', 'max:255'],
            'optimal_cycle' => ['nullable', 'string', 'max:255'],
            'yield_potential' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'disease_resistance' => ['nullable', 'string', 'max:255'],
            'targeted_zone' => ['nullable', 'string', 'max:255'],
            'grain_quality' => ['nullable', 'string', 'max:255'],
            'order_index' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ], [], [
            'category' => 'catégorie',
            'name' => 'nom',
            'type' => 'type',
            'breeder' => 'obtenteur',
            'optimal_cycle' => 'cycle optimal',
            'yield_potential' => 'potentiel de rendement',
            'description' => 'description',
            'disease_resistance' => 'résistance aux maladies',
            'targeted_zone' => 'zone ciblée',
            'grain_quality' => 'qualité du grain',
            'order_index' => 'ordre d\'affichage',
            'image' => 'image',
        ]) + [
            'order_index' => $request->input('order_index') ?: 0,
        ];
    }
}

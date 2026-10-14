<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnualStat;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CampagneController extends Controller
{
    public function index(): View
    {
        return view('admin.campagnes.index', [
            'years' => Year::withCount('annualStats')->orderByDesc('harvest_year')->get(),
            'analytics' => Year::chartSeries(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20', 'unique:years,name'],
            'harvest_year' => ['required', 'integer', 'min:1950', 'max:2100'],
            'notes' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.unique' => 'Une campagne porte déjà ce nom.',
        ], [
            'name' => 'libellé',
            'harvest_year' => 'année de récolte',
            'notes' => 'notes',
        ]);

        DB::transaction(function () use ($data) {
            if (! empty($data['is_active'])) {
                Year::query()->update(['is_active' => false]);
            }

            Year::create($data + ['is_active' => (bool) ($data['is_active'] ?? false)]);
        });

        return redirect()->route('admin.campagnes.index')->with('success', 'Campagne créée avec succès. Vous pouvez maintenant saisir ses statistiques.');
    }

    public function edit(Year $year): View
    {
        return view('admin.campagnes.edit', [
            'year' => $year,
            'stats' => $year->annualStats()->first(),
        ]);
    }

    public function update(Request $request, Year $year): RedirectResponse
    {
        $data = $request->validate([
            'durum_wheat_qx' => ['required', 'numeric', 'min:0'],
            'soft_wheat_qx' => ['required', 'numeric', 'min:0'],
            'barley_qx' => ['required', 'numeric', 'min:0'],
            'oats_qx' => ['nullable', 'numeric', 'min:0'],
            'pulses_qx' => ['required', 'numeric', 'min:0'],
            'total_hectares' => ['required', 'numeric', 'min:0'],
            'total_multipliers' => ['required', 'integer', 'min:0'],
            'member_multipliers' => ['nullable', 'integer', 'min:0'],
            'certified_seed_pct' => ['nullable', 'numeric', 'between:0,100'],
            'prebasic_seed_pct' => ['nullable', 'numeric', 'between:0,100'],
            'financing_partner' => ['nullable', 'string', 'max:255'],
        ], [], [
            'durum_wheat_qx' => 'blé dur (QX)',
            'soft_wheat_qx' => 'blé tendre (QX)',
            'barley_qx' => 'orge (QX)',
            'oats_qx' => 'avoine (QX)',
            'pulses_qx' => 'légumineuses (QX)',
            'total_hectares' => 'superficie totale',
            'total_multipliers' => 'multiplicateurs',
            'member_multipliers' => 'multiplicateurs membres',
            'certified_seed_pct' => 'semences certifiées (%)',
            'prebasic_seed_pct' => 'semences prébasiques (%)',
            'financing_partner' => 'partenaire de financement',
        ]) + ['oats_qx' => $request->input('oats_qx') ?: 0];

        AnnualStat::updateOrCreate(['year_id' => $year->id], $data);

        return redirect()->route('admin.campagnes.edit', $year)->with('success', 'Statistiques de la campagne '.$year->name.' modifiées avec succès.');
    }

    public function toggleActive(Year $year): RedirectResponse
    {
        if ($year->is_active) {
            $year->update(['is_active' => false]);

            return redirect()->route('admin.campagnes.index')->with('success', 'La campagne '.$year->name.' n\'est plus active.');
        }

        DB::transaction(function () use ($year) {
            Year::query()->update(['is_active' => false]);
            $year->update(['is_active' => true]);
        });

        return redirect()->route('admin.campagnes.index')->with('success', 'La campagne '.$year->name.' est maintenant la campagne active.');
    }

    public function destroy(Year $year): RedirectResponse
    {
        $year->annualStats()->delete();
        $year->delete();

        return redirect()->route('admin.campagnes.index')->with('success', 'Campagne supprimée avec succès.');
    }
}

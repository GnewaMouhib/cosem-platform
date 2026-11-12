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
        $existing = $year->annualStats()->first();

        $data = $request->validate([
            'durum_wheat_qx' => ['required', 'numeric', 'min:0'],
            'soft_wheat_qx' => ['required', 'numeric', 'min:0'],
            'barley_qx' => ['required', 'numeric', 'min:0'],
            'oats_qx' => ['nullable', 'numeric', 'min:0'],
            'feves_qx' => ['nullable', 'numeric', 'min:0'],
            'pois_chiches_qx' => ['nullable', 'numeric', 'min:0'],
            'feveroles_qx' => ['nullable', 'numeric', 'min:0'],
            'lentilles_qx' => ['nullable', 'numeric', 'min:0'],
            'pulses_qx' => ['nullable', 'numeric', 'min:0'],
            'total_hectares' => ['required', 'numeric', 'min:0'],
            'total_multipliers' => ['nullable', 'integer', 'min:0'],
            'member_multipliers' => ['nullable', 'integer', 'min:0'],
            'certified_seed_pct' => ['nullable', 'numeric', 'between:0,100'],
            'prebasic_seed_pct' => ['nullable', 'numeric', 'between:0,100'],
            'financing_partner' => ['nullable', 'string', 'max:255'],
        ], [], [
            'durum_wheat_qx' => 'blé dur (QX)',
            'soft_wheat_qx' => 'blé tendre (QX)',
            'barley_qx' => 'orge (QX)',
            'oats_qx' => 'avoine (QX)',
            'feves_qx' => 'fèves (QX)',
            'pois_chiches_qx' => 'pois chiches (QX)',
            'feveroles_qx' => 'féveroles (QX)',
            'lentilles_qx' => 'lentilles (QX)',
            'pulses_qx' => 'légumineuses (QX)',
            'total_hectares' => 'superficie totale (Ha)',
            'total_multipliers' => 'multiplicateurs',
            'member_multipliers' => 'multiplicateurs membres',
            'certified_seed_pct' => 'semences certifiées (%)',
            'prebasic_seed_pct' => 'semences prébasiques (%)',
            'financing_partner' => 'partenaire de financement',
        ]);

        $data['oats_qx'] = (float) ($data['oats_qx'] ?? $existing?->oats_qx ?? 0);
        $data['feves_qx'] = (float) ($data['feves_qx'] ?? $existing?->feves_qx ?? 0);
        $data['pois_chiches_qx'] = (float) ($data['pois_chiches_qx'] ?? $existing?->pois_chiches_qx ?? 0);
        $data['feveroles_qx'] = (float) ($data['feveroles_qx'] ?? $existing?->feveroles_qx ?? 0);
        $data['lentilles_qx'] = (float) ($data['lentilles_qx'] ?? $existing?->lentilles_qx ?? 0);

        $legumeSum = $data['feves_qx'] + $data['pois_chiches_qx'] + $data['feveroles_qx'] + $data['lentilles_qx'];
        $data['pulses_qx'] = $legumeSum > 0 ? $legumeSum : (float) ($data['pulses_qx'] ?? $existing?->pulses_qx ?? 0);

        $data['total_multipliers'] = (int) ($data['total_multipliers'] ?? $existing?->total_multipliers ?? 0);
        $data['member_multipliers'] = (int) ($data['member_multipliers'] ?? $existing?->member_multipliers ?? 0);
        $data['certified_seed_pct'] = (float) ($data['certified_seed_pct'] ?? $existing?->certified_seed_pct ?? 0);
        $data['prebasic_seed_pct'] = (float) ($data['prebasic_seed_pct'] ?? $existing?->prebasic_seed_pct ?? 0);

        AnnualStat::updateOrCreate(['year_id' => $year->id], $data);

        return redirect()->back()->with('success', 'Statistiques de la campagne '.$year->name.' enregistrées avec succès.');
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

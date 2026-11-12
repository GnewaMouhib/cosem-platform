<?php

namespace App\Http\Controllers;

use App\Models\Cereal;
use App\Models\Station;
use App\Models\Year;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $years = Year::with('annualStats')->orderByDesc('harvest_year')->get();

        // $years already eager-loads annualStats, so the requested campaign is looked up
        // in that collection instead of paying for a second identical query.
        $selectedYear = $request->filled('campagne')
            ? $years->firstWhere('id', $request->integer('campagne'))
            : null;

        $activeYear = $selectedYear
            ?? $years->firstWhere('is_active', true)
            ?? $years->first();

        $stats = $activeYear?->annualStats->first();
        $stations = Station::all();
        $varietyCounts = Cereal::selectRaw('category, COUNT(*) as total')->groupBy('category')->pluck('total', 'category');

        $campaigns = $years->map(function (Year $y) {
            $s = $y->annualStats->first();

            // Céréales
            $durum = (float) ($s?->durum_wheat_qx ?? 215000);
            $soft = (float) ($s?->soft_wheat_qx ?? 8000);
            $barley = (float) ($s?->barley_qx ?? 7000);
            $oats = (float) ($s?->oats_qx ?? 3000);
            $cerealsTotal = $durum + $soft + $barley + $oats;

            // Légumineuses
            $feves = (float) ($s?->feves_qx ?? 850);
            $chickpeas = (float) ($s?->pois_chiches_qx ?? 650);
            $feveroles = (float) ($s?->feveroles_qx ?? 350);
            $lentilles = (float) ($s?->lentilles_qx ?? 150);
            $pulsesTotal = $feves + $chickpeas + $feveroles + $lentilles;
            if ($pulsesTotal <= 0 && ($s?->pulses_qx ?? 0) > 0) {
                $pulsesTotal = (float) $s->pulses_qx;
                // Proportions de secours si breakdown vide
                $feves = round($pulsesTotal * 0.425, 2);
                $chickpeas = round($pulsesTotal * 0.325, 2);
                $feveroles = round($pulsesTotal * 0.175, 2);
                $lentilles = round($pulsesTotal - ($feves + $chickpeas + $feveroles), 2);
            }

            return [
                'id' => $y->id,
                'name' => $y->name,
                'is_active' => (bool) $y->is_active,
                // Compteurs globaux
                'cereals_k' => (int) round($cerealsTotal / 1000),
                'cereals_total' => (int) round($cerealsTotal),
                'pulses_total' => (int) round($pulsesTotal),
                'hectares_k' => (int) round(($s?->total_hectares ?? 11000) / 1000),
                'hectares_raw' => (int) round($s?->total_hectares ?? 11000),
                'cert_pct' => (float) ($s?->certified_seed_pct ?? 85.0),
                // Donut 1 : Céréales (Blé Dur, Blé Tendre, Orge, Avoine)
                'durum' => (int) round($durum),
                'soft' => (int) round($soft),
                'barley' => (int) round($barley),
                'oats' => (int) round($oats),
                'cereals_chart' => [$durum, $soft, $barley, $oats],
                // Donut 2 : Légumineuses (Fèves, Pois chiches, Féveroles, Lentilles)
                'feves' => (int) round($feves),
                'chickpeas' => (int) round($chickpeas),
                'feveroles' => (int) round($feveroles),
                'lentilles' => (int) round($lentilles),
                'pulses_chart' => [$feves, $chickpeas, $feveroles, $lentilles],
            ];
        })->values();

        return view('pages.home', compact('years', 'activeYear', 'stats', 'stations', 'varietyCounts', 'campaigns'));
    }
}

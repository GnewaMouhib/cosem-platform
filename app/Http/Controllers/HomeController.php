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

        $selectedYear = $request->filled('campagne')
            ? Year::with('annualStats')->find($request->integer('campagne'))
            : null;

        $activeYear = $selectedYear
            ?? Year::active()->with('annualStats')->first()
            ?? $years->first();

        $stats = $activeYear?->annualStats->first();
        $stations = Station::all();
        $varietyCounts = Cereal::selectRaw('category, COUNT(*) as total')->groupBy('category')->pluck('total', 'category');

        $campaigns = $years->map(function (Year $y) {
            $s = $y->annualStats->first();

            return [
                'id' => $y->id,
                'name' => $y->name,
                'is_active' => (bool) $y->is_active,
                'durum_k' => (int) round(($s->durum_wheat_qx ?? 215000) / 1000),
                'hectares_k' => (int) round(($s->total_hectares ?? 11000) / 1000),
                'soft' => (int) round($s->soft_wheat_qx ?? 8000),
                'barley' => (int) round($s->barley_qx ?? 7000),
                'pulses' => (int) round($s->pulses_qx ?? 2000),
                'chart' => [
                    (float) ($s->durum_wheat_qx ?? 215000),
                    (float) ($s->soft_wheat_qx ?? 8000),
                    (float) ($s->barley_qx ?? 7000),
                    (float) ($s->oats_qx ?? 3000),
                    (float) ($s->pulses_qx ?? 2000),
                ],
            ];
        })->values();

        return view('pages.home', compact('years', 'activeYear', 'stats', 'stations', 'varietyCounts', 'campaigns'));
    }
}

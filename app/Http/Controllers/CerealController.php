<?php

namespace App\Http\Controllers;

use App\Models\Cereal;
use App\Models\Pulse;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CerealController extends Controller
{
    public function index()
    {
        $cereals = Cereal::orderBy('category')->orderBy('order_index')->get();

        return view('pages.cereales', compact('cereals'));
    }

    public function pulses()
    {
        $pulses = Pulse::orderBy('name')->get();

        return view('pages.legumineuses', compact('pulses'));
    }

    public function downloadPdf(Cereal $cereal)
    {
        $year = Year::active()->first() ?? Year::latest('harvest_year')->first();

        $data = [
            'type' => 'cereal',
            'variety' => $cereal,
            'species' => $this->speciesLabel($cereal->category),
            'subline' => $cereal->type,
            'density' => $this->densityRange($cereal->category),
            'campaign' => $year?->name ?? '—',
            'logoBase64' => 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/cosem-logo.png'))),
        ];

        $pdf = Pdf::loadView('pdfs.variete', $data)->setPaper('a4');

        return $pdf->download('fiche-technique-'.Str::slug($cereal->name).'.pdf');
    }

    public function downloadPulsePdf(Pulse $legume)
    {
        $year = Year::active()->first() ?? Year::latest('harvest_year')->first();

        $data = [
            'type' => 'pulse',
            'variety' => $legume,
            'species' => 'Légumineuse',
            'subline' => $legume->name.' — '.$legume->variety,
            'density' => '100 à 120 kg/Ha',
            'campaign' => $year?->name ?? '—',
            'logoBase64' => 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/cosem-logo.png'))),
        ];

        $pdf = Pdf::loadView('pdfs.variete', $data)->setPaper('a4');

        return $pdf->download('fiche-technique-'.Str::slug($legume->name).'.pdf');
    }

    private function speciesLabel(string $category): string
    {
        return match ($category) {
            'ble_dur' => 'Blé Dur',
            'ble_tendre' => 'Blé Tendre',
            'orge' => 'Orge',
            'triticale' => 'Triticale',
            default => ucfirst(str_replace('_', ' ', $category)),
        };
    }

    private function densityRange(string $category): string
    {
        return match ($category) {
            'ble_dur' => '280 à 320 grains/m² (Bour favorable) · 250 à 280 (Semi-aride) · 320 à 350 (Irrigué)',
            'ble_tendre' => '280 à 320 grains/m² (soit 140 à 160 kg/Ha)',
            'orge' => '250 grains/m² en moyenne (soit 110 à 130 kg/Ha)',
            'triticale' => '280 à 320 grains/m² (soit 140 à 150 kg/Ha)',
            default => 'Selon l\'itinéraire technique officiel de l\'INGC',
        };
    }
}

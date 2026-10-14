<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cereal;
use App\Models\ContactsMessage;
use App\Models\Disease;
use App\Models\Pulse;
use App\Models\Station;
use App\Models\Year;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeYear = Year::where('is_active', true)->first();
        $stats = $activeYear?->annualStats()->first();

        return view('admin.dashboard', [
            'activeYear' => $activeYear,
            'stats' => $stats,
            'cerealCount' => Cereal::count(),
            'pulseCount' => Pulse::count(),
            'stationCount' => Station::count(),
            'diseaseCount' => Disease::count(),
            'unreadCount' => ContactsMessage::where('is_read', false)->count(),
            'latestMessages' => ContactsMessage::latest()->take(5)->get(),
            'analytics' => Year::chartSeries(),
        ]);
    }
}

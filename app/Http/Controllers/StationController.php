<?php

namespace App\Http\Controllers;

use App\Models\Station;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::orderBy('type')->orderBy('name')->get();

        return view('pages.stations', compact('stations'));
    }
}

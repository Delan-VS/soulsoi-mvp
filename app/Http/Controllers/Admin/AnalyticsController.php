<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\SoilReport;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('admin.analytics', [
            'active_sensors' => Sensor::where('status', 'Active')->count(),
            'total_sensors' => Sensor::count(),
            'avg_ph' => round(SoilReport::avg('ph_level') ?? 6.2, 1),
            'avg_moisture' => round(SoilReport::avg('moisture') ?? 55.4, 1),
        ]);
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Sensor;
use App\Models\SoilReport;
use App\Models\Crop;
use BackedEnum;

class Analytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected string $view = 'filament.pages.analytics';

    protected static ?string $title = 'Analytics';

    public function getViewData(): array
    {
        return [
            'activeSensorsCount' => Sensor::where('status', 'Active')->count(),
            'sensorsCount' => Sensor::count(),
            'soilReportsCount' => SoilReport::count(),
            'cropsCount' => Crop::count(),
            'avgPh' => round(SoilReport::avg('ph_level') ?? 6.2, 1),
            'avgMoisture' => round(SoilReport::avg('moisture') ?? 55.4, 1),
        ];
    }
}

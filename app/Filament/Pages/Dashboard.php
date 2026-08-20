<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Farmer;
use App\Models\Farm;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard';

    // Disable default widgets
    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getFooterWidgets(): array
    {
        return [];
    }

    public function getViewData(): array
    {
        return [
            'pendingFarmersCount' => Farmer::where('overall_status', 'pending')->count(),
            'pendingFarmsCount' => Farm::where('status', 'pending')->count(),
            'approvedFarmersCount' => Farmer::where('overall_status', 'approved')->count(),
            'activeFarmsCount' => Farm::where('status', 'approved')->count(),
            'recentFarmers' => Farmer::where('overall_status', 'pending')->latest()->take(3)->get(),
            'recentFarms' => Farm::where('status', 'pending')->latest()->take(3)->get(),
        ];
    }
}

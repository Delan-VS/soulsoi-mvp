<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use BackedEnum;

class Settings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.settings';

    protected static ?string $title = 'Settings';

    public $site_name = 'SoulSoil';
    public $system_email = 'admin@soulsoil.com';
    public $sensor_interval = 15;
    public $notify_threshold = 40.0;

    public function mount(): void
    {
        // Set default values or load from database settings table
    }

    public function save(): void
    {
        Notification::make()
            ->title('Settings Saved')
            ->success()
            ->send();
    }
}

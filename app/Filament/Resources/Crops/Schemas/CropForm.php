<?php

namespace App\Filament\Resources\Crops\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CropForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('scientific_name'),
                TextInput::make('ideal_ph_min')
                    ->required()
                    ->numeric()
                    ->default(6),
                TextInput::make('ideal_ph_max')
                    ->required()
                    ->numeric()
                    ->default(7.5),
                TextInput::make('ideal_moisture_min')
                    ->required()
                    ->numeric()
                    ->default(40),
                TextInput::make('ideal_moisture_max')
                    ->required()
                    ->numeric()
                    ->default(80),
                TextInput::make('growth_duration_days')
                    ->numeric(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}

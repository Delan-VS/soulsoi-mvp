<?php

namespace App\Filament\Resources\Farms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class FarmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('farmer_id')
                    ->relationship('farmer', 'full_name')
                    ->searchable()
                    ->required(),
                Select::make('primary_crop')
                    ->options(\App\Models\Crop::pluck('name', 'name')->toArray())
                    ->searchable()
                    ->required(),

                TextInput::make('total_acres')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }
}

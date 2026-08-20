<?php

namespace App\Filament\Resources\Farmers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class FarmerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('user.email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(
                        table: \App\Models\User::class, 
                        column: 'email',
                        ignorable: fn ($record) => $record?->user
                    )
                    ->maxLength(255),
                TextInput::make('user.phone')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->regex('/^[0-9]{10}$/')
                    ->maxLength(10),
                TextInput::make('district')
                    ->required(),
                TextInput::make('state')
                    ->required(),
                Select::make('overall_status')
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

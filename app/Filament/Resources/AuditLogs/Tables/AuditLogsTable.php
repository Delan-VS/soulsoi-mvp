<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user_name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('action')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

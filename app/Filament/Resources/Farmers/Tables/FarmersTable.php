<?php

namespace App\Filament\Resources\Farmers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class FarmersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('district')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('state')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('overall_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->overall_status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'overall_status' => 'approved',
                            'reviewed_by_id' => Auth::id(),
                            'reviewed_at' => now(),
                            'face_verification' => 'completed',
                            'mobile_verification' => 'completed',
                            'bank_verification' => 'completed',
                            'document_verification' => 'completed',
                        ]);
                    }),
                Action::make('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('admin_notes')
                            ->label('Reason for Rejection')
                            ->required(),
                    ])
                    ->visible(fn($record) => $record->overall_status === 'pending')
                    ->action(function (array $data, $record) {
                        $record->update([
                            'overall_status' => 'rejected',
                            'reviewed_by_id' => Auth::id(),
                            'reviewed_at' => now(),
                            'admin_notes' => $data['admin_notes'],
                        ]);
                    }),
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

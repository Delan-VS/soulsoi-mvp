<?php

namespace App\Filament\Resources\Farmers\Pages;

use App\Filament\Resources\Farmers\FarmerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmer extends EditRecord
{
    protected static string $resource = FarmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $farmer = $this->getRecord();
        $user = $farmer->user;
        
        if ($user) {
            $data['user'] = [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ];
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $farmer = $this->getRecord();
        $user = $farmer->user;
        
        if ($user && isset($data['user'])) {
            $user->update([
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
                'phone' => $data['user']['phone'] ?? null,
            ]);
            $data['full_name'] = $data['user']['name'];
        }
        
        unset($data['user']);
        
        return $data;
    }
}

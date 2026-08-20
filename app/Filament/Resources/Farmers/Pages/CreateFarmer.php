<?php

namespace App\Filament\Resources\Farmers\Pages;

use App\Filament\Resources\Farmers\FarmerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFarmer extends CreateRecord
{
    protected static string $resource = FarmerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = \App\Models\User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'phone' => $data['user']['phone'] ?? null,
            'password' => bcrypt('password'), // Or generate a random password
        ]);
        
        $data['user_id'] = $user->id;
        $data['full_name'] = $data['user']['name']; // Ensure full_name matches user.name just in case
        
        unset($data['user']);
        
        return $data;
    }
}

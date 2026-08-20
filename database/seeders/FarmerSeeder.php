<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
    public function run(): void
    {
        // Create Farmer User
        $user = User::firstOrCreate(
            ['email' => 'farmer@soulsoil.com'],
            [
                'name' => 'John Farmer',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // Create associated Farmer Profile
        Farmer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => 'John Farmer',
                'dob' => '1980-01-01',
                'aadhar_number' => '123412341234',
                'address' => '123 Agri Lane',
                'village' => 'Farmville',
                'district' => 'AgriDistrict',
                'state' => 'Kerala',
                'bank_name' => 'State Bank',
                'account_holder_name' => 'John Farmer',
                'account_number' => '0000000000',
                'ifsc_code' => 'SBIN0000000',
                'overall_status' => 'approved',
                'reviewed_at' => now(),
            ]
        );

        // Pending Farmer
        $pendingUser = User::firstOrCreate(
            ['email' => 'pending_farmer@soulsoil.com'],
            [
                'name' => 'Pending Farmer',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        Farmer::firstOrCreate(
            ['user_id' => $pendingUser->id],
            [
                'full_name' => 'Pending Farmer',
                'dob' => '1990-01-01',
                'aadhar_number' => '098709870987',
                'address' => '456 Wait Street',
                'village' => 'Holdville',
                'district' => 'WaitDistrict',
                'state' => 'Punjab',
                'bank_name' => 'HDFC Bank',
                'account_holder_name' => 'Pending Farmer',
                'account_number' => '1111111111',
                'ifsc_code' => 'HDFC0001111',
                'overall_status' => 'pending',
            ]
        );
    }
}

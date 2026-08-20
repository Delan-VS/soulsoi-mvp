<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Investment;
use App\Models\Farm;
use Illuminate\Support\Facades\Hash;

class InvestorSeeder extends Seeder
{
    public function run(): void
    {
        // Create Investor User
        $investor = User::firstOrCreate(
            ['email' => 'investor@soulsoil.com'],
            [
                'name' => 'Alice Investor',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // Find an open farm to invest in
        $farm = Farm::where('name', 'Green Acres Organic')->first();
        
        if ($farm) {
            // Create a dummy investment
            Investment::firstOrCreate(
                ['user_id' => $investor->id, 'farm_id' => $farm->id],
                [
                    'amount' => 5000,
                    'status' => 'pending',
                    'payment_method' => 'Bank Transfer'
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Farm;
use App\Models\Farmer;

class FarmSeeder extends Seeder
{
    public function run(): void
    {
        $farmer = Farmer::where('full_name', 'John Farmer')->first();
        
        if (!$farmer) return;

        // Approved and Open Farm
        Farm::firstOrCreate(
            ['name' => 'Green Acres Organic'],
            [
                'farmer_id' => $farmer->id,
                'total_acres' => 15.5,
                'primary_crop' => 'Organic Wheat',
                'status' => 'approved',
                'funding_target' => 50000,
                'funding_raised' => 10000,
                'investor_count' => 2,
            ]
        );
        
        // Pending Farm
        Farm::firstOrCreate(
            ['name' => 'Sunrise Wheat Fields'],
            [
                'farmer_id' => $farmer->id,
                'total_acres' => 50.0,
                'primary_crop' => 'Traditional Rice',
                'status' => 'pending',
                'funding_target' => 100000,
                'funding_raised' => 0,
                'investor_count' => 0,
            ]
        );
    }
}

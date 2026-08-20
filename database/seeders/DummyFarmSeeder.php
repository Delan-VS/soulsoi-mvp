<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyFarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farmer = \App\Models\Farmer::first();
        if (!$farmer) {
            return;
        }

        // Green Valley Organic Vineyard
        \App\Models\Farm::create([
            'farmer_id' => $farmer->id,
            'name' => 'Green Valley Organic Vineyard',
            'location' => 'Sonoma Valley, California',
            'primary_crop' => 'Organic Grapes',
            'listing_category' => 'Fruits',
            'total_acres' => 42.5,
            'funding_target' => 6240000,
            'expected_roi' => 18.5,
            'yielding_period' => 12,
            'expected_start_date' => now()->addDays(15),
            'min_investment' => 10000,
            'max_investment' => 1000000,
            'status' => 'approved',
            'farm_photo_path' => 'farms/dummy1.jpg',
            'budget_breakdown' => [
                ['purpose' => 'Organic Vines & Trellising', 'amount' => 2400000],
                ['purpose' => 'Smart Irrigation System', 'amount' => 1800000],
                ['purpose' => 'Labor & Certification', 'amount' => 2040000]
            ],
            'farming_timeline' => [
                ['name' => 'Soil Preparation', 'start' => 0, 'end' => 1],
                ['name' => 'Planting', 'start' => 1, 'end' => 2],
                ['name' => 'Growth & Pruning', 'start' => 2, 'end' => 9],
                ['name' => 'Harvest', 'start' => 10, 'end' => 12]
            ]
        ]);

        // North Ridge Farm
        \App\Models\Farm::create([
            'farmer_id' => $farmer->id,
            'name' => 'North Ridge Farm',
            'location' => 'Punjab, India',
            'primary_crop' => 'Basmati Rice',
            'listing_category' => 'Paddy',
            'total_acres' => 125,
            'funding_target' => 12415000,
            'expected_roi' => 14.2,
            'yielding_period' => 6,
            'expected_start_date' => now()->addDays(30),
            'min_investment' => 50000,
            'max_investment' => 2500000,
            'status' => 'approved',
            'farm_photo_path' => 'farms/dummy2.jpg',
            'budget_breakdown' => [
                ['purpose' => 'Seeds & Land Prep', 'amount' => 4500000],
                ['purpose' => 'Labor', 'amount' => 3500000],
                ['purpose' => 'Equipment & Harvesting', 'amount' => 4415000]
            ],
            'farming_timeline' => [
                ['name' => 'Land Preparation', 'start' => 0, 'end' => 1],
                ['name' => 'Sowing', 'start' => 1, 'end' => 2],
                ['name' => 'Growth', 'start' => 2, 'end' => 5],
                ['name' => 'Harvest', 'start' => 5, 'end' => 6]
            ]
        ]);
        
        // Marigold Meadows
        \App\Models\Farm::create([
            'farmer_id' => $farmer->id,
            'name' => 'Marigold Meadows',
            'location' => 'Karnataka, India',
            'primary_crop' => 'Saffron',
            'listing_category' => 'Spices',
            'total_acres' => 15,
            'funding_target' => 11200000,
            'expected_roi' => 22.5,
            'yielding_period' => 9,
            'expected_start_date' => now()->addDays(10),
            'min_investment' => 25000,
            'max_investment' => 1000000,
            'status' => 'pending',
            'budget_breakdown' => [
                ['purpose' => 'Premium Bulbs', 'amount' => 5000000],
                ['purpose' => 'Climate Control', 'amount' => 4200000],
                ['purpose' => 'Specialized Labor', 'amount' => 2000000]
            ],
            'farming_timeline' => [
                ['name' => 'Setup', 'start' => 0, 'end' => 2],
                ['name' => 'Growth', 'start' => 2, 'end' => 7],
                ['name' => 'Processing', 'start' => 7, 'end' => 9]
            ]
        ]);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add benchmark ranges to crops table
        Schema::table('crops', function (Blueprint $table) {
            if (!Schema::hasColumn('crops', 'min_yield_per_acre')) {
                $table->decimal('min_yield_per_acre', 10, 2)->nullable()->after('growth_duration_days');
            }
            if (!Schema::hasColumn('crops', 'max_yield_per_acre')) {
                $table->decimal('max_yield_per_acre', 10, 2)->nullable()->after('min_yield_per_acre');
            }
            if (!Schema::hasColumn('crops', 'min_price_per_kg')) {
                $table->decimal('min_price_per_kg', 10, 2)->nullable()->after('max_yield_per_acre');
            }
            if (!Schema::hasColumn('crops', 'max_price_per_kg')) {
                $table->decimal('max_price_per_kg', 10, 2)->nullable()->after('min_price_per_kg');
            }
        });

        // 2. Add farm financials and ROI audit fields to farms table
        Schema::table('farms', function (Blueprint $table) {
            if (!Schema::hasColumn('farms', 'total_budget')) {
                $table->decimal('total_budget', 12, 2)->default(0)->after('funding_target');
            }
            if (!Schema::hasColumn('farms', 'calculated_roi')) {
                $table->decimal('calculated_roi', 6, 2)->nullable()->after('expected_roi');
            }
            if (!Schema::hasColumn('farms', 'annualized_roi')) {
                $table->decimal('annualized_roi', 6, 2)->nullable()->after('calculated_roi');
            }
            if (!Schema::hasColumn('farms', 'is_roi_overridden')) {
                $table->boolean('is_roi_overridden')->default(false)->after('annualized_roi');
            }
            if (!Schema::hasColumn('farms', 'roi_override_reason')) {
                $table->text('roi_override_reason')->nullable()->after('is_roi_overridden');
            }
            if (!Schema::hasColumn('farms', 'projected_yield_kg')) {
                $table->decimal('projected_yield_kg', 10, 2)->nullable()->after('roi_override_reason');
            }
            if (!Schema::hasColumn('farms', 'projected_price_per_kg')) {
                $table->decimal('projected_price_per_kg', 10, 2)->nullable()->after('projected_yield_kg');
            }
            if (!Schema::hasColumn('farms', 'projected_revenue')) {
                $table->decimal('projected_revenue', 12, 2)->nullable()->after('projected_price_per_kg');
            }
            if (!Schema::hasColumn('farms', 'projected_net_profit')) {
                $table->decimal('projected_net_profit', 12, 2)->nullable()->after('projected_revenue');
            }
            if (!Schema::hasColumn('farms', 'investor_profit_share')) {
                $table->decimal('investor_profit_share', 12, 2)->nullable()->after('projected_net_profit');
            }
            if (!Schema::hasColumn('farms', 'farmer_profit_share')) {
                $table->decimal('farmer_profit_share', 12, 2)->nullable()->after('investor_profit_share');
            }
            if (!Schema::hasColumn('farms', 'crop_cycle_days')) {
                $table->integer('crop_cycle_days')->nullable()->after('farmer_profit_share');
            }
            if (!Schema::hasColumn('farms', 'yield_shortfall_percent')) {
                $table->decimal('yield_shortfall_percent', 5, 2)->nullable()->after('crop_cycle_days');
            }
        });

        // 3. Seed / Update standard crop benchmark data
        $cropsData = [
            [
                'name' => 'Paddy',
                'scientific_name' => 'Oryza sativa',
                'growth_duration_days' => 120,
                'min_yield_per_acre' => 1800.00,
                'max_yield_per_acre' => 2800.00,
                'min_price_per_kg' => 20.00,
                'max_price_per_kg' => 35.00,
                'ideal_ph_min' => 5.50,
                'ideal_ph_max' => 6.50,
                'ideal_moisture_min' => 60.00,
                'ideal_moisture_max' => 90.00,
                'description' => 'Wetland staple cereal crop requiring consistent seasonal water table.',
            ],
            [
                'name' => 'Wheat',
                'scientific_name' => 'Triticum aestivum',
                'growth_duration_days' => 135,
                'min_yield_per_acre' => 1500.00,
                'max_yield_per_acre' => 2400.00,
                'min_price_per_kg' => 22.00,
                'max_price_per_kg' => 32.00,
                'ideal_ph_min' => 6.00,
                'ideal_ph_max' => 7.50,
                'ideal_moisture_min' => 40.00,
                'ideal_moisture_max' => 70.00,
                'description' => 'Cool-season cereal grain suitable for loam and clay-loam soils.',
            ],
            [
                'name' => 'Vegetables',
                'scientific_name' => 'Horticultural Mix',
                'growth_duration_days' => 90,
                'min_yield_per_acre' => 5000.00,
                'max_yield_per_acre' => 12000.00,
                'min_price_per_kg' => 15.00,
                'max_price_per_kg' => 35.00,
                'ideal_ph_min' => 6.00,
                'ideal_ph_max' => 7.00,
                'ideal_moisture_min' => 50.00,
                'ideal_moisture_max' => 80.00,
                'description' => 'High-turnover seasonal vegetable plots (tomatoes, chillies, leafy greens).',
            ],
            [
                'name' => 'Pulses',
                'scientific_name' => 'Leguminosae',
                'growth_duration_days' => 100,
                'min_yield_per_acre' => 400.00,
                'max_yield_per_acre' => 900.00,
                'min_price_per_kg' => 60.00,
                'max_price_per_kg' => 95.00,
                'ideal_ph_min' => 6.50,
                'ideal_ph_max' => 7.50,
                'ideal_moisture_min' => 35.00,
                'ideal_moisture_max' => 60.00,
                'description' => 'Nitrogen-fixing grain legumes like gram, moong, and urad dal.',
            ],
            [
                'name' => 'Fruits',
                'scientific_name' => 'Fruit Orchards',
                'growth_duration_days' => 180,
                'min_yield_per_acre' => 4000.00,
                'max_yield_per_acre' => 10000.00,
                'min_price_per_kg' => 30.00,
                'max_price_per_kg' => 70.00,
                'ideal_ph_min' => 6.00,
                'ideal_ph_max' => 7.50,
                'ideal_moisture_min' => 45.00,
                'ideal_moisture_max' => 75.00,
                'description' => 'Perennial and seasonal orchard yields (papaya, banana, pomegranate).',
            ],
            [
                'name' => 'Spices',
                'scientific_name' => 'Zingiberaceae & Allied',
                'growth_duration_days' => 150,
                'min_yield_per_acre' => 1200.00,
                'max_yield_per_acre' => 2500.00,
                'min_price_per_kg' => 80.00,
                'max_price_per_kg' => 160.00,
                'ideal_ph_min' => 5.50,
                'ideal_ph_max' => 6.80,
                'ideal_moisture_min' => 60.00,
                'ideal_moisture_max' => 85.00,
                'description' => 'High-value aromatic spice varieties (turmeric, ginger, cardamom).',
            ],
        ];

        foreach ($cropsData as $crop) {
            DB::table('crops')->updateOrInsert(
                ['name' => $crop['name']],
                array_merge($crop, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn([
                'total_budget',
                'calculated_roi',
                'annualized_roi',
                'is_roi_overridden',
                'roi_override_reason',
                'projected_yield_kg',
                'projected_price_per_kg',
                'projected_revenue',
                'projected_net_profit',
                'investor_profit_share',
                'farmer_profit_share',
                'crop_cycle_days',
                'yield_shortfall_percent',
            ]);
        });

        Schema::table('crops', function (Blueprint $table) {
            $table->dropColumn([
                'min_yield_per_acre',
                'max_yield_per_acre',
                'min_price_per_kg',
                'max_price_per_kg',
            ]);
        });
    }
};

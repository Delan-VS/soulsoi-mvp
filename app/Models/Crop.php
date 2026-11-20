<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = [
        'name',
        'scientific_name',
        'ideal_ph_min',
        'ideal_ph_max',
        'ideal_moisture_min',
        'ideal_moisture_max',
        'growth_duration_days',
        'min_yield_per_acre',
        'max_yield_per_acre',
        'min_price_per_kg',
        'max_price_per_kg',
        'description',
    ];

    protected $casts = [
        'ideal_ph_min' => 'decimal:2',
        'ideal_ph_max' => 'decimal:2',
        'ideal_moisture_min' => 'decimal:2',
        'ideal_moisture_max' => 'decimal:2',
        'growth_duration_days' => 'integer',
        'min_yield_per_acre' => 'decimal:2',
        'max_yield_per_acre' => 'decimal:2',
        'min_price_per_kg' => 'decimal:2',
        'max_price_per_kg' => 'decimal:2',
    ];

    /**
     * Check if given yield and price per kg fall within expected benchmarks for this crop.
     * Returns an array of non-blocking warning strings.
     *
     * @param float $yieldPerAcre
     * @param float $pricePerKg
     * @return array<string>
     */
    public function checkBenchmarkWarnings(float $yieldPerAcre, float $pricePerKg): array
    {
        $warnings = [];

        if ($this->min_yield_per_acre !== null && $yieldPerAcre > 0 && $yieldPerAcre < (float) $this->min_yield_per_acre) {
            $warnings[] = sprintf(
                'Projected yield (%.1f kg/acre) is below standard benchmark (%.0f - %.0f kg/acre) for %s.',
                $yieldPerAcre,
                (float) $this->min_yield_per_acre,
                (float) $this->max_yield_per_acre,
                $this->name
            );
        } elseif ($this->max_yield_per_acre !== null && $yieldPerAcre > (float) $this->max_yield_per_acre) {
            $warnings[] = sprintf(
                'Projected yield (%.1f kg/acre) exceeds typical maximum benchmark (%.0f - %.0f kg/acre) for %s.',
                $yieldPerAcre,
                (float) $this->min_yield_per_acre,
                (float) $this->max_yield_per_acre,
                $this->name
            );
        }

        if ($this->min_price_per_kg !== null && $pricePerKg > 0 && $pricePerKg < (float) $this->min_price_per_kg) {
            $warnings[] = sprintf(
                'Selling price (₹%.2f/kg) is below wholesale benchmark (₹%.0f - ₹%.0f/kg) for %s.',
                $pricePerKg,
                (float) $this->min_price_per_kg,
                (float) $this->max_price_per_kg,
                $this->name
            );
        } elseif ($this->max_price_per_kg !== null && $pricePerKg > (float) $this->max_price_per_kg) {
            $warnings[] = sprintf(
                'Selling price (₹%.2f/kg) exceeds typical wholesale benchmark (₹%.0f - ₹%.0f/kg) for %s.',
                $pricePerKg,
                (float) $this->min_price_per_kg,
                (float) $this->max_price_per_kg,
                $this->name
            );
        }

        return $warnings;
    }
}

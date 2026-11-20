<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $fillable = [
        'farm_id', 'status', 'estimated_yield', 'actual_yield',
        'selling_price', 'market_value', 'expected_harvest_date',
        'start_date', 'actual_harvest_date', 'quality_grade',
        'market_name', 'image_path'
    ];

    protected $casts = [
        'expected_harvest_date' => 'date',
        'start_date' => 'date',
        'actual_harvest_date' => 'date',
    ];

    public function computedRevenue(): float
    {
        $yield = (float) ($this->actual_yield ?? 0);
        $price = (float) ($this->selling_price ?? 0);

        if ($yield > 0 && $price > 0) {
            return round($yield * $price, 2);
        }

        if ($yield > 0 && $this->selling_price === null && (float) ($this->market_value ?? 0) > 0) {
            return round((float) $this->market_value, 2);
        }

        return 0.0;
    }

    public function effectiveSellingPrice(): float
    {
        if ($this->selling_price !== null && (float) $this->selling_price > 0) {
            return (float) $this->selling_price;
        }

        $yield = (float) ($this->actual_yield ?? 0);
        $val = (float) ($this->market_value ?? 0);
        if ($yield > 0 && $val > 0) {
            return round($val / $yield, 2);
        }

        return 0.0;
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}

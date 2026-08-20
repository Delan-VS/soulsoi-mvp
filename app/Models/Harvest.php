<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $fillable = [
        'farm_id', 'status', 'estimated_yield', 'actual_yield',
        'market_value', 'expected_harvest_date', 'actual_harvest_date',
        'quality_grade', 'image_path'
    ];

    protected $casts = [
        'expected_harvest_date' => 'date',
        'actual_harvest_date' => 'date',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}

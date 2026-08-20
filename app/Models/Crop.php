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
        'description',
    ];
}

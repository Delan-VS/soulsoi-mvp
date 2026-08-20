<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoilReport extends Model
{
    protected $fillable = [
        'user_id',
        'sample_date',
        'location',
        'ph_level',
        'nitrogen',
        'phosphorus',
        'potassium',
        'moisture',
        'status',
        'recommendation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'device_id',
        'name',
        'type',
        'status',
        'last_reading',
        'location',
    ];
}

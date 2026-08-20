<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmUpdate extends Model
{
    protected $fillable = ['farm_id', 'title', 'description', 'image_path'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}

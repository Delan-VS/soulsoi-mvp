<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'farm_id', 'buyer_name', 'sale_amount', 'quantity_sold',
        'sale_date', 'invoice_path', 'blockchain_tx_hash',
        'compliance_blockchain', 'compliance_audit', 'compliance_pesticide_free',
        'status'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'compliance_blockchain' => 'boolean',
        'compliance_audit' => 'boolean',
        'compliance_pesticide_free' => 'boolean',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}

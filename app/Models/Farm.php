<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farm extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function ($farm) {
            if ($farm->isDirty('status')) {
                $newStatus = $farm->status;
                if ($newStatus === 'approved') {
                    AuditLog::create([
                        'user_name' => auth()->user()?->name ?? 'System',
                        'action' => 'Farm Approved',
                        'description' => "Approved registration details for farm: {$farm->name}.",
                        'ip_address' => request()->ip(),
                    ]);
                } elseif ($newStatus === 'rejected') {
                    AuditLog::create([
                        'user_name' => auth()->user()?->name ?? 'System',
                        'action' => 'Farm Rejected',
                        'description' => "Rejected registration details for farm: {$farm->name}. Reason: " . ($farm->admin_notes ?? 'No reason provided'),
                        'ip_address' => request()->ip(),
                    ]);
                }
            }
        });
    }

    protected $fillable = [
        'farmer_id',
        'name',
        'total_acres',
        'primary_crop',
        'status',
        'funding_target',
        'funding_raised',
        'investor_count',
        'documentation_required',
        'soil_ph',
        'npk_ratio',
        'avg_rainfall',
        'temp_range',
        'soil_report_path',
        'reviewed_by_id',
        'reviewed_at',
        'admin_notes',
        'secondary_crop',
        'listing_category',
        'location',
        'yielding_period',
        'expected_start_date',
        'min_investment',
        'max_investment',
        'expected_roi',
        'your_contribution',
        'land_certificate_path',
        'lease_agreement_path',
        'farm_photo_path',
        'pending_disbursement_amount',
        'pending_disbursement_stage',
        'pending_disbursement_purpose',
        'budget_breakdown',
        'farming_timeline',
        'additional_photos',
        'additional_documents',
        'disbursement_history',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'budget_breakdown' => 'array',
        'farming_timeline' => 'array',
        'additional_photos' => 'array',
        'additional_documents' => 'array',
        'disbursement_history' => 'array',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function harvests()
    {
        return $this->hasMany(Harvest::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function updates()
    {
        return $this->hasMany(FarmUpdate::class);
    }
}

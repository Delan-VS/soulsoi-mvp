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
        'total_budget',
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
        'calculated_roi',
        'annualized_roi',
        'is_roi_overridden',
        'roi_override_reason',
        'your_contribution',
        'projected_yield_kg',
        'projected_price_per_kg',
        'projected_revenue',
        'projected_net_profit',
        'investor_profit_share',
        'farmer_profit_share',
        'crop_cycle_days',
        'yield_shortfall_percent',
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
        'funding_status',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'budget_breakdown' => 'array',
        'farming_timeline' => 'array',
        'additional_photos' => 'array',
        'additional_documents' => 'array',
        'disbursement_history' => 'array',
        'total_budget' => 'decimal:2',
        'funding_target' => 'decimal:2',
        'funding_raised' => 'decimal:2',
        'your_contribution' => 'decimal:2',
        'expected_roi' => 'decimal:2',
        'calculated_roi' => 'decimal:2',
        'annualized_roi' => 'decimal:2',
        'is_roi_overridden' => 'boolean',
        'projected_yield_kg' => 'decimal:2',
        'projected_price_per_kg' => 'decimal:2',
        'projected_revenue' => 'decimal:2',
        'projected_net_profit' => 'decimal:2',
        'investor_profit_share' => 'decimal:2',
        'farmer_profit_share' => 'decimal:2',
        'crop_cycle_days' => 'integer',
        'yield_shortfall_percent' => 'decimal:2',
    ];

    /**
     * Determine whether the farm has achieved its investor funding target.
     * Investor Funding Target = Total Budget - Farmer Stake.
     *
     * @return bool
     */
    public function isFunded(): bool
    {
        $target = (float) $this->funding_target;
        if ($target <= 0) {
            return false;
        }

        return (float) $this->funding_raised >= $target;
    }

    /**
     * Compute funding progress percentage towards investor funding target.
     *
     * @return float
     */
    public function fundingProgressPercent(): float
    {
        $target = (float) $this->funding_target;
        if ($target <= 0) {
            return 0.0;
        }

        $raised = (float) ($this->funding_raised ?? 0);
        return min(100.0, round(($raised / $target) * 100, 1));
    }

    /**
     * Get the active effective ROI percentage (override value if admin applied override, else calculated).
     *
     * @return float
     */
    public function effectiveRoi(): float
    {
        if ($this->is_roi_overridden && $this->expected_roi !== null) {
            return (float) $this->expected_roi;
        }

        return (float) ($this->calculated_roi ?? $this->expected_roi ?? 0.0);
    }

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

    public function crop()
    {
        return $this->belongsTo(Crop::class, 'primary_crop', 'name');
    }
}

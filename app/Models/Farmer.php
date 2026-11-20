<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farmer extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function ($farmer) {
            if ($farmer->isDirty('overall_status')) {
                $newStatus = $farmer->overall_status;
                if ($newStatus === 'approved') {
                    AuditLog::create([
                        'user_name' => auth()->user()?->name ?? 'System',
                        'action' => 'Farmer Approved',
                        'description' => "Approved registration details for farmer: {$farmer->full_name}.",
                        'ip_address' => request()->ip(),
                    ]);
                } elseif ($newStatus === 'rejected') {
                    AuditLog::create([
                        'user_name' => auth()->user()?->name ?? 'System',
                        'action' => 'Farmer Rejected',
                        'description' => "Rejected registration details for farmer: {$farmer->full_name}. Reason: " . ($farmer->admin_notes ?? 'No reason provided'),
                        'ip_address' => request()->ip(),
                    ]);
                }
            }
        });

        static::deleting(function ($farmer) {
            if ($farmer->user) {
                $farmer->user->delete();
            }
        });
    }

    protected $fillable = [
        'user_id',
        'full_name',
        'dob',
        'aadhar_number',
        'address',
        'village',
        'district',
        'state',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'face_verification',
        'mobile_verification',
        'bank_verification',
        'document_verification',
        'overall_status',
        'aadhar_front_path',
        'aadhar_back_path',
        'pan_card_path',
        'bank_proof_path',
        'farm_ownership_doc_path',
        'land_certificate_path',
        'reviewed_by_id',
        'reviewed_at',
        'admin_notes',
    ];

    protected $casts = [
        'dob' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }

    /**
     * Compute verification progress in percentage.
     */
    public function getVerificationProgressAttribute(): int
    {
        $progress = 0;
        if ($this->face_verification === 'completed')
            $progress += 25;
        if ($this->mobile_verification === 'completed')
            $progress += 25;
        if ($this->bank_verification === 'completed')
            $progress += 25;
        if ($this->document_verification === 'completed')
            $progress += 25;
        return $progress;
    }

    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }

    public function getPhoneAttribute()
    {
        return $this->user ? $this->user->phone : null;
    }
}

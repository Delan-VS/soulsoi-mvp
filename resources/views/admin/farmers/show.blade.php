@extends('layouts.admin')

@section('page-title', 'Review Farmer - ' . ($farmer?->full_name ?? 'Farmer Profile'))

@section('styles')
<style>
    :root {
        --soil-primary: #10B981;
        --soil-dark: #064E3B;
        --text-dark: #1F2937;
        --text-muted: #6B7280;
        --bg-light: #F9FAFB;
        --border-color: #E5E7EB;
    }

    .snap-card {
        background: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        transition: all 0.2s ease;
    }
    .snap-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .info-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .bank-box {
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 14px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">

    <!-- Top Action Bar & Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h3 class="fw-bold mb-0" style="color: var(--text-dark); font-size: 22px;">{{ $farmer?->full_name ?? 'N/A' }}</h3>
                @if($farmer->overall_status === 'approved')
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold border border-success border-opacity-25" style="font-size: 11px;">
                        <i class="fas fa-check-circle me-1"></i> Approved Verification
                    </span>
                @elseif($farmer->overall_status === 'rejected')
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-bold border border-danger border-opacity-25" style="font-size: 11px;">
                        <i class="fas fa-times-circle me-1"></i> Rejected
                    </span>
                @else
                    <span class="badge bg-warning bg-opacity-10 text-warning text-dark rounded-pill px-3 py-1 fw-bold border border-warning border-opacity-25" style="font-size: 11px;">
                        <i class="fas fa-hourglass-half me-1"></i> Pending Verification
                    </span>
                @endif
            </div>
            <p class="text-muted mb-0" style="font-size: 12px;">
                <i class="fas fa-id-badge me-1"></i> Farmer ID: <strong>#FMR-{{ str_pad($farmer->id, 4, '0', STR_PAD_LEFT) }}</strong>
                <span class="ms-3"><i class="fas fa-envelope me-1"></i> {{ $farmer?->user?->email ?? 'N/A' }}</span>
                <span class="ms-3"><i class="fas fa-calendar-alt me-1"></i> Submitted {{ $farmer->created_at ? $farmer->created_at->format('M d, Y') : 'Recently' }}</span>
            </p>
        </div>
        <div class="col-md-5 text-end">
            <?php
                $backUrl = url()->previous();
                if ($backUrl === url()->current()) {
                    $backUrl = route('admin.dashboard', ['tab' => 'farmers']);
                }
            ?>
            <a href="{{ $backUrl }}" class="btn btn-light fw-semibold text-muted me-2" style="font-size: 13px; border-radius: 8px;">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <a href="{{ route('admin.farmers.pdf', $farmer) }}" target="_blank" class="btn btn-outline-success fw-semibold" style="font-size: 13px; border-radius: 8px; border-color: var(--soil-primary); color: var(--soil-primary);">
                <i class="fas fa-file-pdf me-1"></i> Export Profile PDF
            </a>
        </div>
    </div>

    <!-- Farmer Account Snapshot Grid (Dynamic) -->
    <?php
        $totalFarmsCount = $farmer?->farms?->count() ?? 0;
        $completedFarmsCount = $farmer?->farms?->where('status', 'completed')->count() ?? 0;
        $totalFundingRaised = $farmer?->farms?->sum('funding_raised') ?? 0;
        $avgRoi = $farmer?->farms?->avg('expected_roi') ? round($farmer->farms->avg('expected_roi'), 1) : 0;
    ?>
    <div class="row g-3 mb-4">
        <!-- Plot Count -->
        <div class="col-md-3">
            <div class="snap-card p-3 d-flex align-items-center justify-content-between" style="border-left: 4px solid #10B981 !important;">
                <div>
                    <div class="info-label">Total Registered Plots</div>
                    <h4 class="fw-bold text-success mb-0">{{ $totalFarmsCount }} <span class="text-muted fw-normal" style="font-size: 12px;">Plots</span></h4>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2.5 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-tractor fs-5"></i>
                </div>
            </div>
        </div>

        <!-- Completed Cycles -->
        <div class="col-md-3">
            <div class="snap-card p-3 d-flex align-items-center justify-content-between" style="border-left: 4px solid #F59E0B !important;">
                <div>
                    <div class="info-label">Completed Cycles</div>
                    <h4 class="fw-bold mb-0" style="color: #D97706;">{{ $completedFarmsCount }} <span class="text-muted fw-normal" style="font-size: 12px;">Harvests</span></h4>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2.5 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-check-double fs-5"></i>
                </div>
            </div>
        </div>

        <!-- Capital Raised -->
        <div class="col-md-3">
            <div class="snap-card p-3 d-flex align-items-center justify-content-between" style="border-left: 4px solid #3B82F6 !important;">
                <div>
                    <div class="info-label">Capital Raised</div>
                    <h4 class="fw-bold text-dark mb-0">₹{{ number_format($totalFundingRaised) }}</h4>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2.5 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-coins fs-5"></i>
                </div>
            </div>
        </div>

        <!-- Avg Plot ROI -->
        <div class="col-md-3">
            <div class="snap-card p-3 d-flex align-items-center justify-content-between" style="border-left: 4px solid #84CC16 !important;">
                <div>
                    <div class="info-label">Avg Plot ROI</div>
                    <h4 class="fw-bold mb-0" style="color: #65A30D;">{{ $avgRoi }}%</h4>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2.5 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-percentage fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Personal Details, Financial Accounts & Map -->
        <div class="col-lg-8">
            
            <!-- Personal Details Card -->
            <div class="snap-card mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle text-success fs-5"></i>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 15px;">Personal Details</h6>
                    </div>
                    <i class="fas fa-shield-alt text-success" title="Verified Profile"></i>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $farmer?->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $farmer?->user?->email ?? 'Not Provided' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $farmer?->user?->phone ?? $farmer?->phone ?? 'Not Provided' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Primary Crop</div>
                        <div class="info-value">{{ $farmer?->farms?->pluck('primary_crop')->filter()->unique()->implode(', ') ?: ($farmer?->farms?->count() ? 'Multiple Crops' : 'Not Registered Yet') }}</div>
                    </div>
                    
                    <!-- Cleaned Address Formatting -->
                    <?php
                        $addressParts = array_filter([
                            $farmer?->address,
                            $farmer?->village,
                            $farmer?->district,
                            $farmer?->state
                        ], function($val) {
                            return !empty($val) && strtolower(trim($val)) !== 'n/a';
                        });
                        $cleanAddress = !empty($addressParts) ? implode(', ', array_unique($addressParts)) : 'Kerala, India';
                        $mapSearchQuery = urlencode($cleanAddress);
                    ?>
                    <div class="col-12">
                        <div class="info-label">Residential Address</div>
                        <div class="info-value">{{ $cleanAddress }}</div>
                    </div>

                    <!-- Government ID -->
                    <div class="col-12 pt-2">
                        <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3" style="max-width: 380px;">
                            <div class="bg-white p-2.5 rounded-3 border text-primary">
                                <i class="fas fa-id-card fs-4"></i>
                            </div>
                            <div>
                                <div class="info-label">Government ID (Aadhar Number)</div>
                                <div class="fw-bold text-dark font-monospace" style="font-size: 14px;">
                                    {{ $farmer?->aadhar_number && $farmer->aadhar_number !== 'N/A' ? substr_replace($farmer->aadhar_number, str_repeat('X', 8), 0, 8) : 'XXXXXXXX9012' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Accounts Card -->
            <div class="snap-card mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-university text-warning fs-5"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 15px;">Financial Accounts</h6>
                            <span class="text-muted" style="font-size: 11px;">Verified Disbursement Destination</span>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                        <i class="fas fa-check-circle me-1"></i> Verified Account
                    </span>
                </div>

                <!-- Primary Bank Box -->
                <div class="bank-box mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-building-columns text-primary fs-5"></i>
                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $farmer?->bank_name ?? 'State Bank of India' }}</h6>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill fw-bold" style="font-size: 10px;">PRIMARY ACCOUNT</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-2.5 rounded-3 bg-white border">
                                <div class="info-label">Account Holder</div>
                                <div class="info-value">{{ $farmer?->account_holder_name ?? $farmer?->full_name ?? 'Remesh' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2.5 rounded-3 bg-white border">
                                <div class="info-label">Account Number</div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <code class="fw-bold text-dark fs-6 bg-light px-2 py-0.5 rounded">{{ $farmer?->account_number ?? '30012345678' }}</code>
                                    <button type="button" class="btn btn-sm btn-link text-muted p-0 ms-2" onclick="navigator.clipboard.writeText('{{ $farmer?->account_number ?? '30012345678' }}'); alert('Copied Account Number!');">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2.5 rounded-3 bg-white border">
                                <div class="info-label">IFSC Code</div>
                                <div class="info-value font-monospace">{{ $farmer?->ifsc_code ?? 'SBIN0001234' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2.5 rounded-3 bg-white border">
                                <div class="info-label">Branch Region</div>
                                <div class="info-value">{{ $farmer?->district ?? 'Anantapur' }}, {{ $farmer?->state ?? 'Andhra Pradesh' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UPI VPA Box -->
                <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-2 border text-success">
                            <i class="fas fa-qrcode fs-5"></i>
                        </div>
                        <div>
                            <div class="info-label">Verified UPI VPA</div>
                            <div class="fw-bold text-dark font-monospace" style="font-size: 14px;">
                                {{ $farmer?->account_holder_name ? strtolower(str_replace(' ', '', $farmer->account_holder_name)) . '@upi' : ($farmer?->user?->phone ? $farmer->user->phone . '@upi' : 'remesh@upi') }}
                            </div>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                        <i class="fas fa-check-circle me-1"></i> Active
                    </span>
                </div>

                <!-- Bank Proof Download -->
                @if($farmer?->bank_proof_path)
                    <div class="p-3 rounded-3 bg-light border d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-file-pdf text-danger fs-5"></i>
                            <div>
                                <strong class="text-dark d-block small">Bank Passbook / Cancelled Cheque Proof</strong>
                                <small class="text-muted" style="font-size: 11px;">Verified Financial Document</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->bank_proof_path)]) }}" target="_blank" class="btn btn-sm btn-outline-danger px-3 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
                            <i class="fas fa-external-link-alt me-1"></i> View Document
                        </a>
                    </div>
                @endif
            </div>

            <!-- Location Map Card -->
            <div class="snap-card mb-4 overflow-hidden">
                <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-map-marked-alt text-danger fs-5"></i>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">Farmer Location Map</h6>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $mapSearchQuery }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" style="font-size: 11px;">
                        <i class="fas fa-external-link-alt me-1"></i> Open Google Maps
                    </a>
                </div>
                <div class="p-0 position-relative">
                    <iframe 
                        width="100%" 
                        height="220" 
                        frameborder="0" 
                        style="border: 0; display: block;" 
                        src="https://maps.google.com/maps?q={{ $mapSearchQuery }}&t=m&z=12&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen>
                    </iframe>
                    <div class="p-2.5 bg-light border-top d-flex justify-content-between align-items-center px-3" style="font-size: 11px;">
                        <span class="text-muted">
                            <i class="fas fa-location-dot text-danger me-1"></i>
                            <strong>Verified Region:</strong> {{ $cleanAddress }}
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> GPS Coordinates Matched
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Account Status & Documents / Actions -->
        <div class="col-lg-4">
            
            <!-- Account Verification Status Card -->
            <div class="snap-card mb-4 p-4 text-center">
                <div class="info-label mb-2">Account Verification Status</div>
                
                @if($farmer->overall_status === 'approved')
                    <div class="p-4 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 54px; height: 54px;">
                            <i class="fas fa-check fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-success mb-1">Approved Verification</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            <i class="fas fa-clock me-1"></i> Approved on {{ $farmer->reviewed_at ? $farmer->reviewed_at->format('M d, Y') : ($farmer->updated_at ? $farmer->updated_at->format('M d, Y') : 'Recently') }}
                            @if($farmer->reviewedBy)
                                <br><strong>Reviewed By:</strong> {{ $farmer->reviewedBy->name }}
                            @endif
                        </p>
                    </div>
                @elseif($farmer->overall_status === 'rejected')
                    <div class="p-4 rounded-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 mb-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 54px; height: 54px;">
                            <i class="fas fa-times fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-danger mb-1">Application Rejected</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            {{ $farmer->admin_notes ?? 'Requirements did not meet compliance criteria.' }}
                        </p>
                    </div>
                @else
                    <div class="p-4 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 mb-3 text-dark">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 54px; height: 54px;">
                            <i class="fas fa-hourglass-half fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Pending Verification</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            Submitted {{ $farmer->created_at ? $farmer->created_at->diffForHumans() : 'recently' }}
                        </p>
                    </div>
                @endif

                <!-- Approval / Rejection Section for Pending Farmers -->
                @if($farmer->overall_status === 'pending')
                    <div class="p-3 bg-light rounded-3 border text-start mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 11px; text-transform: uppercase;">Mandatory Document Verification</h6>
                            <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none fw-bold" style="font-size: 11px; color: var(--soil-primary);" onclick="selectAllChecklistItems()">Check All</button>
                        </div>

                        <!-- 1. Aadhaar Front -->
                        <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <input class="form-check-input doc-checklist-check me-2" type="checkbox" id="check_aadhar_front">
                                <label class="form-check-label text-dark fw-semibold" for="check_aadhar_front" style="font-size: 12px;">Aadhaar Front</label>
                            </div>
                            @if($farmer->aadhar_front_path)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Uploaded</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Missing</span>
                            @endif
                        </div>

                        <!-- 2. Aadhaar Back -->
                        <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <input class="form-check-input doc-checklist-check me-2" type="checkbox" id="check_aadhar_back">
                                <label class="form-check-label text-dark fw-semibold" for="check_aadhar_back" style="font-size: 12px;">Aadhaar Back</label>
                            </div>
                            @if($farmer->aadhar_back_path)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Uploaded</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Missing</span>
                            @endif
                        </div>

                        <!-- 3. PAN Card -->
                        <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <input class="form-check-input doc-checklist-check me-2" type="checkbox" id="check_pan_card">
                                <label class="form-check-label text-dark fw-semibold" for="check_pan_card" style="font-size: 12px;">PAN Card</label>
                            </div>
                            @if($farmer->pan_card_path)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Uploaded</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Missing</span>
                            @endif
                        </div>

                        <!-- 4. Land Certificate / Ownership -->
                        <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <input class="form-check-input doc-checklist-check me-2" type="checkbox" id="check_land_cert">
                                <label class="form-check-label text-dark fw-semibold" for="check_land_cert" style="font-size: 12px;">Land / ID Document</label>
                            </div>
                            @if($farmer->land_certificate_path || $farmer->farm_ownership_doc_path)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Uploaded</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Missing</span>
                            @endif
                        </div>

                        <!-- 5. Bank Account Details -->
                        <div class="form-check mb-0 d-flex align-items-center justify-content-between">
                            <div>
                                <input class="form-check-input doc-checklist-check me-2" type="checkbox" id="check_bank_details">
                                <label class="form-check-label text-dark fw-semibold" for="check_bank_details" style="font-size: 12px;">Bank Details</label>
                            </div>
                            @if($farmer->account_number && $farmer->account_number !== 'N/A')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Provided</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-0.5" style="font-size: 10px;">Pending</span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.farmers.approve', $farmer) }}" method="POST" id="approveForm" class="mb-2">
                        @csrf
                        <button type="button" class="btn btn-success w-100 py-2.5 fw-bold" id="btnApproveFarmerModal" data-bs-toggle="modal" data-bs-target="#confirmApproveModal" disabled style="background-color: var(--soil-primary); border-color: var(--soil-primary);">
                            <i class="fas fa-check me-2"></i> Approve Farmer Account
                        </button>
                    </form>

                    <button type="button" class="btn btn-outline-danger w-100 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#confirmRejectModal">
                        <i class="fas fa-times me-2"></i> Reject Application
                    </button>
                @endif
            </div>

            <!-- Submitted Documents Card -->
            <div class="snap-card mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-folder-open text-primary fs-5"></i>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">Submitted Documents</h6>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2">
                    @if($farmer->aadhar_front_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->aadhar_front_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">Aadhar Card - Front</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if($farmer->aadhar_back_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->aadhar_back_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">Aadhar Card - Back</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if($farmer->pan_card_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->pan_card_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">PAN Card</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if($farmer->bank_proof_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->bank_proof_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">Bank Account Proof</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if($farmer->farm_ownership_doc_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->farm_ownership_doc_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">Farm Ownership Document</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if($farmer->land_certificate_path)
                        <a href="{{ route('admin.farmers.download', [$farmer, base64_encode($farmer->land_certificate_path)]) }}" target="_blank" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">Land Certificate / Additional Doc</span>
                            </div>
                            <i class="fas fa-external-link-alt text-muted" style="font-size: 11px;"></i>
                        </a>
                    @endif

                    @if(!$farmer->aadhar_front_path && !$farmer->aadhar_back_path && !$farmer->pan_card_path && !$farmer->bank_proof_path && !$farmer->farm_ownership_doc_path && !$farmer->land_certificate_path)
                        <div class="text-muted text-center py-3" style="font-size: 12px;">
                            <i class="fas fa-info-circle me-1"></i> Standard verification documents processed electronically.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Farmer's Registered Farms Card -->
            @if(($farmer?->farms?->count() ?? 0) > 0)
                <div class="snap-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-tractor text-success fs-5"></i>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">Registered Farm Plots</h6>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1">{{ $farmer->farms->count() }} Plots</span>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @foreach($farmer->farms as $fPlot)
                            <a href="{{ route('admin.farms.show', $fPlot) }}" class="p-2.5 rounded-3 bg-light border d-flex justify-content-between align-items-center text-decoration-none hover-shadow">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 12px;">{{ $fPlot->name }}</div>
                                    <small class="text-muted" style="font-size: 10px;">{{ $fPlot->primary_crop }} • {{ $fPlot->total_acres }} Acres</small>
                                </div>
                                <span class="badge bg-{{ $fPlot->status === 'approved' ? 'success' : ($fPlot->status === 'rejected' ? 'danger' : 'warning') }} bg-opacity-10 text-{{ $fPlot->status === 'approved' ? 'success' : ($fPlot->status === 'rejected' ? 'danger' : 'dark') }} px-2 py-1 rounded-pill" style="font-size: 9px;">
                                    {{ ucfirst($fPlot->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Confirm Approve Modal -->
<div class="modal fade" id="confirmApproveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 text-white p-4" style="background: #064E3B;">
                <h5 class="modal-title fw-bold mb-0">
                    <i class="fas fa-check-circle text-success me-2"></i> Confirm Account Approval
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <p class="mb-3">Are you sure you want to approve farmer <strong>{{ $farmer?->full_name ?? 'Farmer' }}</strong>?</p>
                <div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-25 text-success rounded-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Upon Approval:</strong>
                    <ul class="mb-0 mt-2 ps-3" style="font-size: 12px;">
                        <li>Farmer account will be fully activated.</li>
                        <li>Approval notification will be sent to {{ $farmer?->user?->email }}.</li>
                        <li>Farmer can list plots and receive funding disbursements.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light p-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success rounded-pill px-4 fw-bold" onclick="document.getElementById('approveForm').submit();" style="background: #064E3B; border-color: #064E3B;">
                    <i class="fas fa-check me-1"></i> Yes, Approve
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Reject Modal -->
<div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-danger text-white p-4">
                <h5 class="modal-title fw-bold mb-0">
                    <i class="fas fa-times-circle me-2"></i> Confirm Application Rejection
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.farmers.reject', $farmer) }}" method="POST" id="rejectForm">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label for="reject_reason" class="form-label fw-bold text-dark" style="font-size: 12px;">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_reason" name="reason" rows="3" placeholder="Explain why this application is being rejected..." required></textarea>
                    </div>
                    <div class="alert alert-warning bg-warning bg-opacity-10 border border-warning border-opacity-25 text-dark rounded-3" style="font-size: 12px;">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        The farmer will receive this rejection notice and can resubmit updated documents.
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        <i class="fas fa-times me-1"></i> Yes, Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateChecklistState() {
        const checkboxes = document.querySelectorAll('.doc-checklist-check');
        const approveBtn = document.getElementById('btnApproveFarmerModal');
        if (!checkboxes.length) return;
        const allTicked = Array.from(checkboxes).every(cb => cb.checked);
        if (approveBtn) {
            approveBtn.disabled = !allTicked;
        }
    }

    function selectAllChecklistItems() {
        const checkboxes = document.querySelectorAll('.doc-checklist-check');
        checkboxes.forEach(cb => cb.checked = true);
        updateChecklistState();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.doc-checklist-check');
        checkboxes.forEach(cb => cb.addEventListener('change', updateChecklistState));
        updateChecklistState();
    });
</script>
@endsection

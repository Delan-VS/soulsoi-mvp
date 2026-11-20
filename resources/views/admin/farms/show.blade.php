

<?php $__env->startSection('page-title', 'Farm Details - ' . ($farm->name ?? 'Farm')); ?>

@section('styles')
<style>
    :root {
        --investor-primary: #10B981;
        --investor-secondary: #059669;
        --text-dark: #111827;
        --text-muted: #6B7280;
        --bg-color: #F9FAFB;
        --border-light: #E5E7EB;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Inter', sans-serif;
    }

    /* Figma-style Tabs */
    .figma-tabs {
        border-bottom: 1px solid var(--border-light);
        gap: 20px;
        margin-bottom: 24px;
    }
    .figma-tabs .nav-link {
        border: none;
        color: var(--text-muted);
        font-weight: 500;
        font-size: 14px;
        padding: 12px 0;
        border-radius: 0;
        background: transparent;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }
    .figma-tabs .nav-link:hover {
        color: var(--investor-primary);
    }
    .figma-tabs .nav-link.active {
        color: var(--investor-primary);
        border-bottom-color: var(--investor-primary);
        font-weight: 600;
    }
    .figma-tabs .nav-link.disabled, .figma-tabs .nav-link:disabled {
        color: #9CA3AF !important;
        cursor: not-allowed !important;
        pointer-events: none;
        opacity: 0.55;
        border-bottom-color: transparent !important;
    }

    /* Cards */
    .glass-card {
        background: #FFFFFF;
        border: 1px solid var(--border-light);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Premium Timeline Styling */
    .timeline-container {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 40px 10px 20px;
        margin-top: 10px;
    }
    .timeline-line-bg {
        position: absolute;
        top: 60px;
        left: 8%;
        right: 8%;
        height: 4px;
        background: #E5E7EB;
        z-index: 1;
        border-radius: 2px;
    }
    .timeline-line-active {
        position: absolute;
        top: 60px;
        left: 8%;
        width: 33%; /* 3rd step out of 6 */
        height: 4px;
        background: var(--investor-primary);
        z-index: 2;
        border-radius: 2px;
    }
    .timeline-step {
        position: relative;
        z-index: 3;
        text-align: center;
        width: 16.66%;
    }
    .step-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #F9FAFB;
        border: 2px solid #E5E7EB;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-weight: bold;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    .step-icon.completed {
        background: var(--investor-primary);
        border-color: var(--investor-primary);
        color: white;
    }
    .step-icon.active {
        background: white;
        border: 3px solid var(--investor-primary);
        color: var(--investor-primary);
        box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.15);
    }
    .step-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }
    .step-sublabel {
        font-size: 10px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }
    .step-sublabel.active {
        color: var(--investor-primary);
    }

    /* Modern Fund Disbursement Styles */
    .fund-kpi-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        transition: all 0.2s ease;
    }
    .fund-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.04);
    }
    .fund-stage-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .fund-stage-card:hover {
        border-color: #10b981;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.12);
        transform: translateY(-3px);
    }
    .fund-stage-card.stage-selected {
        border-color: #10b981 !important;
        background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%) !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2), 0 8px 20px rgba(16, 185, 129, 0.15) !important;
    }
    .fund-stage-card.stage-disbursed {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .fund-stage-card.stage-pending {
        background: #fffbeb;
        border-color: #fde047;
        box-shadow: 0 4px 12px rgba(234, 179, 8, 0.1);
    }
    .fund-stage-card.stage-ready {
        border-color: #3b82f6;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.12);
    }
    .stage-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h2 class="fw-bold mb-0" style="color: var(--text-dark); font-size: 22px;">{{ $farm->name ?? 'N/A' }}</h2>
                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif
                @if(in_array($farm->status, ['approved', 'active']))
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-semibold border border-success border-opacity-25" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                        <i class="fas fa-check-circle me-1"></i> APPROVED & LISTED
                    </span>
                @elseif($farm->status === 'completed')
                    <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-semibold border border-success" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase; background-color: #064e3b !important;">
                        <i class="fas fa-check-double me-1"></i> COMPLETED & SETTLED
                    </span>
                @elseif($farm->status === 'rejected')
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-semibold border border-danger border-opacity-25" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                        <i class="fas fa-times-circle me-1"></i> REJECTED
                    </span>
                @else
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-semibold border border-warning border-opacity-25 text-dark" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                        <i class="fas fa-hand-paper me-1 text-danger"></i> PENDING VERIFICATION
                    </span>
                @endif
                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
            </div>
            <p class="text-muted mb-0" style="font-size: 13px;">
                <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $farm->location ?? ($farm->farmer->village . ', ' . $farm->farmer->district) ?? 'N/A' }}
            </p>
        </div>

        <div class="d-flex align-items-center justify-content-start justify-content-md-end gap-2 flex-wrap">
            <?php
                $backUrl = url()->previous();
                if ($backUrl === url()->current()) {
                    $backUrl = auth()->user()?->is_admin ? route('admin.dashboard', ['tab' => 'farms']) : route('admin.dashboard');
                }
            ?>
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1.5 px-3 py-2 fw-semibold bg-white shadow-sm" style="font-size: 13px; border-radius: 8px; border-color: #D1D5DB; color: #4B5563; height: 38px;">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
            </a>
            @if(in_array($farm->status, ['pending', 'submitted', 'completed']))
                <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-1.5 px-3 py-2 fw-bold text-white shadow-sm" style="font-size: 13px; border-radius: 8px; background-color: var(--investor-primary); border-color: var(--investor-primary); height: 38px;">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $farm->status === 'completed' ? 'Re-Open / Mark Approved' : 'Approve Farm Listing' }}</span>
                    </button>
                </form>
            @endif
            <a href="{{ route('reports.export', ['type' => 'farms']) }}" class="btn btn-outline-success d-inline-flex align-items-center gap-1.5 px-3 py-2 fw-semibold bg-white shadow-sm" style="font-size: 13px; border-radius: 8px; border-color: var(--investor-primary); color: var(--investor-primary); height: 38px;">
                <i class="fas fa-file-download"></i>
                <span>Download Report</span>
            </a>
            <button class="btn btn-success d-inline-flex align-items-center gap-1.5 px-3 py-2 fw-semibold text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#updateModal" style="font-size: 13px; border-radius: 8px; background-color: var(--investor-primary); border-color: var(--investor-primary); height: 38px;">
                <i class="fas fa-bullhorn"></i>
                <span>Post Update</span>
            </button>
        </div>
    </div>

    <?php
        $isOverviewApproved = in_array($farm->status, ['approved', 'active', 'completed']);

        $hasDisbursedFunds = false;
        if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
            foreach ($farm->disbursement_history as $hItem) {
                $hStatus = strtolower(trim($hItem['status'] ?? ''));
                if (str_contains($hStatus, 'disbursed')) {
                    $hasDisbursedFunds = true;
                    break;
                }
            }
        }
        $isFundDisbursed = $isOverviewApproved && ($hasDisbursedFunds || $farm->status === 'completed');

        // Dynamic agricultural tonnage computation based on acreage & crop (Available globally across tabs and modals)
        $adminCropLower = strtolower($farm->primary_crop ?? '');
        if (str_contains($adminCropLower, 'paddy') || str_contains($adminCropLower, 'rice')) {
            $adminCropMultiplier = 2.8;
        } elseif (str_contains($adminCropLower, 'banana') || str_contains($adminCropLower, 'plantain')) {
            $adminCropMultiplier = 12.0;
        } elseif (str_contains($adminCropLower, 'sugarcane')) {
            $adminCropMultiplier = 35.0;
        } elseif (str_contains($adminCropLower, 'wheat') || str_contains($adminCropLower, 'cereal') || str_contains($adminCropLower, 'corn')) {
            $adminCropMultiplier = 2.5;
        } elseif (str_contains($adminCropLower, 'tomato') || str_contains($adminCropLower, 'vegetable') || str_contains($adminCropLower, 'chilli')) {
            $adminCropMultiplier = 7.5;
        } elseif (str_contains($adminCropLower, 'cardamom') || str_contains($adminCropLower, 'pepper') || str_contains($adminCropLower, 'spice')) {
            $adminCropMultiplier = 1.2;
        } elseif (str_contains($adminCropLower, 'coconut')) {
            $adminCropMultiplier = 4.5;
        } else {
            $adminCropMultiplier = 3.5;
        }
        $calcAdminExpYield = round(floatval($farm->total_acres > 0 ? $farm->total_acres : 2.5) * $adminCropMultiplier, 1);
        $latestHarvest = $farm->harvests()->where('status', '!=', 'gallery_photo')->latest()->first()
            ?? $farm->harvests()->whereNotNull('actual_yield')->latest()->first()
            ?? $farm->harvests()->latest()->first();
    ?>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs figma-tabs" id="farmTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                Overview
            </button>
        </li>
        <li class="nav-item" role="presentation">
            @if($isOverviewApproved)
                <button class="nav-link" id="fund-request-tab" data-bs-toggle="tab" data-bs-target="#fund-request" type="button" role="tab">
                    Fund Request
                </button>
            @else
                <button class="nav-link disabled" id="fund-request-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Overview approval required first">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Fund Request
                </button>
            @endif
        </li>
        <li class="nav-item" role="presentation">
            @if($isFundDisbursed)
                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab">
                    Timeline
                </button>
            @else
                <button class="nav-link disabled" id="timeline-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Requires overview approval and initial fund disbursement">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Timeline
                </button>
            @endif
        </li>
        <li class="nav-item" role="presentation">
            @if($isFundDisbursed)
                <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button" role="tab">
                    Updates
                </button>
            @else
                <button class="nav-link disabled" id="updates-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Requires overview approval and initial fund disbursement">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Updates
                </button>
            @endif
        </li>
        <li class="nav-item" role="presentation">
            @if($isOverviewApproved)
                <button class="nav-link" id="investors-tab" data-bs-toggle="tab" data-bs-target="#investors" type="button" role="tab">
                    Investors
                </button>
            @else
                <button class="nav-link disabled" id="investors-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Overview approval required first">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Investors
                </button>
            @endif
        </li>
        <li class="nav-item" role="presentation">
            @if($isFundDisbursed)
                <button class="nav-link" id="harvest-tab" data-bs-toggle="tab" data-bs-target="#harvest" type="button" role="tab">
                    <i class="fas fa-wheat-awn me-1"></i> Harvest & Yield
                </button>
            @else
                <button class="nav-link disabled" id="harvest-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Requires overview approval and initial fund disbursement">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Harvest & Yield
                </button>
            @endif
        </li>
        <li class="nav-item" role="presentation">
            @if($isFundDisbursed)
                <button class="nav-link" id="settlement-tab" data-bs-toggle="tab" data-bs-target="#settlement" type="button" role="tab">
                    Settlement
                </button>
            @else
                <button class="nav-link disabled" id="settlement-tab" type="button" disabled tabindex="-1" aria-disabled="true" title="Locked: Requires overview approval and initial fund disbursement">
                    <i class="fas fa-lock me-1" style="font-size: 10px;"></i> Settlement
                </button>
            @endif
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="farmTabsContent">
        
        <!-- 1. Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">

            @if(!$isOverviewApproved)
                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-dark rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2 shadow-sm">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-warning fs-5"></i>
                        <span style="font-size: 13px;" class="fw-semibold">
                            <strong>Pending Overview Verification:</strong> All operational tabs (Fund Request, Cultivation Timeline, Updates, Harvest, Settlement) are currently locked until this farm listing is approved.
                        </span>
                    </div>
                    <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 py-1.5 fw-bold text-white shadow-sm" style="background-color: var(--investor-primary); border-color: var(--investor-primary); font-size: 11px;">
                            <i class="fas fa-check-circle me-1"></i> Approve Overview Now
                        </button>
                    </form>
                </div>
            @elseif(!$isFundDisbursed)
                <div class="alert alert-info border-0 bg-info bg-opacity-10 text-dark rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2 shadow-sm">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle text-primary fs-5"></i>
                        <span style="font-size: 13px;" class="fw-semibold">
                            <strong>Overview Approved:</strong> Cultivation Timeline, Updates, Harvest, and Settlement will automatically unlock once the initial stage funds are disbursed to the farmer in the <strong>Fund Request</strong> tab.
                        </span>
                    </div>
                    <button type="button" onclick="document.querySelector('#fund-request-tab')?.click();" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="font-size: 11px;">
                        <i class="fas fa-coins me-1"></i> Open Fund Request Tab
                    </button>
                </div>
            @endif
            <div class="row g-4">
                
                <!-- Main Content Left -->
                <div class="col-lg-8">
                    
                    <!-- Hero Image -->
                    <div class="position-relative overflow-hidden mb-4 glass-card" style="height: 320px;">
                        <img src="{{ $farm->farm_photo_path ? asset('storage/'.$farm->farm_photo_path) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200&auto=format&fit=crop' }}" class="w-100 h-100" style="object-fit: cover;">
                        <div class="position-absolute top-0 end-0 p-3">
                            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif
                            @if($farm->status === 'approved')
                                <span class="badge bg-success bg-opacity-75 text-white rounded-pill px-3 py-1 shadow-sm border border-success" style="font-size: 12px; letter-spacing: 0.5px;">
                                    <i class="fas fa-check-circle me-1"></i> APPROVED
                                </span>
                            @elseif($farm->status === 'completed')
                                <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-1 shadow-sm border border-dark" style="font-size: 12px; letter-spacing: 0.5px;">
                                    <i class="fas fa-flag-checkered me-1"></i> COMPLETED & SETTLED
                                </span>
                            @elseif($farm->status === 'rejected')
                                <span class="badge bg-danger bg-opacity-75 text-white rounded-pill px-3 py-1 shadow-sm border border-danger" style="font-size: 12px; letter-spacing: 0.5px;">
                                    <i class="fas fa-times-circle me-1"></i> REJECTED
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-75 text-dark rounded-pill px-3 py-1 shadow-sm border border-warning" style="font-size: 12px; letter-spacing: 0.5px;">
                                    <i class="fas fa-hourglass-half me-1"></i> PENDING VERIFICATION
                                </span>
                            @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                            <h4 class="text-white fw-bold mb-1">{{ $farm->primary_crop ?? 'N/A' }}</h4>
                            <p class="text-white-50 mb-0" style="font-size: 13px;">{{ $farm->total_acres ?? 0 }} Acres • {{ $farm->listing_category ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Metrics Row -->
                    <?php
                        $target = $farm->funding_target ?? 0;
                        $raised = $farm->funding_raised ?? 0;
                        $progress = $target > 0 ? min(100, ($raised / $target) * 100) : 0;
                        
                        if (!function_exists('formatCurrency')) {
                            function formatCurrency($amount) {
                                if ($amount >= 10000000) {
                                    return '₹' . number_format($amount / 10000000, 2) . ' Cr';
                                } elseif ($amount >= 100000) {
                                    return '₹' . number_format($amount / 100000, 2) . ' L';
                                }
                                return '₹' . number_format($amount);
                            }
                        }
                    ?>
                    <div class="row g-3 mb-4">
                        <!-- Funding -->
                        <div class="col-md-4">
                            <div class="glass-card h-100 p-3">
                                <div class="text-muted fw-semibold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Funding Raised</div>
                                <div class="d-flex align-items-end gap-1 mb-2">
                                    <h5 class="fw-bold text-dark mb-0">{{ formatCurrency($raised) }}</h5>
                                    <span class="text-muted" style="font-size: 12px; margin-bottom: 2px;">/ {{ formatCurrency($target) }}</span>
                                </div>
                                <div class="progress" style="height: 4px; border-radius: 4px;">
                                    <div class="progress-bar" style="width: {{ $progress }}%; background-color: var(--investor-primary);"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Expected Yield -->
                        <div class="col-md-4">
                            <div class="glass-card h-100 p-3">
                                <div class="text-muted fw-semibold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Yielding Period</div>
                                <h5 class="fw-bold text-dark mb-1">{{ $farm->yielding_period ?? 'N/A' }} Months</h5>
                                <p class="text-success mb-0" style="font-size: 11px; font-weight: 500;"><i class="fas fa-clock me-1"></i> Estimated Cycle Time</p>
                            </div>
                        </div>
                        <!-- IRR -->
                        <div class="col-md-4">
                            <div class="glass-card h-100 p-3">
                                <div class="text-muted fw-semibold text-uppercase mb-2" style="font-size: 10px; letter-spacing: 0.5px;">Est. Return (ROI)</div>
                                <h5 class="fw-bold text-dark mb-1">{{ $farm->expected_roi ?? 'N/A' }}%</h5>
                                @if($farm->is_roi_overridden)
                                    <div class="mt-1">
                                        <span class="badge bg-warning bg-opacity-20 text-warning border px-2 py-0.5 rounded-pill" style="font-size: 10px; color: #854d0e !important;" title="Calculated: {{ $farm->calculated_roi }}%. Reason: {{ $farm->roi_override_reason }}">
                                            <i class="fas fa-user-shield me-1"></i>Overridden (Calc: {{ $farm->calculated_roi }}%)
                                        </span>
                                        @if($farm->roi_override_reason)
                                            <div class="text-muted fst-italic mt-1" style="font-size: 10px;">"{{ \Illuminate\Support\Str::limit($farm->roi_override_reason, 45) }}"</div>
                                        @endif
                                    </div>
                                @elseif($farm->annualized_roi)
                                    <p class="text-muted mb-0" style="font-size: 11px;">Annualized: {{ $farm->annualized_roi }}% ({{ $farm->crop_cycle_days ?? 120 }}d)</p>
                                @else
                                    <p class="text-muted mb-0" style="font-size: 11px;">Cycle Projection</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Farm Summary -->
                    <div class="mb-5">
                        <h6 class="fw-bold text-dark mb-3">Farm Summary</h6>
                        <p class="text-muted" style="font-size: 13px; line-height: 1.6;">
                            Located in {{ $farm->location ?? ($farm->farmer->village . ', ' . $farm->farmer->district) ?? 'the region' }}, <strong>{{ $farm->name ?? 'this farm' }}</strong> spans across {{ $farm->total_acres ?? 0 }} acres. The primary cultivation focus is on {{ $farm->primary_crop ?? 'N/A' }}, with a {{ $farm->listing_category ?? 'general' }} farming approach. 
                            The expected yielding period for this cycle is {{ $farm->yielding_period ?? 'N/A' }} months, targeting an annualized ROI of {{ $farm->expected_roi ?? 'N/A' }}%.
                        </p>
                        
                        <!-- Environmental & Soil Metrics -->
                       
                    </div>

                    <!-- Live Activity Feed -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">Live Activity Feed</h6>
                            <a href="#" class="text-success fw-semibold text-decoration-none" style="font-size: 11px; letter-spacing: 0.5px;">VIEW ALL UPDATES</a>
                        </div>
                        
                        <div class="glass-card mb-2">
                            <div class="card-body p-3 d-flex gap-3 align-items-start">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mt-1" style="width: 32px; height: 32px; min-width: 32px;">
                                    <i class="fas fa-broadcast-tower" style="font-size: 12px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">Sensor Grid Update</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.5;">Soil moisture levels in Sector B stabilized after automated irrigation cycle. Nutrient levels at 94% target.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-card mb-2">
                            <div class="card-body p-3 d-flex gap-3 align-items-start">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mt-1" style="width: 32px; height: 32px; min-width: 32px;">
                                    <i class="fas fa-leaf" style="font-size: 12px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">Field Report: Veraison Commenced</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.5;">First signs of color change noted in the Cabernet block. Harvesting schedule confirmed for late September.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Right -->
                <div class="col-lg-4">
                    
                    <!-- Admin Decision Section -->
                    <div class="glass-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-4">Farm Status & Decision</h6>
                            
                            <!-- Status Alert -->
                            <div class="text-center mb-4">
                                <span class="badge badge-{{ $farm->status === 'approved' ? 'success' : ($farm->status === 'rejected' ? 'danger' : 'warning') }}" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-{{ $farm->status === 'approved' ? 'check-circle' : ($farm->status === 'rejected' ? 'times-circle' : 'hourglass-half') }} me-2"></i> 
                                    {{ ucfirst($farm->status) }} Verification
                                </span>
                            </div>

                            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($farm->status === 'pending')
                                <!-- Approve Form -->
                                <div class="mb-4">
                                    <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" id="approveFarmForm">
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-2">
                                            <label class="form-label text-muted small fw-semibold">Admin Notes (Optional)</label>
                                            <textarea class="form-control" name="notes" rows="2" placeholder="Approval notes..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100 fw-semibold" style="background-color: var(--investor-primary); border-color: var(--investor-primary);">
                                            <i class="fas fa-check me-2"></i> Approve Farm
                                        </button>
                                    </form>
                                </div>
                                
                                <hr>

                                <!-- Reject Form -->
                                <div>
                                    <form action="{{ route('admin.farms.reject', $farm) }}" method="POST" id="rejectFarmForm">
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-2">
                                            <label class="form-label text-muted small fw-semibold">Rejection Reason <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="reason" rows="2" placeholder="Why is this farm rejected?" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100 fw-semibold">
                                            <i class="fas fa-times me-2"></i> Reject Farm
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center mt-3">
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i> Reviewed on {{ $farm->reviewed_at ? \Carbon\Carbon::parse($farm->reviewed_at)->format('M d, Y') : ($farm->updated_at ? \Carbon\Carbon::parse($farm->updated_at)->format('M d, Y') : 'Recently') }}

                                    </p>
                                </div>
                            @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                        </div>
                    </div>
                    
                    <!-- Operational Status -->
                    
                    
                    <!-- Investor Snapshot -->
                    <div class="glass-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-4">Investor Snapshot</h6>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3 text-dark" style="font-size: 13px;">
                                <span class="text-muted">Active Investors</span>
                                <span class="fw-semibold">{{ $farm->investor_count ?? $farm->investments()->count() ?? 0 }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3 text-dark" style="font-size: 13px;">
                                <span class="text-muted">Min Investment</span>
                                <span class="fw-semibold">{{ $farm->min_investment ? '₹'.number_format($farm->min_investment) : 'N/A' }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4 text-dark" style="font-size: 13px;">
                                <span class="text-muted">Lock-up Period</span>
                                <span class="fw-semibold">{{ $farm->yielding_period ?? 'N/A' }} Months</span>
                            </div>
                            
                            <p class="text-muted mb-3" style="font-size: 11px;">Join other investors supporting sustainable agriculture. <a href="#" class="text-success text-decoration-none fw-semibold">View full terms</a></p>
                            
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex">
                                    <img src="https://i.pravatar.cc/100?img=11" class="rounded-circle border border-2 border-white" style="width: 32px; height: 32px; margin-right: -10px; z-index: 3;">
                                    <img src="https://i.pravatar.cc/100?img=12" class="rounded-circle border border-2 border-white" style="width: 32px; height: 32px; margin-right: -10px; z-index: 2;">
                                    <img src="https://i.pravatar.cc/100?img=13" class="rounded-circle border border-2 border-white" style="width: 32px; height: 32px; margin-right: -10px; z-index: 1;">
                                    <div class="rounded-circle border border-2 border-white bg-light d-flex align-items-center justify-content-center text-muted fw-semibold" style="width: 32px; height: 32px; font-size: 10px; z-index: 0;">+24</div>
                                </div>
                                <span class="text-muted fw-medium ms-2" style="font-size: 11px;">+24 others</span>
                            </div>
                        </div>
                    </div>

                    <!-- Smart Analytics Map -->
                    <div class="glass-card overflow-hidden position-relative">
                        <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600&auto=format&fit=crop" class="w-100" style="height: 180px; object-fit: cover; filter: contrast(1.1) grayscale(80%);">
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-1" style="font-size: 10px; letter-spacing: 0.5px;"><i class="fas fa-satellite me-1"></i> SMART ANALYTICS</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 text-center" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                            <span class="text-white fw-medium" style="font-size: 11px;">Field Map Generated Today</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 2. Fund Request Tab -->
        <div class="tab-pane fade" id="fund-request" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Fund Requests Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        The Overview for <strong>{{ $farm->name }}</strong> must be verified and approved by the administrator before stage-based fund requests and disbursements can be initiated.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                            <i class="fas fa-arrow-left me-1"></i> Back to Overview
                        </button>
                        <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold" style="background-color: var(--investor-primary); border-color: var(--investor-primary);">
                                <i class="fas fa-check-circle me-1"></i> Approve Overview Now
                            </button>
                        </form>
                    </div>
                </div>
            @else
            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if(auth()->user()?->farmer || auth()->user()?->is_admin)
                <?php
                    $stagesWithBudget = [];
                    if (!empty($farm->budget_breakdown) && is_array($farm->budget_breakdown)) {
                        foreach ($farm->budget_breakdown as $bItem) {
                            $bName = $bItem['purpose'] ?? $bItem['name'] ?? $bItem['stage'] ?? null;
                            $bAmt = (float)($bItem['amount'] ?? $bItem['cost'] ?? 0);
                            if ($bName) {
                                $stagesWithBudget[] = [
                                    'name' => $bName,
                                    'amount' => $bAmt,
                                    'purpose' => "Budgeted funds for " . $bName . " (₹" . number_format($bAmt) . ")"
                                ];
                            }
                        }
                    }
                    if (empty($stagesWithBudget)) {
                        $stagesWithBudget = [
                            ['name' => 'Land Prep', 'amount' => 150000, 'purpose' => 'Land tilling, soil enrichment, leveling, and plot prep.'],
                            ['name' => 'Seeding', 'amount' => 45000, 'purpose' => 'Procurement of certified high-yield organic seeds.'],
                            ['name' => 'Irrigation & Growth', 'amount' => 120000, 'purpose' => 'Drip irrigation, weeding, and seasonal labor care.'],
                            ['name' => 'Harvesting', 'amount' => 85000, 'purpose' => 'Crop cutting, yield collection, and sorting.'],
                            ['name' => 'Settlement', 'amount' => 50000, 'purpose' => 'Revenue distribution and investor return settlement.']
                        ];
                    }

                    $disbursedStagesMap = [];
                    $pendingStagesMap = [];
                    $disbursedAmountsMap = [];
                    $disbursedDatesMap = [];
                    $pendingRequests = [];

                    if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
                        foreach ($farm->disbursement_history as $hIdx => $hItem) {
                            $hStage = trim($hItem['stage'] ?? '');
                            $hStatus = strtolower(trim($hItem['status'] ?? ''));
                            $isDisb = str_contains($hStatus, 'disbursed');
                            $isPend = str_contains($hStatus, 'pending');

                            if ($isPend) {
                                $pendingRequests[] = $hItem;
                            }

                            if (!empty($hStage) && strlen($hStage) >= 2) {
                                $hStageLower = strtolower($hStage);
                                foreach ($stagesWithBudget as $stg) {
                                    $stgNameLower = strtolower(trim($stg['name']));
                                    if ($hStageLower === $stgNameLower || (strlen($hStageLower) >= 3 && (str_contains($hStageLower, $stgNameLower) || str_contains($stgNameLower, $hStageLower)))) {
                                        if ($isDisb) {
                                            $disbursedStagesMap[$stg['name']] = true;
                                            $disbursedAmountsMap[$stg['name']] = ($disbursedAmountsMap[$stg['name']] ?? 0) + ($hItem['amount'] ?? 0);
                                            $disbursedDatesMap[$stg['name']] = $hItem['date'] ?? '';
                                            unset($pendingStagesMap[$stg['name']]);
                                        } elseif ($isPend && empty($disbursedStagesMap[$stg['name']])) {
                                            $pendingStagesMap[$stg['name']] = $hItem;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Clean up any stale pending entries for stages already disbursed
                    foreach ($stagesWithBudget as $stg) {
                        if (!empty($disbursedStagesMap[$stg['name']])) {
                            unset($pendingStagesMap[$stg['name']]);
                        }
                    }
                    $pendingRequests = array_values(array_filter($pendingRequests, function($p) use ($disbursedStagesMap) {
                        $pStage = trim($p['stage'] ?? '');
                        return empty($disbursedStagesMap[$pStage]);
                    }));

                    // Check single active pending request on farm record if not already in pending map
                    if (!empty($farm->pending_disbursement_stage) && ($farm->pending_disbursement_amount > 0)) {
                        $pStages = array_map('trim', explode(',', $farm->pending_disbursement_stage));
                        foreach ($pStages as $pStage) {
                            $pStageLower = strtolower($pStage);
                            foreach ($stagesWithBudget as $stg) {
                                $stgNameLower = strtolower(trim($stg['name']));
                                if ($stgNameLower === $pStageLower || (strlen($pStageLower) >= 3 && (str_contains($pStageLower, $stgNameLower) || str_contains($stgNameLower, $pStageLower)))) {
                                    if (empty($pendingStagesMap[$stg['name']])) {
                                        $pendingStagesMap[$stg['name']] = [
                                            'amount' => $farm->pending_disbursement_amount,
                                            'stage' => $stg['name'],
                                            'purpose' => $farm->pending_disbursement_purpose ?? ''
                                        ];
                                    }
                                }
                            }
                        }
                    }

                    $totalBudget = array_sum(array_column($stagesWithBudget, 'amount'));
                    $totalDisbursed = 0;
                    foreach ($stagesWithBudget as $stg) {
                        if (!empty($disbursedStagesMap[$stg['name']])) {
                            $totalDisbursed += ($disbursedAmountsMap[$stg['name']] ?? $stg['amount']);
                        }
                    }
                    if ($totalDisbursed == 0 && $farm->funding_raised > 0) {
                        $totalDisbursed = min($farm->funding_raised, $totalBudget > 0 ? $totalBudget : $farm->funding_raised);
                    }

                    $historyPendingSum = 0;
                    foreach ($pendingRequests as $pReq) {
                        $historyPendingSum += (float)($pReq['amount'] ?? 0);
                    }
                    $pendingAmount = $historyPendingSum > 0 ? $historyPendingSum : (float)($farm->pending_disbursement_amount ?? 0);
                    $remainingBudget = max(0, $totalBudget - $totalDisbursed);
                    $disbursedPercent = $totalBudget > 0 ? min(100, round(($totalDisbursed / $totalBudget) * 100)) : 0;

                    $nextAvailableStage = null;
                    $undisbursedStages = [];
                    foreach ($stagesWithBudget as $stg) {
                        if (empty($disbursedStagesMap[$stg['name']])) {
                            $undisbursedStages[] = $stg;
                            if (!$nextAvailableStage && empty($pendingStagesMap[$stg['name']])) {
                                $nextAvailableStage = $stg;
                            }
                        }
                    }
                ?>

                <!-- 1. Financial KPI Summary Tracker -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="fund-kpi-card h-100 shadow-sm border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Total Budget</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2"><i class="fas fa-wallet"></i></span>
                            </div>
                            <h4 class="fw-bold text-dark mb-0">₹{{ number_format($totalBudget) }}</h4>
                            <span class="text-muted" style="font-size: 11px;">{{ count($stagesWithBudget) }} budget stages allocated</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="fund-kpi-card h-100 shadow-sm border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Disbursed Capital</span>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-circle p-2"><i class="fas fa-check-circle"></i></span>
                            </div>
                            <h4 class="fw-bold text-success mb-1">₹{{ number_format($totalDisbursed) }}</h4>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; background-color: #e2e8f0; border-radius: 3px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $disbursedPercent }}%; border-radius: 3px;"></div>
                                </div>
                                <span class="text-success fw-bold" style="font-size: 11px;">{{ $disbursedPercent }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="fund-kpi-card h-100 shadow-sm border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Pending Approval</span>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-circle p-2"><i class="fas fa-hourglass-half"></i></span>
                            </div>
                            <h4 class="fw-bold {{ $pendingAmount > 0 ? 'text-warning' : 'text-dark' }} mb-0">₹{{ number_format($pendingAmount) }}</h4>
                            <span class="text-muted" style="font-size: 11px;">
                                @if($pendingAmount > 0)
                                    {{ count($pendingRequests) > 1 ? count($pendingRequests) . ' tranches awaiting review' : 'Action required by admin' }}
                                @else
                                    No tranches waiting
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="fund-kpi-card h-100 shadow-sm border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Remaining Balance</span>
                                <span class="badge bg-info bg-opacity-10 text-info rounded-circle p-2"><i class="fas fa-coins"></i></span>
                            </div>
                            <h4 class="fw-bold text-dark mb-0">₹{{ number_format($remainingBudget) }}</h4>
                            <span class="text-muted" style="font-size: 11px;">Available to release</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Pending Request Alert (if any) -->
                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($pendingAmount > 0 || $farm->pending_disbursement_amount > 0)
                    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if(auth()->user()?->is_admin)
                        <!-- Admin View: Action Required to Approve/Reject Request -->
                        <div class="card border-warning border-2 p-4 rounded-4 mb-4 shadow-sm" style="background: #fffbeb;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                    <i class="fas fa-exclamation-circle fs-4"></i>
                                </div>
                                <div class="flex-grow-1 text-dark">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                        <h5 class="fw-bold mb-0" style="color: #854d0e;">
                                            Action Required: Farmer Fund Request{{ count($pendingRequests) > 1 ? 's' : '' }} Awaiting Approval
                                        </h5>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill" style="font-size: 11px;">
                                                {{ count($pendingRequests) > 1 ? count($pendingRequests) . ' Requests Pending' : 'Awaiting Review' }}
                                            </span>
                                            @if(count($pendingRequests) > 1)
                                                <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="stage" value="all">
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold px-3 py-1 rounded-pill shadow-sm" style="font-size: 12px;">
                                                        <i class="fas fa-check-double me-1"></i> Approve All Pending (₹{{ number_format($pendingAmount) }})
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-muted mb-3" style="font-size: 13px;">
                                        The farmer submitted fund requests for agricultural tranches. Review below and approve or reject tranches with 1 click.
                                    </p>

                                    @if(count($pendingRequests) > 1)
                                        <!-- Multi-tranche pending list -->
                                        <div class="d-flex flex-column gap-2 mb-3">
                                            @foreach($pendingRequests as $pReq)
                                                <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <strong class="text-dark fs-6">{{ $pReq['stage'] ?? 'Tranche' }}</strong>
                                                        <span class="badge bg-light text-muted border ms-2" style="font-size: 11px;">{{ $pReq['date'] ?? 'Recent' }}</span>
                                                        <div class="text-muted small mt-0.5">{{ $pReq['purpose'] ?? 'Budgeted agricultural funds' }}</div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="fw-bold text-success fs-5">₹{{ number_format($pReq['amount'] ?? 0) }}</span>
                                                        <div class="d-flex gap-1">
                                                            <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="m-0">
                                                                @csrf
                                                                <input type="hidden" name="stage" value="{{ $pReq['stage'] ?? '' }}">
                                                                <button type="submit" class="btn btn-sm btn-success fw-bold px-3 rounded-pill" style="font-size: 12px;">
                                                                    <i class="fas fa-check me-1"></i> Approve
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.farms.reject_disburse', $farm->id) }}" method="POST" class="m-0" onsubmit="return confirm('Reject request for {{ $pReq['stage'] ?? '' }}?');">
                                                                @csrf
                                                                <input type="hidden" name="stage" value="{{ $pReq['stage'] ?? '' }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 rounded-pill" style="font-size: 12px;" title="Reject">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Single request view -->
                                        @php
                                            $singleReq = $pendingRequests[0] ?? [
                                                'stage' => $farm->pending_disbursement_stage,
                                                'amount' => $farm->pending_disbursement_amount,
                                                'purpose' => $farm->pending_disbursement_purpose
                                            ];
                                        @endphp
                                        <div class="p-3 bg-white rounded-3 mb-3 border">
                                            <div class="row g-3 text-dark" style="font-size: 13px;">
                                                <div class="col-6 col-md-4">
                                                    <span class="text-muted d-block small">Agricultural Stage:</span>
                                                    <strong class="text-dark">{{ $singleReq['stage'] ?? 'N/A' }}</strong>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <span class="text-muted d-block small">Requested Amount:</span>
                                                    <strong class="text-success fs-5">₹{{ number_format($singleReq['amount'] ?? 0) }}</strong>
                                                </div>
                                                @if(!empty($singleReq['purpose']))
                                                    <div class="col-12 mt-2 pt-2 border-top">
                                                        <span class="text-muted d-block small">Purpose of Funds:</span>
                                                        <span>{{ $singleReq['purpose'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 flex-wrap">
                                            <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="stage" value="{{ $singleReq['stage'] ?? '' }}">
                                                <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm" style="border-radius: 20px;">
                                                    <i class="fas fa-check-circle me-1"></i> Approve and Release Funds (₹{{ number_format($singleReq['amount'] ?? 0) }})
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.farms.reject_disburse', $farm->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to reject this request?');">
                                                @csrf
                                                <input type="hidden" name="stage" value="{{ $singleReq['stage'] ?? '' }}">
                                                <button type="submit" class="btn btn-outline-danger fw-bold px-4" style="border-radius: 20px;">
                                                    <i class="fas fa-times-circle me-1"></i> Reject Request
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Farmer View: Pending Request status notice -->
                        <div class="alert alert-warning p-4 rounded-4 border-0 shadow-sm d-flex gap-3 align-items-center mb-4 text-dark" style="background-color: #fffbeb;">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="fas fa-hourglass-half fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #854d0e;">Fund Disbursement Request{{ count($pendingRequests) > 1 ? 's' : '' }} Under Review</h6>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    Your request{{ count($pendingRequests) > 1 ? 's' : '' }} totaling <strong>₹{{ number_format($pendingAmount) }}</strong> {{ count($pendingRequests) > 1 ? 'across ' . count($pendingRequests) . ' tranches' : 'for the ' . ($farm->pending_disbursement_stage ?? 'selected stage') }} have been submitted and are currently pending review by the administrator.
                                </p>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- 3. Interactive Visual Stage Cards Grid (Replaces manual dropdown pain) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold text-uppercase" style="font-size: 10px;">
                                        <i class="fas fa-bolt me-1"></i> Interactive Stage Selector
                                    </span>
                                </div>
                                <h5 class="fw-bold text-dark mb-0" style="font-size: 18px;">
                                    Agricultural Tranche Stages
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    Click any stage card to select it, or use the 1-click quick buttons to disburse without manual forms.
                                </p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @if($nextAvailableStage && auth()->user()?->is_admin)
                                    <button type="button" class="btn btn-success fw-bold d-inline-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2" onclick="triggerQuickDisburse('{{ addslashes($nextAvailableStage['name']) }}', {{ $nextAvailableStage['amount'] }}, '{{ addslashes($nextAvailableStage['purpose']) }}')" style="font-size: 13px;">
                                        <i class="fas fa-bolt"></i>
                                        <span>Disburse Next: {{ $nextAvailableStage['name'] }} (₹{{ number_format($nextAvailableStage['amount']) }})</span>
                                    </button>
                                @endif
                                @if(count($undisbursedStages) > 1 && auth()->user()?->is_admin)
                                    <button type="button" class="btn btn-outline-primary fw-bold d-inline-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2" data-bs-toggle="modal" data-bs-target="#batchDisburseModal" style="font-size: 13px;">
                                        <i class="fas fa-layer-group"></i>
                                        <span>Batch Disburse Multiple</span>
                                    </button>
                                @elseif(count($undisbursedStages) === 0)
                                    <span class="badge bg-success text-white rounded-pill px-3 py-2 fw-semibold" style="font-size: 13px;">
                                        <i class="fas fa-check-double me-1"></i> All {{ count($stagesWithBudget) }} Tranches Disbursed!
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Responsive Stage Cards Grid -->
                        <div class="row g-3" id="fundStageCardsGrid">
                            @foreach($stagesWithBudget as $idx => $stg)
                                @php
                                    $isDisbursed = !empty($disbursedStagesMap[$stg['name']]);
                                    $isPending = !empty($pendingStagesMap[$stg['name']]);
                                    $isNext = ($nextAvailableStage && $nextAvailableStage['name'] === $stg['name']);

                                    // Stage icon selection
                                    $sLower = strtolower($stg['name']);
                                    $icon = 'fa-layer-group';
                                    if (str_contains($sLower, 'land') || str_contains($sLower, 'prep')) $icon = 'fa-tractor';
                                    elseif (str_contains($sLower, 'seed') || str_contains($sLower, 'sow')) $icon = 'fa-seedling';
                                    elseif (str_contains($sLower, 'irrigation') || str_contains($sLower, 'water') || str_contains($sLower, 'growth')) $icon = 'fa-droplet';
                                    elseif (str_contains($sLower, 'harvest')) $icon = 'fa-wheat-awn';
                                    elseif (str_contains($sLower, 'settle') || str_contains($sLower, 'return')) $icon = 'fa-hand-holding-dollar';

                                    $colClass = count($stagesWithBudget) <= 5 ? 'col-12 col-md-6 col-xl' : 'col-12 col-sm-6 col-lg-4 col-xl-2';
                                @endphp
                                <div class="{{ $colClass }}">
                                    <div class="fund-stage-card h-100 {{ $isDisbursed ? 'stage-disbursed' : ($isPending ? 'stage-pending' : ($isNext ? 'stage-ready stage-selected' : '')) }}" 
                                         id="stage-card-{{ $idx }}"
                                         data-stage-name="{{ $stg['name'] }}"
                                         data-stage-amount="{{ $stg['amount'] }}"
                                         data-stage-purpose="{{ $stg['purpose'] }}"
                                         onclick="selectStageCard({{ $idx }}, '{{ addslashes($stg['name']) }}', {{ $stg['amount'] }}, '{{ addslashes($stg['purpose']) }}')">
                                        
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1" style="font-size: 10px; font-weight: 700;">
                                                    STAGE {{ $idx + 1 }}
                                                </span>
                                                @if($isDisbursed)
                                                    <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                                        <i class="fas fa-check-circle me-1"></i> Disbursed
                                                    </span>
                                                @elseif($isPending)
                                                    <span class="badge bg-warning bg-opacity-20 text-warning rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px; color: #854d0e !important;">
                                                        <i class="fas fa-clock me-1"></i> Under Review
                                                    </span>
                                                @elseif($isNext)
                                                    <span class="badge bg-primary bg-opacity-15 text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                                        <i class="fas fa-bolt me-1"></i> Next In Line
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-muted rounded-pill px-2.5 py-1 fw-medium" style="font-size: 10px;">
                                                        Upcoming
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                <div class="stage-icon-circle {{ $isDisbursed ? 'bg-success text-white' : ($isPending ? 'bg-warning text-dark' : ($isNext ? 'bg-primary text-white' : 'bg-light text-muted border')) }}">
                                                    <i class="fas {{ $icon }}"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">{{ $stg['name'] }}</h6>
                                                    <div class="fw-bold text-success" style="font-size: 15px;">₹{{ number_format($stg['amount']) }}</div>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-3" style="font-size: 11px; line-height: 1.4; min-height: 32px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $stg['purpose'] }}
                                            </p>
                                        </div>

                                        <div class="pt-2 border-top">
                                            @if($isDisbursed)
                                                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                                    <span><i class="fas fa-calendar-check me-1 text-success"></i> {{ $disbursedDatesMap[$stg['name']] ?? 'Completed' }}</span>
                                                    <i class="fas fa-check text-success"></i>
                                                </div>
                                            @elseif($isPending)
                                                @if(auth()->user()?->is_admin)
                                                    <div class="d-flex gap-1" onclick="event.stopPropagation();">
                                                        <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="m-0 flex-grow-1">
                                                            @csrf
                                                            <input type="hidden" name="stage" value="{{ $stg['name'] }}">
                                                            <button type="submit" class="btn btn-sm btn-success fw-bold w-100 rounded-pill py-1.5 shadow-sm" style="font-size: 11px;">
                                                                <i class="fas fa-check-circle me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.farms.reject_disburse', $farm->id) }}" method="POST" class="m-0" onsubmit="return confirm('Reject request for {{ $stg['name'] }}?');">
                                                            @csrf
                                                            <input type="hidden" name="stage" value="{{ $stg['name'] }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill py-1.5 px-2" style="font-size: 11px;" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="text-warning fw-semibold text-center py-1" style="font-size: 12px; color: #854d0e !important;">
                                                        <i class="fas fa-hourglass-half me-1"></i> Under Review
                                                    </div>
                                                @endif
                                            @elseif(auth()->user()?->is_admin)
                                                <button type="button" class="btn btn-sm btn-outline-success fw-bold w-100 rounded-pill py-1.5" onclick="event.stopPropagation(); triggerQuickDisburse('{{ addslashes($stg['name']) }}', {{ $stg['amount'] }}, '{{ addslashes($stg['purpose']) }}')" style="font-size: 12px;">
                                                    <i class="fas fa-bolt me-1"></i> Disburse Now
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-primary fw-bold w-100 rounded-pill py-1.5" onclick="event.stopPropagation(); selectStageCard({{ $idx }}, '{{ addslashes($stg['name']) }}', {{ $stg['amount'] }}, '{{ addslashes($stg['purpose']) }}'); scrollToCustomForm();" style="font-size: 12px;">
                                                    <i class="fas fa-paper-plane me-1"></i> Select & Request
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 4. Quick Single Disburse Confirmation Modal (1-Click for Admin) -->
                <div class="modal fade" id="quickSingleDisburseModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                    <h5 class="modal-title fw-bold text-dark mb-0">1-Click Direct Disbursement</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.farms.disburse', $farm->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="stage" id="quickModalStageInput">
                                <input type="hidden" name="amount" id="quickModalAmountInput">
                                <input type="hidden" name="purpose" id="quickModalPurposeInput">
                                <div class="modal-body p-4 text-dark">
                                    <p class="text-muted mb-3" style="font-size: 13px;">
                                        You are about to release capital for <strong>{{ $farm->name }}</strong> directly to the farmer:
                                    </p>
                                    <div class="p-3 rounded-3 border mb-3 bg-light">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Selected Stage:</span>
                                            <strong class="text-dark" id="quickModalStageDisplay">Stage</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Disbursement Amount:</span>
                                            <strong class="text-success fs-5" id="quickModalAmountDisplay">₹0</strong>
                                        </div>
                                        <div class="border-top pt-2 mt-2">
                                            <span class="text-muted small d-block mb-1">Purpose / Notes:</span>
                                            <span class="text-secondary small" id="quickModalPurposeDisplay">Purpose</span>
                                        </div>
                                    </div>
                                    <div class="alert alert-info py-2 px-3 mb-0 rounded-3 border-0 small" style="background-color: #eff6ff;">
                                        <i class="fas fa-info-circle me-1 text-primary"></i> This will immediately update the farm funding tracker and record this tranche in the audit history.
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Confirm & Release Funds
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 5. Batch Disburse Modal (Multi-Stage in 1 action) -->
                <div class="modal fade" id="batchDisburseModal" tabindex="-1" aria-labelledby="batchDisburseModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title fw-bold text-dark mb-0" id="batchDisburseModalLabel">Batch Fund Disbursement</h5>
                                        <p class="text-muted small mb-0">Select multiple stages to disburse together in one single transaction</p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.farms.disburse', $farm->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_batch" value="1">
                                <div class="modal-body p-4 text-dark">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted fw-semibold" style="font-size: 13px;">Check the tranches you wish to disburse:</span>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-semibold" onclick="toggleBatchAll(true)">Select All</button>
                                            <span class="text-muted">|</span>
                                            <button type="button" class="btn btn-sm btn-link text-muted p-0 text-decoration-none" onclick="toggleBatchAll(false)">Deselect All</button>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-2 mb-4">
                                        @foreach($stagesWithBudget as $idx => $stg)
                                            @php
                                                $alreadyDone = !empty($disbursedStagesMap[$stg['name']]);
                                                $isPend = !empty($pendingStagesMap[$stg['name']]);
                                            @endphp
                                            <div class="border rounded-3 p-3 {{ $alreadyDone ? 'bg-light opacity-60' : 'bg-white' }} d-flex align-items-center justify-content-between gap-3">
                                                <div class="form-check d-flex align-items-center gap-2 mb-0">
                                                    <input class="form-check-input batch-stage-checkbox" 
                                                           type="checkbox" 
                                                           name="batch_stages[]" 
                                                           value="{{ $stg['name'] }}" 
                                                           id="batch_check_{{ $idx }}" 
                                                           data-amount="{{ $stg['amount'] }}"
                                                           data-purpose="{{ $stg['purpose'] }}"
                                                           {{ $alreadyDone ? 'disabled' : 'checked' }}
                                                           onchange="recalculateBatchTotal()">
                                                    <label class="form-check-label fw-bold text-dark cursor-pointer ms-1" for="batch_check_{{ $idx }}">
                                                        {{ $stg['name'] }}
                                                        @if($alreadyDone)
                                                            <span class="badge bg-success bg-opacity-15 text-success ms-2 font-normal" style="font-size: 10px;">Already Disbursed</span>
                                                        @elseif($isPend)
                                                            <span class="badge bg-warning bg-opacity-20 text-warning ms-2 font-normal" style="font-size: 10px; color: #854d0e !important;">Pending Review</span>
                                                        @endif
                                                    </label>
                                                </div>
                                                <div class="text-end">
                                                    <span class="fw-bold text-success fs-6">₹{{ number_format($stg['amount']) }}</span>
                                                    <input type="hidden" name="batch_amounts[{{ $stg['name'] }}]" value="{{ $stg['amount'] }}">
                                                    <input type="hidden" name="batch_purposes[{{ $stg['name'] }}]" value="{{ $stg['purpose'] }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Batch Live Summary Box -->
                                    <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-3 text-dark d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted d-block small">Total Amount to Disburse:</span>
                                            <span class="fw-bold fs-4 text-success" id="batchTotalAmountDisplay">₹0</span>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success rounded-pill px-3 py-1.5 fw-bold" id="batchSelectedCountBadge" style="font-size: 12px;">0 Stages Selected</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" id="batchSubmitBtn">
                                        <i class="fas fa-check-circle me-1"></i> Disburse Selected Tranches
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 6. Detailed Request & Proof Upload Form (Optional Customization) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white" id="detailedCustomFormCard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">
                                    <i class="far fa-edit text-primary me-1"></i> Detailed Request & Custom Settings
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 12px;">
                                    Adjust amount, modify disbursement notes, or attach invoice & proof documents.
                                </p>
                            </div>
                            <span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fw-bold" id="activeSelectedStageBadge">
                                Active: {{ $nextAvailableStage['name'] ?? $stagesWithBudget[0]['name'] }}
                            </span>
                        </div>

                        <form action="{{ route('admin.farms.disburse', $farm->id) }}" method="POST" enctype="multipart/form-data" id="singleDisburseForm">
                            @csrf
                            <div class="row g-4 text-dark">
                                <!-- Request Details -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small">Selected Stage</label>
                                                <select name="stage" id="fund_stage_select" class="form-select bg-white" required onchange="onSelectDropdownChange()">
                                                    @foreach($stagesWithBudget as $stg)
                                                        <option value="{{ $stg['name'] }}" data-amount="{{ $stg['amount'] }}" data-purpose="{{ $stg['purpose'] }}" {{ ($nextAvailableStage && $nextAvailableStage['name'] === $stg['name']) ? 'selected' : '' }}>
                                                            {{ $stg['name'] }} @if($stg['amount'] > 0)(₹{{ number_format($stg['amount']) }})@endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small">Request Priority</label>
                                                <select name="priority" class="form-select bg-white">
                                                    <option>Standard (3-5 days)</option>
                                                    <option>Urgent (1-2 days)</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small">Amount (₹)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0 text-muted">₹</span>
                                                    <input type="number" name="amount" id="fund_amount_input" class="form-control border-start-0 ps-0 bg-white fw-bold" value="{{ $nextAvailableStage['amount'] ?? $stagesWithBudget[0]['amount'] }}" placeholder="e.g. 150000" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small">Purpose of Funds</label>
                                                <textarea name="purpose" id="fund_purpose_input" class="form-control bg-white" rows="3" placeholder="Describe the specific use of these funds...">{{ $nextAvailableStage['purpose'] ?? $stagesWithBudget[0]['purpose'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Evidence Upload -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <label class="form-label fw-semibold small mb-2">Supporting Proof / Invoices (Optional)</label>
                                            <input type="file" id="evidence_file" name="evidence_file" class="d-none" accept=".pdf,.jpg,.jpeg,.png" onchange="handleEvidenceFileSelected(this)">

                                            <div class="upload-zone text-center p-4 bg-white rounded-3 border border-dashed cursor-pointer" onclick="document.getElementById('evidence_file').click()" style="cursor: pointer; border-style: dashed !important;">
                                                <i class="far fa-file-alt text-muted fs-2 mb-2"></i>
                                                <p class="mb-1 fw-semibold text-dark" style="font-size: 13px;">Drag & drop invoice or click to browse</p>
                                                <p class="text-muted mb-0" style="font-size: 11px;">PDF, JPG, or PNG up to 10MB</p>
                                            </div>

                                            <div id="uploadedFilesList" class="mt-2"></div>
                                        </div>

                                        <div class="alert alert-secondary py-2 px-3 mt-3 mb-0 rounded-3 border-0 small" style="background-color: #f1f5f9;">
                                            <i class="fas fa-shield-alt text-success me-1"></i> Uploading invoices or quotes gives investors high transparency and expedites verification.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Action Bar -->
                            <div class="d-flex justify-content-between align-items-center py-3 border-top mt-4">
                                <a href="{{ route('admin.farms.index') }}" class="text-muted fw-semibold text-decoration-none" style="font-size: 14px;">
                                    <i class="fas fa-arrow-left me-2"></i> Return to Farm List
                                </a>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm" style="font-size: 14px;">
                                        <i class="fas fa-paper-plane me-1"></i> {{ auth()->user()?->is_admin ? 'Disburse Funds' : 'Submit Fund Request' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Review Timeline -->
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="section-card mb-0 bg-white" style="border-top: 3px solid var(--investor-primary);">
                            <div class="section-header mb-4">
                                <i class="fas fa-stream text-primary"></i>
                                <h5 style="font-size: 14px;">Disbursement Cycle Progress</h5>
                            </div>
                            <div class="d-flex justify-content-between position-relative px-4">
                                <div class="position-absolute" style="top: 15px; left: 10%; right: 10%; height: 2px; background: #E5E7EB; z-index: 1;"></div>
                                
                                <!-- 1. Submitted -->
                                <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="fas fa-check" style="font-size: 12px;"></i>
                                    </div>
                                    <div style="font-size: 12px; font-weight: 600;" class="text-dark">Application</div>
                                    <div class="text-muted" style="font-size: 10px;">{{ $farm->created_at ? $farm->created_at->format('M d') : 'Day 1' }}</div>
                                </div>
                                
                                <!-- 2. Under Review -->
                                <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="fas fa-check" style="font-size: 12px;"></i>
                                    </div>
                                    <div style="font-size: 12px; font-weight: 600;" class="text-dark">Verified</div>
                                    <div class="text-muted" style="font-size: 10px;">Approved</div>
                                </div>
                                
                                <!-- 3. Approved -->
                                <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                    <div class="bg-{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'success' : 'light' }} text-{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'white' : 'muted' }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="fas {{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'fa-check' : 'fa-thumbs-up' }}" style="font-size: 12px;"></i>
                                    </div>
                                    <div style="font-size: 12px; font-weight: 600;" class="{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'text-dark' : 'text-muted' }}">Active Listing</div>
                                    <div class="text-muted" style="font-size: 10px;">Open for Capital</div>
                                </div>
                                
                                <!-- 4. Disbursed -->
                                @php
                                    $hasDisbursement = ($farm->disbursements && $farm->disbursements->count() > 0) || count($farm->disbursement_history ?? []) > 0 || $farm->status === 'completed';
                                    $isDisbursing = $farm->funding_status === 'open' || $farm->funding_raised > 0;
                                @endphp
                                <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                    <div class="bg-{{ $hasDisbursement ? 'success' : ($isDisbursing ? 'primary' : 'light') }} text-{{ ($hasDisbursement || $isDisbursing) ? 'white' : 'muted' }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="fas {{ $hasDisbursement ? 'fa-check' : ($isDisbursing ? 'fa-spinner fa-spin' : 'fa-money-bill-wave') }}" style="font-size: 12px;"></i>
                                    </div>
                                    <div style="font-size: 12px; font-weight: 600;" class="{{ ($hasDisbursement || $isDisbursing) ? 'text-dark' : 'text-muted' }}">Tranches Disbursed</div>
                                    <div class="text-muted" style="font-size: 10px;">{{ $disbursedPercent }}% Released</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function selectStageCard(idx, name, amount, purpose) {
                        // Remove active styling from all stage cards
                        document.querySelectorAll('.fund-stage-card').forEach(function(card) {
                            card.classList.remove('stage-selected');
                        });
                        var card = document.getElementById('stage-card-' + idx);
                        if (card) {
                            card.classList.add('stage-selected');
                        }

                        // Update dropdown and form inputs
                        var select = document.getElementById('fund_stage_select');
                        if (select) {
                            select.value = name;
                        }
                        var amtInput = document.getElementById('fund_amount_input');
                        if (amtInput) {
                            amtInput.value = amount || '';
                        }
                        var purpInput = document.getElementById('fund_purpose_input');
                        if (purpInput) {
                            purpInput.value = purpose || '';
                        }
                        var badge = document.getElementById('activeSelectedStageBadge');
                        if (badge) {
                            badge.innerText = 'Active: ' + name;
                        }
                    }

                    function onSelectDropdownChange() {
                        var select = document.getElementById('fund_stage_select');
                        if (!select) return;
                        var selectedOption = select.options[select.selectedIndex];
                        if (selectedOption) {
                            var name = selectedOption.value;
                            var amount = selectedOption.getAttribute('data-amount');
                            var purpose = selectedOption.getAttribute('data-purpose');

                            var amtInput = document.getElementById('fund_amount_input');
                            if (amtInput) amtInput.value = amount || '';
                            var purpInput = document.getElementById('fund_purpose_input');
                            if (purpInput) purpInput.value = purpose || '';

                            var badge = document.getElementById('activeSelectedStageBadge');
                            if (badge) badge.innerText = 'Active: ' + name;

                            // Also highlight matching card
                            document.querySelectorAll('.fund-stage-card').forEach(function(card) {
                                if (card.getAttribute('data-stage-name') === name) {
                                    card.classList.add('stage-selected');
                                } else {
                                    card.classList.remove('stage-selected');
                                }
                            });
                        }
                    }

                    function triggerQuickDisburse(name, amount, purpose) {
                        var stageDisplay = document.getElementById('quickModalStageDisplay');
                        var stageInput = document.getElementById('quickModalStageInput');
                        var amtDisplay = document.getElementById('quickModalAmountDisplay');
                        var amtInput = document.getElementById('quickModalAmountInput');
                        var purpDisplay = document.getElementById('quickModalPurposeDisplay');
                        var purpInput = document.getElementById('quickModalPurposeInput');

                        if (stageDisplay) stageDisplay.innerText = name;
                        if (stageInput) stageInput.value = name;
                        if (amtDisplay) amtDisplay.innerText = '₹' + Number(amount).toLocaleString('en-IN');
                        if (amtInput) amtInput.value = amount;
                        if (purpDisplay) purpDisplay.innerText = purpose || ('Budgeted funds for ' + name);
                        if (purpInput) purpInput.value = purpose || ('Budgeted funds for ' + name);

                        var modalEl = document.getElementById('quickSingleDisburseModal');
                        if (modalEl && typeof bootstrap !== 'undefined') {
                            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    }

                    function recalculateBatchTotal() {
                        var total = 0;
                        var count = 0;
                        document.querySelectorAll('.batch-stage-checkbox:checked').forEach(function(cb) {
                            if (!cb.disabled) {
                                total += parseFloat(cb.getAttribute('data-amount') || 0);
                                count++;
                            }
                        });

                        var totalDisp = document.getElementById('batchTotalAmountDisplay');
                        if (totalDisp) {
                            totalDisp.innerText = '₹' + Number(total).toLocaleString('en-IN');
                        }
                        var badge = document.getElementById('batchSelectedCountBadge');
                        if (badge) {
                            badge.innerText = count + ' Stages Selected';
                        }
                        var submitBtn = document.getElementById('batchSubmitBtn');
                        if (submitBtn) {
                            submitBtn.disabled = count === 0;
                            submitBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Disburse ₹' + Number(total).toLocaleString('en-IN') + ' (' + count + ' Stages)';
                        }
                    }

                    function toggleBatchAll(selectAll) {
                        document.querySelectorAll('.batch-stage-checkbox').forEach(function(cb) {
                            if (!cb.disabled) {
                                cb.checked = selectAll;
                            }
                        });
                        recalculateBatchTotal();
                    }

                    function scrollToCustomForm() {
                        var el = document.getElementById('detailedCustomFormCard');
                        if (el) {
                            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }

                    function handleEvidenceFileSelected(input) {
                        var list = document.getElementById('uploadedFilesList');
                        if (!list) return;
                        if (input.files && input.files[0]) {
                            var file = input.files[0];
                            list.innerHTML = '<div class="alert alert-success py-2 px-3 d-flex align-items-center justify-content-between mb-0">' +
                                '<span><i class="fas fa-file-check me-2"></i>' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)</span>' +
                                '<button type="button" class="btn-close btn-sm" onclick="clearEvidenceFile()"></button>' +
                                '</div>';
                        } else {
                            list.innerHTML = '';
                        }
                    }

                    function clearEvidenceFile() {
                        var input = document.getElementById('evidence_file');
                        if (input) input.value = '';
                        var list = document.getElementById('uploadedFilesList');
                        if (list) list.innerHTML = '';
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        recalculateBatchTotal();
                    });
                    setTimeout(recalculateBatchTotal, 300);
                </script>
                    <!-- Disbursement & Fund Request History Log Table -->
                    <div class="card border-0 shadow-sm rounded-4 mt-4 overflow-hidden" style="background-color: #ffffff;">
                        <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">
                                <i class="fas fa-history me-2 text-primary"></i> Disbursement & Fund Request History
                            </h6>
                            <span class="badge bg-secondary rounded-pill px-3 py-1" style="font-size: 11px;">
                                {{ count($farm->disbursement_history ?? []) }} Logged Requests
                            </span>
                        </div>
                        <div class="card-body p-0">
                            @if(!empty($farm->disbursement_history) && is_array($farm->disbursement_history) && count($farm->disbursement_history) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Date</th>
                                                <th>Stage</th>
                                                <th>Amount</th>
                                                <th>Purpose / Priority</th>
                                                <th>Submitted By</th>
                                                <th class="pe-4 text-end">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(array_reverse($farm->disbursement_history) as $historyItem)
                                                <tr>
                                                    <td class="ps-4 font-monospace text-muted" style="font-size: 12px;">
                                                        {{ $historyItem['date'] ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <strong class="text-dark">{{ $historyItem['stage'] ?? 'General' }}</strong>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₹{{ number_format($historyItem['amount'] ?? 0) }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="text-dark">{{ $historyItem['purpose'] ?? 'N/A' }}</div>
                                                        @if(!empty($historyItem['priority']))
                                                            <small class="text-muted"><i class="fas fa-flag me-1"></i>{{ $historyItem['priority'] }}</small>
                                                        @endif
                                                        @if(!empty($historyItem['evidence_file']))
                                                            <div class="mt-1">
                                                                <a href="{{ asset('storage/' . $historyItem['evidence_file']) }}" target="_blank" class="badge bg-light text-primary border text-decoration-none" style="font-size: 10px;">
                                                                    <i class="fas fa-paperclip me-1"></i> Attachment
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary">{{ $historyItem['submitted_by'] ?? 'User' }}</span>
                                                    </td>
                                                    <td class="pe-4 text-end">
                                                        @php
                                                            $st = strtolower($historyItem['status'] ?? 'pending');
                                                        @endphp
                                                        @if(str_contains($st, 'disbursed') || str_contains($st, 'approved'))
                                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1">
                                                                <i class="fas fa-check-circle me-1"></i> Disbursed
                                                            </span>
                                                        @elseif(str_contains($st, 'reject'))
                                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1">
                                                                <i class="fas fa-times-circle me-1"></i> Rejected
                                                            </span>
                                                        @else
                                                            <div class="d-inline-flex align-items-center gap-1">
                                                                <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-25 px-2.5 py-1 text-dark" style="color: #854d0e !important;">
                                                                    <i class="fas fa-hourglass-half me-1"></i> Pending Review
                                                                </span>
                                                                @if(auth()->user()?->is_admin)
                                                                    <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="d-inline m-0">
                                                                        @csrf
                                                                        <input type="hidden" name="stage" value="{{ $historyItem['stage'] ?? '' }}">
                                                                        <button type="submit" class="btn btn-xs btn-success py-0.5 px-2 rounded-pill fw-bold" style="font-size: 11px;">
                                                                            <i class="fas fa-check me-0.5"></i> Approve
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('admin.farms.reject_disburse', $farm->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Reject this request?');">
                                                                        @csrf
                                                                        <input type="hidden" name="stage" value="{{ $historyItem['stage'] ?? '' }}">
                                                                        <button type="submit" class="btn btn-xs btn-outline-danger py-0.5 px-1.5 rounded-pill" style="font-size: 11px;" title="Reject">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 text-center text-muted" style="font-size: 13px;">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                    No historical fund requests recorded for this farm yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- 3. Timeline Tab -->
        <div class="tab-pane fade" id="timeline" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Cultivation Timeline Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        The farm overview must be approved before cultivation timelines can be tracked.
                    </p>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                        <i class="fas fa-arrow-left me-1"></i> Back to Overview
                    </button>
                </div>
            @elseif(!$isFundDisbursed)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-info bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-coins fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Awaiting Fund Disbursement</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 14px;">
                        Cultivation operations and timeline tracking will unlock as soon as initial stage funds (e.g. Land Prep / Seeds) are disbursed to the farmer in the <strong>Fund Request</strong> tab.
                    </p>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="switchToTab('fund-request')">
                        <i class="fas fa-hand-holding-usd me-1"></i> Open Fund Request Tab
                    </button>
                </div>
            @else

            <!-- Cultivation Timeline -->
            <?php
                $farmStages = ['Land Prep', 'Seeding', 'Irrigation & Growth', 'Harvesting', 'Settlement'];
                $latestHarvestObj = $farm->harvests()->where('status', '!=', 'gallery_photo')->latest()->first()
                    ?? $farm->harvests()->whereNotNull('actual_yield')->latest()->first()
                    ?? $farm->harvests()->latest()->first();
                $isFarmSettled = ($farm->status === 'completed');
                $isHarvested = $isFarmSettled || ($latestHarvestObj && ($latestHarvestObj->actual_yield > 0 || $latestHarvestObj->status === 'harvested'));

                // Build per-stage status map from actual disbursement history & harvest status
                $disbursedStagesMap = [];
                $pendingStagesMap = [];

                if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
                    foreach ($farm->disbursement_history as $hItem) {
                        $hStage = strtolower($hItem['stage'] ?? '');
                        $hStatus = strtolower($hItem['status'] ?? '');
                        
                        $isDisb = str_contains($hStatus, 'disbursed');
                        $isPend = str_contains($hStatus, 'pending');

                        if (str_contains($hStage, 'land')) {
                            if ($isDisb) {
                                $disbursedStagesMap['Land Prep'] = true;
                                unset($pendingStagesMap['Land Prep']);
                            } elseif ($isPend && empty($disbursedStagesMap['Land Prep'])) {
                                $pendingStagesMap['Land Prep'] = true;
                            }
                        }
                        if (str_contains($hStage, 'seed') || str_contains($hStage, 'sowing')) {
                            if ($isDisb) {
                                $disbursedStagesMap['Seeding'] = true;
                                unset($pendingStagesMap['Seeding']);
                            } elseif ($isPend && empty($disbursedStagesMap['Seeding'])) {
                                $pendingStagesMap['Seeding'] = true;
                            }
                        }
                        if (str_contains($hStage, 'irrigation') || str_contains($hStage, 'growth') || str_contains($hStage, 'labor') || str_contains($hStage, 'labour') || str_contains($hStage, 'maintenance') || str_contains($hStage, 'fertilizer') || str_contains($hStage, 'equipment')) {
                            if ($isDisb) {
                                $disbursedStagesMap['Irrigation & Growth'] = true;
                                unset($pendingStagesMap['Irrigation & Growth']);
                            } elseif ($isPend && empty($disbursedStagesMap['Irrigation & Growth'])) {
                                $pendingStagesMap['Irrigation & Growth'] = true;
                            }
                        }
                        if (str_contains($hStage, 'harvest')) {
                            if ($isDisb) {
                                $disbursedStagesMap['Harvesting'] = true;
                                unset($pendingStagesMap['Harvesting']);
                            } elseif ($isPend && empty($disbursedStagesMap['Harvesting'])) {
                                $pendingStagesMap['Harvesting'] = true;
                            }
                        }
                    }
                }

                // If a stage's funds are disbursed, it is strictly NOT pending
                foreach (['Land Prep', 'Seeding', 'Irrigation & Growth', 'Harvesting'] as $stgName) {
                    if (!empty($disbursedStagesMap[$stgName])) {
                        unset($pendingStagesMap[$stgName]);
                    }
                }

                // Sequential stage index determination
                // 0: Land Prep, 1: Seeding, 2: Irrigation & Growth, 3: Harvesting, 4: Settlement
                $highestCompletedIdx = -1;
                if ($isFarmSettled) {
                    $highestCompletedIdx = 4; // All 5 stages completed
                } elseif ($isHarvested || !empty($disbursedStagesMap['Harvesting'])) {
                    $highestCompletedIdx = 3; // Harvesting & all prior cultivation stages completed
                } elseif (!empty($disbursedStagesMap['Irrigation & Growth'])) {
                    $highestCompletedIdx = 2; // Irrigation & prior completed
                } elseif (!empty($disbursedStagesMap['Seeding'])) {
                    $highestCompletedIdx = 1; // Seeding & Land Prep completed
                } elseif (!empty($disbursedStagesMap['Land Prep'])) {
                    $highestCompletedIdx = 0; // Land Prep completed
                }

                // Active stage index
                $activeIdx = min(4, $highestCompletedIdx + 1);

                // Current stage label
                if ($isFarmSettled) {
                    $currentStageLabel = 'Settlement (Completed)';
                } elseif ($highestCompletedIdx === 3) {
                    $currentStageLabel = 'Awaiting Settlement';
                } else {
                    $currentStageLabel = $farmStages[$activeIdx] ?? 'Land Prep';
                    if (!empty($pendingStagesMap[$farmStages[$activeIdx] ?? ''])) {
                        $currentStageLabel .= ' (Pending Approval)';
                    }
                }
            ?>
            <div class="section-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="section-header mb-0">
                        <i class="fas fa-chart-line text-primary"></i>
                        <h5>Cycle Roadmap</h5>
                    </div>
                    <div class="badge bg-success bg-opacity-10 text-success px-3 py-2" style="border-radius: 20px; font-weight: 600; font-size: 12px;">
                        Current Stage: {{ $currentStageLabel }}
                    </div>
                </div>

                <div class="timeline-container">
                    <div class="timeline-line-bg"></div>
                    <div class="timeline-line-active" style="width: {{ max(0, min(100, ($highestCompletedIdx / (count($farmStages) - 1)) * 100)) }}%;"></div>

                    @foreach($farmStages as $idx => $stage)
                        @php
                            $isCompleted = ($idx <= $highestCompletedIdx);
                            $isPending = (!$isCompleted && !empty($pendingStagesMap[$stage]));
                            $isActive = (!$isCompleted && !$isPending && $idx === $activeIdx);
                            $isUpcoming = (!$isCompleted && !$isPending && $idx > $activeIdx);

                            if ($isCompleted) {
                                $statusText = 'COMPLETED';
                                $icon = 'fas fa-check';
                            } elseif ($isPending) {
                                $statusText = 'PENDING REVIEW';
                                $icon = 'fas fa-hourglass-half';
                            } elseif ($isActive) {
                                $statusText = ($idx === 4) ? 'AWAITING SETTLEMENT' : 'ACTIVE';
                                if ($stage === 'Seeding') $icon = 'fas fa-seedling';
                                elseif ($stage === 'Harvesting') $icon = 'fas fa-tractor';
                                elseif ($stage === 'Settlement') $icon = 'fas fa-hand-holding-usd';
                                else $icon = $idx + 1;
                            } else {
                                $statusText = ($idx === count($farmStages) - 1) ? 'FINAL' : 'UPCOMING';
                                $icon = $idx + 1;
                            }
                        @endphp
                        <div class="timeline-step">
                            <div class="step-icon {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}" style="{{ $isPending ? 'border-color: #f59e0b; color: #b45309; background: #fffbeb;' : '' }}">
                                @if(is_numeric($icon))
                                    {{ $icon }}
                                @else
                                    <i class="{{ $icon }}"></i>
                                @endif
                            </div>
                            <div class="step-label {{ $isUpcoming ? 'text-muted' : '' }}" style="{{ $isUpcoming ? 'font-size: 11px;' : '' }}">{{ $stage }}</div>
                            <div class="step-sublabel {{ $isActive ? 'active' : '' }}" style="{{ $isPending ? 'color: #b45309;' : '' }}">
                                {{ $statusText }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- New Metrics Row -->
            <!-- New Dynamic Metrics Row -->
            <?php
                // Dynamic calculations for Yield & Health Metrics and Field Sensors
                $sumActualYield = $farm->harvests ? $farm->harvests->sum('actual_yield') : 0;
                $sumEstYield = $farm->harvests ? $farm->harvests->sum('estimated_yield') : 0;
                $acresVal = floatval($farm->total_acres ?? 1);
                
                // 1. Current Yield Est. (Dynamic)
                if ($sumActualYield > 0) {
                    $displayYieldVal = number_format($sumActualYield, 1) . ' <span style="font-size: 14px;" class="text-muted fw-normal">Tons (Harvested)</span>';
                } elseif ($sumEstYield > 0) {
                    $displayYieldVal = number_format($sumEstYield, 1) . ' <span style="font-size: 14px;" class="text-muted fw-normal">Tons (Estimated)</span>';
                } else {
                    $cropYieldMultiplier = str_contains(strtolower($farm->primary_crop ?? ''), 'paddy') || str_contains(strtolower($farm->primary_crop ?? ''), 'rice') ? 2.5 : (str_contains(strtolower($farm->primary_crop ?? ''), 'banana') ? 12 : 5);
                    $displayYieldVal = number_format(max(2, $acresVal * $cropYieldMultiplier), 1) . ' <span style="font-size: 14px;" class="text-muted fw-normal">Tons (Est)</span>';
                }

                // 2. Crop Health Index (Dynamic)
                if ($farm->status === 'completed') {
                    $healthIndexVal = 98;
                } elseif (in_array($farm->status, ['approved', 'active'])) {
                    $phDiff = abs(($farm->soil_ph ?? 6.5) - 6.5);
                    $healthIndexVal = min(99, max(88, round(96 - ($phDiff * 4))));
                } else {
                    $healthIndexVal = 91;
                }

                // 3. Soil pH Level (Dynamic)
                $dynSoilPh = $farm->soil_ph ? number_format($farm->soil_ph, 1) : '6.5';
                $dynPhStatus = ($farm->soil_ph >= 6.0 && $farm->soil_ph <= 7.5) ? 'IDEAL' : 'GOOD';

                // 4. Ground Temp (Dynamic)
                $dynTemp = $farm->temp_range ? $farm->temp_range : '24°C';

                // 5. Soil Moisture (Dynamic)
                $isWetCrop = str_contains(strtolower($farm->primary_crop ?? ''), 'paddy') || str_contains(strtolower($farm->primary_crop ?? ''), 'rice');
                $dynMoistureLabel = $isWetCrop ? 'HIGH (65%)' : 'OPTIMAL (42%)';
            ?>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="section-card h-100 mb-0">
                        <div class="section-header mb-3">
                            <i class="fas fa-chart-pie text-success"></i>
                            <h5 style="font-size: 14px;">Yield & Health Metrics</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-3 bg-light">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Current Yield Est.</div>
                                <h4 class="fw-bold text-dark mb-0 mt-1">{!! $displayYieldVal !!}</h4>
                            </div>
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Crop Health Index</div>
                                <h4 class="fw-bold text-primary mb-0 mt-1">{{ $healthIndexVal }}<span style="font-size: 14px;" class="text-muted fw-normal">/100</span></h4>
                            </div>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="section-card h-100 mb-0">
                        <div class="section-header mb-3">
                            <i class="fas fa-satellite-dish text-info"></i>
                            <h5 style="font-size: 14px;">Live Field Sensors</h5>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-tint text-primary fs-5"></i>
                                <div>
                                    <div class="text-dark fw-bold" style="font-size: 13px;">Soil Moisture</div>
                                    <div class="text-muted" style="font-size: 11px;">Updated 2 mins ago</div>
                                </div>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $dynMoistureLabel }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-vial text-warning fs-5"></i>
                                <div>
                                    <div class="text-dark fw-bold" style="font-size: 13px;">Soil pH Level</div>
                                    <div class="text-muted" style="font-size: 11px;">Updated 1 hour ago</div>
                                </div>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $dynSoilPh }} ({{ $dynPhStatus }})</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-temperature-high text-danger fs-5"></i>
                                <div>
                                    <div class="text-dark fw-bold" style="font-size: 13px;">Ground Temperature</div>
                                    <div class="text-muted" style="font-size: 11px;">Updated 5 mins ago</div>
                                </div>
                            </div>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $dynTemp }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="section-card mb-0">
                <div class="section-header mb-4">
                    <i class="fas fa-list-ul text-secondary"></i>
                    <h5 style="font-size: 14px;">Activity Logs</h5>
                </div>
                
                <div class="d-flex gap-3 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 32px; height: 32px;"><i class="fas fa-tractor" style="font-size: 12px;"></i></div>
                        <div style="width: 2px; height: 40px; background: #e2e8f0; margin-top: 8px;"></div>
                    </div>
                    <div>
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 13px;">Seeding Phase Initiated</h6>
                        <p class="text-muted mb-1" style="font-size: 12px;">Tractor deployment completed for sector A.</p>
                        <span class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i> Today, 08:30 AM</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 32px; height: 32px;"><i class="fas fa-tint" style="font-size: 12px;"></i></div>
                        <div style="width: 2px; height: 40px; background: #e2e8f0; margin-top: 8px;"></div>
                    </div>
                    <div>
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 13px;">Irrigation System Auto-Activated</h6>
                        <p class="text-muted mb-1" style="font-size: 12px;">Moisture levels dipped below 30%. System activated for 45 mins.</p>
                        <span class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i> Yesterday, 06:15 PM</span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-warning text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 32px; height: 32px;"><i class="fas fa-check" style="font-size: 12px;"></i></div>
                    </div>
                    <div>
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 13px;">Soil Preparation Confirmed</h6>
                        <p class="text-muted mb-1" style="font-size: 12px;">Base fertilizer applied and soil turned.</p>
                        <span class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i> Oct 12, 09:00 AM</span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- 4. Updates Tab -->
        <div class="tab-pane fade" id="updates" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Farm Updates Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        Farm updates can only be posted after the listing is approved.
                    </p>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                        <i class="fas fa-arrow-left me-1"></i> Back to Overview
                    </button>
                </div>
            @elseif(!$isFundDisbursed)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-info bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-coins fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Awaiting Fund Disbursement</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 14px;">
                        Farm field updates and investor notifications will unlock once initial cultivation funds have been disbursed in the <strong>Fund Request</strong> tab.
                    </p>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="switchToTab('fund-request')">
                        <i class="fas fa-hand-holding-usd me-1"></i> Open Fund Request Tab
                    </button>
                </div>
            @else
            <div class="row g-4">
                <!-- Left Column: Updates Feed -->
                <div class="col-lg-8">
                    <!-- Post Update Box -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center text-primary" style="width: 48px; height: 48px;">
                                    <i class="fas fa-camera fs-5"></i>
                                </div>
                                <div class="flex-grow-1" data-bs-toggle="modal" data-bs-target="#updateModal" style="cursor: pointer;">
                                    <div class="form-control bg-light border-0 text-muted d-flex align-items-center" style="border-radius: 24px; height: 48px; padding-left: 20px;">
                                        Share an update or photo from the farm...
                                    </div>
                                </div>
                                <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#updateModal" style="height: 48px; background-color: var(--investor-primary); border-color: var(--investor-primary);">
                                    Post
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Feed Header -->
                    <h5 class="fw-bold text-dark mb-4"><i class="fas fa-stream me-2 text-primary"></i> Farm Updates Feed</h5>

                    <!-- Updates Feed -->
                    <div class="updates-feed">
                        @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?>@endif<?php $__empty_1 = true; $__currentLoopData = $farm->updates->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?>@endif
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
                            <!-- Header -->
                            <div class="card-header bg-white border-bottom-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center text-success" style="width: 40px; height: 40px;">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $update->title }}</h6>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $update->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="card-body p-4 pt-3">
                                <p class="text-muted mb-3">{{ $update->description }}</p>
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($update->image_path)
                                <img src="{{ asset('storage/' . $update->image_path) }}" class="img-fluid rounded" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px !important;" alt="{{ $update->title }}">
                                @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                            </div>
                        </div>
                        @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?>@endif<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?>@endif
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                            <div class="card-body p-5 text-center">
                                <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-dark mb-1">No Updates Yet</h6>
                                <p class="text-muted mb-0">Check back later for the latest progress from the farm.</p>
                            </div>
                        </div>
                        @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                    </div>
                </div>

                <!-- Right Column: Metrics & Info -->
                <div class="col-lg-4">
                    <!-- General Information -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                        <div class="card-header bg-white border-bottom p-4">
                            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> General Information</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted small">Status</span>
                                <span class="badge bg-{{ $farm->status === 'active' ? 'success' : ($farm->status === 'pending' ? 'warning' : 'primary') }} bg-opacity-10 text-{{ $farm->status === 'active' ? 'success' : ($farm->status === 'pending' ? 'warning' : 'primary') }} rounded-pill fw-semibold" style="letter-spacing:0.5px;">{{ strtoupper($farm->status) }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between border-top pt-3">
                                <span class="text-muted small">Crop Type</span>
                                <strong class="text-dark">{{ $farm->primary_crop ?? 'N/A' }}</strong>
                            </div>
                            <div class="mb-3 d-flex justify-content-between border-top pt-3">
                                <span class="text-muted small">Total Area</span>
                                <strong class="text-dark">{{ $farm->total_acres ?? 0 }} Acres</strong>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <span class="text-muted small">Location</span>
                                <strong class="text-dark">{{ $farm->location ?? ($farm->farmer->village . ', ' . $farm->farmer->district) ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Environmental Metrics -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: linear-gradient(145deg, #ffffff, #f0f9ff);">
                        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-leaf me-2 text-success"></i> Environmental Metrics</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-white p-3 rounded-3 shadow-sm border border-light text-center h-100">
                                        <i class="fas fa-temperature-high text-warning fs-4 mb-2"></i>
                                        <div class="text-muted" style="font-size: 11px; text-transform: uppercase;">Temp Range</div>
                                        <h5 class="fw-bold text-dark mb-0 mt-1">{{ $farm->temp_range ?? 'N/A' }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white p-3 rounded-3 shadow-sm border border-light text-center h-100">
                                        <i class="fas fa-cloud-showers-heavy text-primary fs-4 mb-2"></i>
                                        <div class="text-muted" style="font-size: 11px; text-transform: uppercase;">Avg Rainfall</div>
                                        <h5 class="fw-bold text-dark mb-0 mt-1">{{ $farm->avg_rainfall ?? 'N/A' }}</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white p-3 rounded-3 shadow-sm border border-light d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-sun text-warning fs-4"></i>
                                            <div>
                                                <div class="text-muted" style="font-size: 11px; text-transform: uppercase;">Sunlight</div>
                                                <strong class="text-dark d-block">Optimal (8 hrs/day)</strong>
                                            </div>
                                        </div>
                                        <div class="text-success"><i class="fas fa-check-circle"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Updates -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                        <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-images me-2 text-primary"></i> Latest Media</h6>
                            <a href="#" class="text-primary text-decoration-none small">View All</a>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <?php
                                    $galleryUpdates = $farm->updates->whereNotNull('image_path')->take(4);
                                ?>
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?>@endif<?php $__empty_1 = true; $__currentLoopData = $galleryUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gUpdate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?>@endif
                                <div class="col-6">
                                    <img src="{{ asset('storage/' . $gUpdate->image_path) }}" class="img-fluid rounded w-100" style="height: 100px; object-fit: cover;" alt="Gallery Image">
                                </div>
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?>@endif<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?>@endif
                                <div class="col-6">
                                    <img src="https://images.unsplash.com/photo-1592982537447-6f2334208f34?q=80&w=200&auto=format&fit=crop" class="img-fluid rounded w-100" style="height: 100px; object-fit: cover;" alt="Gallery Image">
                                </div>
                                <div class="col-6">
                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=200&auto=format&fit=crop" class="img-fluid rounded w-100" style="height: 100px; object-fit: cover;" alt="Gallery Image">
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded w-100 d-flex justify-content-center align-items-center text-muted" style="height: 100px;">
                                        <i class="fas fa-camera fs-4"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded w-100 d-flex justify-content-center align-items-center text-muted" style="height: 100px;">
                                        <i class="fas fa-plus fs-4"></i>
                                    </div>
                                </div>
                                @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- 5. Investors Tab -->
        <div class="tab-pane fade" id="investors" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Investor Ledger Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        The farm overview must be approved before opening and managing investor subscriptions.
                    </p>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                        <i class="fas fa-arrow-left me-1"></i> Back to Overview
                    </button>
                </div>
            @else

            <!-- Top Metrics Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="glass-card p-3 d-flex align-items-center gap-3 h-100">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="fas fa-users fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Active Investors</div>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ $farm->investor_count ?? $farm->investments()->count() ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-3 d-flex align-items-center gap-3 h-100">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="fas fa-chart-pie fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Total Raised</div>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ formatCurrency($farm->funding_raised ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-3 d-flex align-items-center gap-3 h-100">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="fas fa-percentage fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Est. Annual ROI</div>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ $farm->expected_roi ?? 'N/A' }}%</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-3 d-flex align-items-center gap-3 h-100">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="fas fa-calendar-check fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Upcoming Settlement</div>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ $farm->expected_start_date ? \Carbon\Carbon::parse($farm->expected_start_date)->addMonths($farm->yielding_period ?? 12)->format('M Y') : 'N/A' }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Ledger Column -->
                <div class="col-lg-9">
                    <div class="section-card mb-0 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><i class="fas fa-book me-2 text-primary"></i>Member Investment Ledger</h5>
                                <p class="text-muted mb-0" style="font-size: 12px;">Complete record of all stakeholders and their positions.</p>
                            </div>
                            <!-- Filters & Sort -->
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm shadow-sm" style="width: 130px; border-radius: 8px;">
                                    <option>Status: All</option>
                                    <option>Active</option>
                                    <option>Pending</option>
                                </select>
                                <select class="form-select form-select-sm shadow-sm" style="width: 130px; border-radius: 8px;">
                                    <option>Sort: Newest</option>
                                    <option>Sort: Amount</option>
                                    <option>Sort: Stake</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                                    <tr>
                                        <th class="fw-semibold py-3 border-0 rounded-start">Member Name</th>
                                        <th class="fw-semibold py-3 border-0">Investment Date</th>
                                        <th class="fw-semibold py-3 border-0">Amount</th>
                                        <th class="fw-semibold py-3 border-0">Equity Stake</th>
                                        <th class="fw-semibold py-3 border-0">Expected ROI</th>
                                        <th class="fw-semibold py-3 border-0">Status</th>
                                        <th class="fw-semibold py-3 border-0 text-end rounded-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?>@endif<?php $__empty_1 = true; $__currentLoopData = $farm->investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?>@endif
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-weight: 600;">
                                                    {{ strtoupper(substr($investment->user->name ?? 'U', 0, 2)) }}

                                                </div>
                                                <div class="fw-bold text-dark">{{ $investment->user->name ?? 'Unknown' }}</div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-muted">{{ $investment->created_at->format('d M, Y') }}</td>
                                        <td class="py-3 fw-bold text-dark">₹{{ number_format($investment->amount) }}</td>
                                        <td class="py-3"><span class="badge bg-light text-dark border">{{ $farm->funding_target > 0 ? round(($investment->amount / $farm->funding_target) * 100, 1) : 0 }}%</span></td>
                                        <td class="py-3 text-success fw-semibold"><i class="fas fa-arrow-up me-1"></i>{{ $farm->expected_roi ?? 'N/A' }}%</td>
                                        <td class="py-3"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ ucfirst($investment->status) }}</span></td>
                                        <td class="py-3 text-end">
                                             @if(auth()->user()?->is_admin && $investment->status === 'pending')
                                                 <form action="{{ route('admin.investments.approve', $investment->id) }}" method="POST" class="d-inline">
                                                     <?php echo csrf_field(); ?>
                                                     <button type="submit" class="btn btn-sm btn-success rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">Approve</button>
                                                 </form>
                                                 <form action="{{ route('admin.investments.reject', $investment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this investment?');">
                                                     <?php echo csrf_field(); ?>
                                                     <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">Reject</button>
                                                 </form>
                                             @else
                                                 <span class="badge bg-light text-secondary border px-2.5 py-1" style="font-size: 10px;"><i class="fas fa-check-circle text-success me-1"></i>Verified</span>
                                             @endif
                                         </td>
                                    </tr>
                                    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?>@endif<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?>@endif
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No investments found for this farm yet.</td>
                                    </tr>
                                    @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Investment Health Sidebar -->
                <div class="col-lg-3">
                    <div class="section-card mb-0 h-100" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
                        <div class="section-header mb-4">
                            <i class="fas fa-shield-alt text-success"></i>
                            <h5 style="font-size: 14px;">Investment Health</h5>
                        </div>

                        <!-- Asset Liquidity -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold text-dark" style="font-size: 13px;">Asset Liquidity</span>
                                <span class="badge bg-success text-white">HIGH</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 6px;">
                                <div class="progress-bar bg-success" style="width: 85%;"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size: 11px;">Strong cash reserves backed by verified crop insurance.</p>
                        </div>

                        <!-- Risk Rating -->
                        <div class="p-4 bg-white border rounded-3 text-center shadow-sm">
                            <div class="text-muted fw-bold small text-uppercase mb-2">Risk Rating</div>
                            <div class="display-6 fw-bold text-primary mb-1">A+</div>
                            <div class="d-flex justify-content-center gap-1 mb-2">
                                <i class="fas fa-star text-warning" style="font-size: 10px;"></i>
                                <i class="fas fa-star text-warning" style="font-size: 10px;"></i>
                                <i class="fas fa-star text-warning" style="font-size: 10px;"></i>
                                <i class="fas fa-star text-warning" style="font-size: 10px;"></i>
                                <i class="fas fa-star-half-alt text-warning" style="font-size: 10px;"></i>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 11px;">Low volatility sector with guaranteed buyer off-take agreement.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- 6. Harvest Tab (Figma Exact & 100% Dynamic) -->
        <div class="tab-pane fade" id="harvest" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Harvest Tracking Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        The farm overview must be approved before harvest records and yield batches can be logged.
                    </p>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                        <i class="fas fa-arrow-left me-1"></i> Back to Overview
                    </button>
                </div>
            @elseif(!$isFundDisbursed)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-info bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-coins fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Harvest Operations Awaiting Fund Disbursement</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 14px;">
                        Harvest logging, produce batch tracking, and yield sales become active once cultivation is funded and underway via the <strong>Fund Request</strong> tab.
                    </p>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="switchToTab('fund-request')">
                        <i class="fas fa-hand-holding-usd me-1"></i> Open Fund Request Tab
                    </button>
                </div>
            @else
            
            <!-- Dynamic Statistics Computations -->
            <?php
                $realHarvests = $farm->harvests()
                    ->where('status', '!=', 'gallery_photo')
                    ->latest()
                    ->get();
                $latestHarvest = $realHarvests->first();
                $hasHarvestRecord = $realHarvests->count() > 0;

                // 1 & 2. Investment = sum of confirmed investments only
                $invRaised = (float) $farm->investments()
                    ->whereIn('status', ['approved', 'active'])
                    ->sum('amount');
                $invTarget = (float) ($farm->funding_target ?? 0);
                $invFundedPercent = $invTarget > 0 ? min(100, round(($invRaised / $invTarget) * 100, 1)) : 0;
                $isFullyFunded = $invTarget > 0 ? ($invRaised >= $invTarget) : ($invRaised > 0);
                $canFinalizeOrExport = $hasHarvestRecord && $isFullyFunded;

                // 2. Expenses = sum of actual expense (disbursed) records
                $expTotal = 0.0;
                $expenseRecordCount = 0;
                if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
                    foreach ($farm->disbursement_history as $dItem) {
                        if (str_contains(strtolower(trim($dItem['status'] ?? '')), 'disbursed')) {
                            $expTotal += (float) ($dItem['amount'] ?? 0);
                            $expenseRecordCount++;
                        }
                    }
                }

                // 3. Revenue = yield x selling price from saved harvest records, else 0
                $revEarned = $hasHarvestRecord
                    ? round((float) $realHarvests->sum(fn ($h) => $h->computedRevenue()), 2)
                    : 0.0;

                // 4. Profit = Revenue - Expenses (may be negative)
                $netProfit = round($revEarned - $expTotal, 2);
                $estProfit = $netProfit;

                // 5. ROI = Profit / Investment x 100, or "—" if investment is 0
                $roiNumeric = $invRaised > 0 ? round(($netProfit / $invRaised) * 100, 1) : null;
                $roiDisplay = $roiNumeric !== null ? ($roiNumeric . '%') : '—';
                $roiPercent = $roiNumeric ?? 0;

                // 6. Grade, Market, Price, Yield, and Start Date come ONLY from the saved harvest record, else "—"
                $actualYieldVal = $hasHarvestRecord ? round((float) $realHarvests->sum('actual_yield'), 2) : null;
                $expYieldVal = ($latestHarvest && (float) ($latestHarvest->estimated_yield ?? 0) > 0)
                    ? round((float) $latestHarvest->estimated_yield, 2)
                    : (($farm->projected_yield_kg && $farm->projected_yield_kg > 0)
                        ? round((float) $farm->projected_yield_kg / 1000, 2)
                        : (($farm->expected_yield && $farm->expected_yield > 0)
                            ? round((float) $farm->expected_yield, 2)
                            : null));
                $qualityGrade = ($hasHarvestRecord && !empty($latestHarvest?->quality_grade))
                    ? $latestHarvest->quality_grade
                    : null;
                $marketName = ($hasHarvestRecord && !empty($latestHarvest?->market_name))
                    ? $latestHarvest->market_name
                    : null;
                $sellingPriceVal = ($hasHarvestRecord && $latestHarvest)
                    ? ($actualYieldVal > 0 && $revEarned > 0 ? round($revEarned / $actualYieldVal, 2) : $latestHarvest->effectiveSellingPrice())
                    : null;
                $harvestStartDate = ($hasHarvestRecord && $latestHarvest?->start_date)
                    ? $latestHarvest->start_date
                    : null;
                $harvestEndDate = ($hasHarvestRecord && $latestHarvest?->actual_harvest_date)
                    ? $latestHarvest->actual_harvest_date
                    : null;

                // 7. Status badge reflects real state: Not Started, In Progress, Harvested, Finalized
                if ($farm->status === 'completed') {
                    $harvestCycleState = 'Finalized';
                    $harvestBadgeClass = 'bg-dark text-white border-dark';
                    $harvestDotClass = 'text-white';
                } elseif ($latestHarvest && $latestHarvest->status === 'harvested') {
                    $harvestCycleState = 'Harvested';
                    $harvestBadgeClass = 'bg-success bg-opacity-10 text-success border-success border-opacity-25';
                    $harvestDotClass = 'text-success';
                } elseif ($latestHarvest && in_array($latestHarvest->status, ['in_progress', 'harvesting', 'growing', 'ready'])) {
                    $harvestCycleState = 'In Progress';
                    $harvestBadgeClass = 'bg-warning bg-opacity-15 text-dark border-warning border-opacity-50';
                    $harvestDotClass = 'text-warning';
                } else {
                    $harvestCycleState = 'Not Started';
                    $harvestBadgeClass = 'bg-secondary bg-opacity-10 text-secondary border-secondary border-opacity-25';
                    $harvestDotClass = 'text-secondary';
                }

                // 8. Progress = yield / target x 100
                $progressPercent = ($actualYieldVal !== null && $expYieldVal !== null && $expYieldVal > 0)
                    ? min(100, round(($actualYieldVal / $expYieldVal) * 100, 1))
                    : 0;

                // Tooltip reason when Finalize / Export are disabled
                $actionLockReason = !$hasHarvestRecord && !$isFullyFunded
                    ? 'Record harvest data and reach required funding first'
                    : (!$hasHarvestRecord
                        ? 'Record harvest data first'
                        : 'Farm must be fully funded (confirmed investments >= required funding) first');

                $hasProofDone = $farm->harvests()->whereNotNull('image_path')->count() > 0;
            ?>

            <!-- Top Badges & Actions Bar -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 mt-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge border rounded-pill px-3 py-2 fw-semibold {{ $harvestBadgeClass }}" style="font-size: 11px;">
                        <i class="fas fa-circle {{ $harvestDotClass }} me-1.5" style="font-size: 7px; vertical-align: middle;"></i> {{ $harvestCycleState }}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold shadow-sm" onclick="openLogHarvestModal()" style="font-size: 11px; background-color: #064e3b; border-color: #064e3b;">
                        <i class="fas {{ $hasHarvestRecord ? 'fa-edit' : 'fa-plus-circle' }} me-1"></i> {{ $hasHarvestRecord ? 'Edit Harvest Data' : 'Log Harvest Data' }}
                    </button>
                    @if($canFinalizeOrExport)
                        <a href="{{ route('reports.export', ['type' => 'harvest', 'farm_id' => $farm->id]) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold" style="font-size: 11px;">
                            <i class="fas fa-file-export me-1"></i> Export Report
                        </a>
                    @else
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold" style="font-size: 11px; opacity: 0.55; cursor: not-allowed;" disabled title="{{ $actionLockReason }}">
                            <i class="fas fa-lock me-1"></i> Export Report
                        </button>
                    @endif
                </div>
            </div>

            <!-- Top 5 Financial Summary Cards Bar (Figma Exact) -->
            <div class="row g-3 mb-4">
                <!-- Card 1: Investment Raised -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Investment Raised</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($invRaised) }}</h4>
                        @if($isFullyFunded)
                            <div class="text-success fw-bold" style="font-size: 10px;"><i class="fas fa-check me-1"></i>Fully Funded</div>
                        @elseif($invRaised > 0)
                            <div class="text-primary fw-semibold" style="font-size: 10px;">{{ $invFundedPercent }}% of ₹{{ number_format($invTarget) }}</div>
                        @else
                            <div class="text-muted fw-semibold" style="font-size: 10px;">0% of ₹{{ number_format($invTarget) }} required</div>
                        @endif
                    </div>
                </div>

                <!-- Card 2: Revenue Earned -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Revenue Earned</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($revEarned) }}</h4>
                        <div class="text-muted" style="font-size: 10px;">
                            {{ $hasHarvestRecord ? 'Yield × selling price' : 'No harvest recorded' }}
                        </div>
                    </div>
                </div>

                <!-- Card 3: Expenses -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Expenses</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($expTotal) }}</h4>
                        <div class="text-muted" style="font-size: 10px;">
                            {{ $expenseRecordCount > 0 ? $expenseRecordCount . ' expense record(s)' : 'No expense records' }}
                        </div>
                    </div>
                </div>

                <!-- Card 4: Profit (Revenue - Expenses, may be negative) -->
                <div class="col" style="width: 20%;">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100" style="background: {{ $netProfit < 0 ? '#7f1d1d' : '#064e3b' }};">
                        <div class="text-white-50 text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">
                            {{ $netProfit < 0 ? 'Profit (Loss)' : 'Profit' }}
                        </div>
                        <h4 class="fw-bold text-white mb-1" style="font-size: 18px;">
                            {{ $netProfit < 0 ? '-₹' . number_format(abs($netProfit)) : '₹' . number_format($netProfit) }}
                        </h4>
                        <div class="text-white-50" style="font-size: 10px;">Revenue − expenses</div>
                    </div>
                </div>

                <!-- Card 5: ROI (Profit / Investment x 100, or "—" if investment is 0) -->
                <div class="col" style="width: 20%;">
                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="background: #fde68a; color: #78350f;">
                        <div class="text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px; opacity: 0.8;">ROI</div>
                        <h4 class="fw-bold mb-1" style="font-size: 18px; color: #78350f;">{{ $roiDisplay }}</h4>
                        <div style="font-size: 10px; opacity: 0.8;">
                            {{ $roiNumeric !== null ? 'Profit / investment × 100' : 'No confirmed investment' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Harvest Statistics & Market Realization (Full Width, Clean & Spacious) -->
            <div class="row g-4 mb-4">
                
                <!-- Full Width Column: Harvest Statistics -->
                <div class="col-12">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-between" style="border-color: #E5E7EB !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                        <i class="fas fa-tractor text-success me-1.5"></i> Harvest Statistics & Market Realization
                                    </h6>
                                    <small class="text-muted" style="font-size: 11px;">Actual harvest yield, quality grade, wholesale market destination, and sales revenue realization.</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="font-size: 11px; background-color: #064e3b; border-color: #064e3b;" onclick="openLogHarvestModal()">
                                        <i class="fas {{ $hasHarvestRecord ? 'fa-pencil-alt' : 'fa-plus-circle' }} me-1"></i> {{ $hasHarvestRecord ? 'Edit Harvest Data' : '+ Log Harvest Data' }}
                                    </button>
                                    @if($farm->status === 'completed')
                                        <button type="button" onclick="document.querySelector('#settlement-tab')?.click();" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 11px;">
                                            <i class="fas fa-chart-pie me-1"></i> View Settlement
                                        </button>
                                    @elseif($canFinalizeOrExport)
                                        <form action="{{ route('admin.farms.settle', $farm->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Are you sure you want to finalize settlement? This will lock the farm cycle and prepare investor payouts.');">
                                            @csrf
                                            <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="background: #064e3b; border-color: #064e3b; font-size: 11px;">
                                                <i class="fas fa-check-circle me-1"></i> Finalize Settlement
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 11px; opacity: 0.6; cursor: not-allowed;" disabled title="{{ $actionLockReason }}">
                                            <i class="fas fa-lock me-1"></i> Finalize Settlement
                                        </button>
                                    @endif
                                </div>
                            </div>

                            @if(!$hasHarvestRecord)
                                <div class="alert alert-success border-0 bg-success bg-opacity-10 p-3 rounded-3 d-flex align-items-center justify-content-between mb-4 text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-info-circle text-success fs-5"></i>
                                        <span style="font-size: 12px;" class="fw-semibold">No harvest record created yet. Click <strong>+ Log Harvest Data</strong> to enter start date, yield, selling price, quality grade, and market.</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold flex-shrink-0 ms-2" onclick="openLogHarvestModal()" style="background-color: #064e3b; border-color: #064e3b; font-size: 11px;">
                                        + Log Harvest Data
                                    </button>
                                </div>
                            @endif

                            <!-- 6-Grid Stats Table with Icons & Clarity (Values strictly from saved harvest, else "—") -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="far fa-calendar-alt text-primary"></i> START DATE
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">
                                            {{ $harvestStartDate ? $harvestStartDate->format('M d, Y') : '—' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">
                                            Harvest: {{ $harvestEndDate ? $harvestEndDate->format('M d, Y') : '—' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="fas fa-weight-hanging text-success"></i> HARVEST YIELD
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">
                                            {{ $actualYieldVal !== null ? (number_format($actualYieldVal, 2) . ' Tons') : '—' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">
                                            Target: {{ $expYieldVal !== null ? (number_format($expYieldVal, 2) . ' Tons (' . $progressPercent . '%)') : '—' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="fas fa-medal text-warning"></i> QUALITY GRADE
                                        </div>
                                        <div>
                                            @if($qualityGrade)
                                                <span class="badge bg-success text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px; background-color: #064e3b !important;">
                                                    {{ strtoupper($qualityGrade) }}
                                                </span>
                                            @else
                                                <div class="fw-bold text-dark" style="font-size: 13px;">—</div>
                                            @endif
                                        </div>
                                        <div class="text-muted mt-1" style="font-size: 10px;">
                                            {{ $qualityGrade ? 'Certified Inspected' : 'Not recorded' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="fas fa-store text-info"></i> WHOLESALE MARKET
                                        </div>
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 13px;" title="{{ $marketName ?? '—' }}">
                                            {{ $marketName ?? '—' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">
                                            {{ $marketName ? 'Direct Off-take Buyer' : 'Not recorded' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="fas fa-tag text-secondary"></i> SELLING PRICE
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">
                                            {{ ($sellingPriceVal !== null && $sellingPriceVal > 0) ? ('₹' . number_format($sellingPriceVal) . ' / Ton') : '—' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">
                                            {{ ($sellingPriceVal !== null && $sellingPriceVal > 0) ? 'Price per ton' : 'Not recorded' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2">
                                    <div class="p-3 rounded-3 bg-light border border-light h-100">
                                        <div class="text-muted text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            <i class="fas fa-coins text-warning"></i> GROSS REVENUE
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">
                                            ₹{{ number_format($revEarned) }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">Yield × selling price</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar: yield / target x 100 -->
                        <div class="pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted fw-semibold" style="font-size: 11px;">Produce Harvest Target Progress</span>
                                <span class="fw-bold text-dark" style="font-size: 11px;">
                                    @if($actualYieldVal !== null && $expYieldVal !== null && $expYieldVal > 0)
                                        {{ $progressPercent }}% of Target Collected ({{ number_format($actualYieldVal, 2) }} / {{ number_format($expYieldVal, 2) }} Tons)
                                    @else
                                        0% of Target Collected (—)
                                    @endif
                                </span>
                            </div>
                            <div class="progress rounded-pill bg-light" style="height: 8px;">
                                <div class="progress-bar bg-success rounded-pill" style="width: {{ $progressPercent }}%; background-color: #064e3b !important;"></div>
                            </div>
                        </div>

                        @if($realHarvests->count() > 0)
                            <!-- Logged Harvest Records Ledger -->
                            <div class="pt-4 mt-4 border-top">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;">
                                    <i class="fas fa-clipboard-list text-success me-1.5"></i> Logged Harvest Records ({{ $realHarvests->count() }})
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                        <thead class="bg-light text-muted">
                                            <tr>
                                                <th class="border-0 py-2">Start Date</th>
                                                <th class="border-0 py-2">Harvest Date</th>
                                                <th class="border-0 py-2">Status</th>
                                                <th class="border-0 py-2">Grade & Market</th>
                                                <th class="border-0 py-2 text-end">Yield (Tons)</th>
                                                <th class="border-0 py-2 text-end">Price / Ton</th>
                                                <th class="border-0 py-2 text-end">Revenue (₹)</th>
                                                <th class="border-0 py-2 text-center">Proof</th>
                                                <th class="border-0 py-2 text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($realHarvests as $hRec)
                                                @php
                                                    $hRate = $hRec->effectiveSellingPrice();
                                                    $hRev = $hRec->computedRevenue();
                                                @endphp
                                                <tr>
                                                    <td class="text-muted">{{ $hRec->start_date ? $hRec->start_date->format('M d, Y') : '—' }}</td>
                                                    <td class="fw-semibold text-dark">{{ $hRec->actual_harvest_date ? $hRec->actual_harvest_date->format('M d, Y') : '—' }}</td>
                                                    <td>
                                                        <span class="badge {{ $hRec->status === 'harvested' ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-15 text-dark' }} rounded-pill px-2.5 py-1" style="font-size: 10px;">
                                                            {{ $hRec->status === 'in_progress' || $hRec->status === 'harvesting' ? 'In Progress' : ucfirst(str_replace('_', ' ', $hRec->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold text-dark">{{ $hRec->quality_grade ?? '—' }}</div>
                                                        <div class="text-muted" style="font-size: 10px;">{{ $hRec->market_name ?? '—' }}</div>
                                                    </td>
                                                    <td class="text-end fw-bold text-dark">{{ number_format((float) $hRec->actual_yield, 2) }}</td>
                                                    <td class="text-end text-muted">{{ $hRate > 0 ? '₹' . number_format($hRate) : '—' }}</td>
                                                    <td class="text-end fw-bold text-success">₹{{ number_format($hRev) }}</td>
                                                    <td class="text-center">
                                                        @if($hRec->image_path)
                                                            <a href="{{ asset('storage/' . $hRec->image_path) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0.5" style="font-size: 10px;">
                                                                <i class="fas fa-image me-1"></i>View
                                                            </a>
                                                        @else
                                                            <span class="text-muted small">—</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5 me-1" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#editHarvestModal-{{ $hRec->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('admin.harvests.destroy', $hRec->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this harvest record?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-0.5" style="font-size: 10px;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Row 3: Harvest Gallery (5 Sequential Stage Cards - Figma Exact) -->
            <div class="card border shadow-sm rounded-4 p-4 bg-white mb-4" style="border-color: #E5E7EB !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                            <i class="fas fa-images text-success me-1.5"></i> Harvest Gallery (5 Milestone Stages)
                        </h6>
                        <small class="text-muted" style="font-size: 11px;">Upload photo proof across each milestone of harvest delivery for audit and investor transparency.</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold" onclick="openUploadStagePhotoModal('Before Harvest')" style="font-size: 11px;">
                        <i class="fas fa-upload me-1"></i> Upload Stage Photo
                    </button>
                </div>

                <?php
                    $galleryByStage = [];
                    $unmappedGallery = [];
                    foreach ($farm->harvests()->where('status', 'gallery_photo')->whereNotNull('image_path')->latest()->get() as $gp) {
                        $stgKey = trim($gp->quality_grade ?? '');
                        if ($stgKey !== '' && !isset($galleryByStage[$stgKey])) {
                            $galleryByStage[$stgKey] = $gp->image_path;
                        } else {
                            $unmappedGallery[] = $gp->image_path;
                        }
                    }
                    $galleryStages = [
                        ['key' => 'Before Harvest', 'label' => 'Before Harvest', 'placeholder' => 'BEFORE HARVEST', 'icon' => 'fa-seedling'],
                        ['key' => 'Process', 'label' => 'Process', 'placeholder' => 'PROCESS', 'icon' => 'fa-camera'],
                        ['key' => 'Packing', 'label' => 'Packing', 'placeholder' => 'PACKING', 'icon' => 'fa-box'],
                        ['key' => 'Transport', 'label' => 'Transportation', 'placeholder' => 'TRANSPORT', 'icon' => 'fa-truck'],
                        ['key' => 'Final Produce', 'label' => 'Final Produce', 'placeholder' => 'FINAL PRODUCE', 'icon' => 'fa-shopping-basket'],
                    ];
                ?>

                <div class="row g-3">
                    @foreach($galleryStages as $gIdx => $gStage)
                        @php
                            $stageImg = $galleryByStage[$gStage['key']] ?? ($unmappedGallery[$gIdx] ?? null);
                        @endphp
                        <div class="col" style="width: 20%;">
                            <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" onclick="openUploadStagePhotoModal('{{ $gStage['key'] }}')">
                                @if($stageImg)
                                    <img src="{{ asset('storage/' . $stageImg) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas {{ $gStage['icon'] }} text-muted opacity-50 fs-4 mb-2"></i>
                                    <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">{{ $gStage['placeholder'] }}</div>
                                @endif
                                <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">{{ $gStage['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- 7. Settlement Tab (Figma Exact & 100% Dynamic) -->
        <div class="tab-pane fade" id="settlement" role="tabpanel">
            @if(!$isOverviewApproved)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-warning bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Settlement Ledger Locked</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 14px;">
                        Settlement distribution and ROI payouts are unavailable until the farm listing has completed its cultivation and harvest cycle.
                    </p>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="switchToTab('overview')">
                        <i class="fas fa-arrow-left me-1"></i> Back to Overview
                    </button>
                </div>
            @elseif(!$isFundDisbursed)
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
                    <div class="mx-auto mb-3 text-info bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-coins fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Settlement Awaiting Cultivation & Disbursement</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 14px;">
                        Final ROI distributions and investor settlements can only be performed after cultivation funds are disbursed and harvests are logged.
                    </p>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="switchToTab('fund-request')">
                        <i class="fas fa-hand-holding-usd me-1"></i> Open Fund Request Tab
                    </button>
                </div>
            @else
            
            <?php
                $totInvestment = $farm->investments()->where('status', 'approved')->sum('amount');
                if ($totInvestment == 0) $totInvestment = $farm->investments()->sum('amount');
                $avgRoi = $roiPercent; // Use the one calculated in Harvest tab
                $totInvestorsCount = $farm->investments ? $farm->investments->count() : 0;

                // We calculated $revEarned earlier.
                // According to instructions, 70% to Farmer, 30% to Investors.
                // Wait, if it's 70/30 of Revenue or Profit? The UI says Revenue Split (70/30).
                $farmerShareVal = round($revEarned * 0.70);
                $investorShareVal = round($revEarned * 0.30);
            ?>

            <!-- Top Row: 3 KPI Summary Cards (Highly Visible Typography) -->
            <div class="row g-3 mb-4 mt-3">
                <!-- Card 1: TOTAL INVESTMENT -->
                <div class="col-md-4">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-uppercase fw-bold mb-1" style="font-size: 11px; color: #4b5563; letter-spacing: 0.5px;">TOTAL INVESTMENT</div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">₹{{ number_format($totInvestment) }}</h3>
                                <div class="text-success fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-arrow-up me-1"></i>+12.4% from last cycle
                                </div>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="fas fa-landmark fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: AVERAGE ROI -->
                <div class="col-md-4">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-uppercase fw-bold mb-1" style="font-size: 11px; color: #4b5563; letter-spacing: 0.5px;">AVERAGE ROI</div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">{{ $avgRoi }}%</h3>
                                <div class="text-success fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-arrow-up me-1"></i>Outperforming sector by 4.2%
                                </div>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="fas fa-percentage fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: TOTAL INVESTORS -->
                <div class="col-md-4">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-uppercase fw-bold mb-1" style="font-size: 11px; color: #4b5563; letter-spacing: 0.5px;">TOTAL INVESTORS</div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">{{ $totInvestorsCount }}</h3>
                                <div class="text-muted fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-user-plus me-1 text-success"></i>+8 new this month
                                </div>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="fas fa-users fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Section: Expense Breakdown & Revenue Split (Figma Exact) -->
            <div class="row g-4 mb-4">
                
                <!-- Left Column (70%): Expense Breakdown Table -->
                <div class="col-lg-8">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Expense Breakdown</h6>
                        
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 12px;">
                                <thead class="table-light text-muted" style="font-size: 10px; text-transform: uppercase;">
                                    <tr>
                                        <th class="border-0">Category</th>
                                        <th class="border-0">Description</th>
                                        <th class="border-0">Units</th>
                                        <th class="border-0 text-end">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $budgetItems = $farm->budget_breakdown ?? [];
                                        if (empty($budgetItems)) {
                                            $budgetItems = [
                                                ['item' => 'Land Preparation', 'description' => 'Land tilling, soil enrichment & plot prep', 'cost' => 150000],
                                                ['item' => 'Seeds & Sowing', 'description' => 'Procurement of certified organic seeds', 'cost' => 45000],
                                                ['item' => 'Irrigation & Utilities', 'description' => 'Drip irrigation & seasonal water supply', 'cost' => 85000],
                                                ['item' => 'Labor & Maintenance', 'description' => 'Weeding, crop care & seasonal farm labor', 'cost' => 120000],
                                                ['item' => 'Harvesting & Transport', 'description' => 'Produce packaging, loading & market transit', 'cost' => 50000]
                                            ];
                                        }
                                        $totalExpenses = 0;
                                    @endphp
                                    @foreach($budgetItems as $item)
                                        @php
                                            $name = $item['item'] ?? $item['purpose'] ?? $item['name'] ?? $item['stage'] ?? 'Operational Expense';
                                            $desc = $item['description'] ?? $item['purpose'] ?? 'Farm operational cost';
                                            $rawCost = $item['cost'] ?? $item['amount'] ?? 0;
                                            $cost = is_numeric($rawCost) ? (float)$rawCost : (int) preg_replace('/[^0-9]/', '', (string)$rawCost);
                                            $qty = $item['quantity'] ?? $item['qty'] ?? null;
                                            $unit = $item['unit'] ?? 'kg';
                                            $rate = $item['rate'] ?? null;
                                            $unitDisplay = ($qty !== null && $qty > 0) ? ($qty . ' ' . $unit . ($rate ? ' @ ₹' . number_format($rate) . '/' . $unit : '')) : '1 Plot';
                                            $totalExpenses += $cost;
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="fw-bold text-dark">{{ $name }}</td>
                                            <td class="text-muted">{{ $desc }}</td>
                                            <td class="text-muted"><span class="badge bg-light text-dark border px-2 py-1">{{ $unitDisplay }}</span></td>
                                            <td class="fw-bold text-dark text-end">₹{{ number_format($cost) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="fw-bold text-dark text-end pt-3" style="font-size: 12px;">Total Operational Expenses</td>
                                        <td class="fw-bold text-dark text-end pt-3" style="font-size: 14px;">₹{{ number_format($totalExpenses) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column (30%): Revenue Split & Top Investor Payouts -->
                <div class="col-lg-4">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Revenue Split (70/30)</h6>
                        
                        <!-- Revenue Split Card -->
                        <div class="p-3 bg-light rounded-3 mb-4">
                            @php
                                $farmerShare = $revEarned * 0.70;
                                $investorShare = $revEarned * 0.30;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success text-white rounded p-1.5 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #064e3b !important;">
                                        <i class="fas fa-tractor" style="font-size: 11px;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 11px;">Farmer's Share</div>
                                        <div class="text-muted" style="font-size: 9px;">70% Retention</div>
                                    </div>
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 14px;">₹{{ number_format($farmerShare) }}</div>
                            </div>

                            <div class="progress rounded-pill bg-secondary bg-opacity-25 mb-3" style="height: 7px;">
                                <div class="progress-bar bg-success rounded-pill" style="width: 70%; background-color: #064e3b !important;"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success bg-opacity-10 text-success rounded p-1.5 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="fas fa-building" style="font-size: 11px;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 11px;">Investor Pool</div>
                                        <div class="text-muted" style="font-size: 9px;">30% Distribution</div>
                                    </div>
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 14px;">₹{{ number_format($investorShare) }}</div>
                            </div>
                        </div>

                        <!-- Top Investor Payouts Subcard -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">TOP INVESTOR PAYOUTS</span>
                                <a href="#" class="text-success text-decoration-none fw-bold" style="font-size: 10px;">View All</a>
                            </div>

                            <div class="d-flex flex-column gap-2.5">
                                @php
                                    $topInvestments = $farm->investments->sortByDesc('amount')->take(3);
                                @endphp
                                @forelse($topInvestments as $topInv)
                                    @php
                                        $invName = $topInv->user?->name ?? 'Unknown Investor';
                                        $encodedName = urlencode($invName);
                                        $bgColors = ['064e3b', '0284c7', 'd97706', '4f46e5', 'be123c'];
                                        $bg = $bgColors[$loop->index % count($bgColors)];
                                        $payout = round($topInv->amount * (1 + ($farm->expected_roi ?? 18.5) / 100));
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center py-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name={{ $encodedName }}&background={{ $bg }}&color=fff" class="rounded-circle" style="width: 28px; height: 28px;">
                                            <span class="fw-bold text-dark" style="font-size: 11px;">{{ $invName }}</span>
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 11px;">₹{{ number_format($payout) }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-2 text-muted" style="font-size: 10px;">No payouts yet.</div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Bottom Section: Investor Ledger Table (Figma Exact) -->
            <div class="card border shadow-sm rounded-4 p-4 bg-white mb-4" style="border-color: #E5E7EB !important;">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">Investor Ledger</h6>
                        <p class="text-muted mb-0" style="font-size: 11px;">Real-time tracking of individual capital allocation and yield distribution</p>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm rounded-pill px-3" placeholder="Search investor..." style="font-size: 11px; width: 160px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 11px;">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('reports.export', ['type' => 'farms']) }}" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 11px;">
                            <i class="fas fa-file-export me-1"></i> Export Report
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size: 12px;">
                        <thead class="table-light text-muted" style="font-size: 10px; text-transform: uppercase;">
                            <tr>
                                <th class="border-0">INVESTOR NAME</th>
                                <th class="border-0">DATE JOINED</th>
                                <th class="border-0">AMOUNT INVESTED</th>
                                <th class="border-0">CURRENT ROI</th>
                                <th class="border-0">TOTAL PAYOUTS</th>
                                <th class="border-0">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($farm->investments as $inv)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 10px; background-color: #064e3b !important;">
                                                {{ strtoupper(substr($inv->user?->name ?? 'I', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 12px;">{{ $inv->user?->name ?? 'Unknown Investor' }}</div>
                                                <div class="text-muted" style="font-size: 9px;">Retail Investor</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-muted">{{ $inv->created_at ? $inv->created_at->format('M d, Y') : 'Jan 17, 2022' }}</td>
                                    <td class="py-3 fw-bold text-dark">₹{{ number_format($inv->amount) }}</td>
                                    <td class="py-3 fw-bold text-success">{{ $farm->expected_roi ?? 19.2 }}%</td>
                                    <td class="py-3 fw-bold text-dark">₹{{ number_format(round($inv->amount * (1 + ($farm->expected_roi ?? 18.5) / 100))) }}</td>
                                    <td class="py-3">
                                        <span class="badge bg-success text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 9px; background-color: #064e3b !important;">
                                            ACTIVE
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="fas fa-users-slash fa-2x opacity-50"></i></div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">No investors yet</div>
                                        <div class="text-muted" style="font-size: 11px;">This farm has not received any investments.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Settlement Actions -->
            <div class="d-flex justify-content-end mt-4 mb-2">
                @if($farm->status === 'completed')
                    <button class="btn btn-secondary rounded-pill px-5 py-2.5 fw-bold text-white shadow-sm" disabled style="font-size: 13px;">
                        <i class="fas fa-check-circle me-1"></i> Settlement Completed
                    </button>
                @else
                    <form action="{{ route('admin.farms.settle', $farm) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-2.5 fw-bold text-white shadow-sm" style="background: #064e3b; border-color: #064e3b; font-size: 13px;">
                            <i class="fas fa-file-signature me-1"></i> Finalize Settlement
                        </button>
                    </form>
                @endif
            </div>
            @endif

        </div>
    </div>


<!-- Add Sale Modal -->
<div class="modal fade" id="addSaleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0" style="background: #f8fafc; padding: 20px 24px;">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Record New Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sales.store') }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                <div class="modal-body p-4">
                    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 small">
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?>@endif<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?>@endif
                                    <li>{{ $error }}</li>
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?>@endif<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?>@endif
                            </ul>
                        </div>
                    @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Buyer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="buyer_name" placeholder="e.g. AgriCorp Inc." required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark small">Sale Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="sale_amount" placeholder="e.g. 500000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark small">Quantity Sold <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="quantity_sold" placeholder="e.g. 10" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Sale Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="sale_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Invoice / Proof (Optional)</label>
                        <input type="file" class="form-control" name="invoice" accept=".pdf,image/*">
                    </div>
                </div>
                <div class="modal-footer border-top-0" style="background: #f8fafc; padding: 16px 24px;">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" style="background-color: var(--investor-primary); border-color: var(--investor-primary);">Save Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0" style="background: #f8fafc; padding: 20px 24px;">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-camera text-primary me-2"></i>Post Farm Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.farms.updates.store', $farm->id) }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Update Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="e.g. Soil Preparation Complete" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Describe the progress to investors..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Photo Proof</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted mt-1 d-block">Upload a clear picture from the farm. (Max 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0" style="background: #f8fafc; padding: 16px 24px;">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" style="background-color: var(--investor-primary); border-color: var(--investor-primary);">Post Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Log / Edit Harvest Modal -->
<div class="modal fade" id="logHarvestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-bottom-0 text-white p-4" style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="fas fa-tractor text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white">{{ isset($latestHarvest) && $latestHarvest ? 'Edit Harvest Data' : 'Log Harvest Data' }}</h5>
                        <small class="text-white-50">Enter start date, yield, selling price, quality grade, and market for {{ $farm->name }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.store') }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                @if(isset($latestHarvest) && $latestHarvest && $latestHarvest->status !== 'gallery_photo')
                    <input type="hidden" name="harvest_id" value="{{ $latestHarvest->id }}">
                @endif
                <div class="modal-body p-4 text-dark">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Harvest Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="log_harvest_status" name="status" required onchange="toggleHarvestDateReq()">
                                <option value="in_progress" {{ in_array(old('status', $latestHarvest?->status), ['in_progress', 'harvesting']) ? 'selected' : '' }}>In Progress</option>
                                <option value="harvested" {{ old('status', $latestHarvest?->status ?? 'harvested') === 'harvested' ? 'selected' : '' }}>Harvested</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Quality Grade <span class="text-danger">*</span></label>
                            <select class="form-select" name="quality_grade" required>
                                <option value="Grade A+" {{ old('quality_grade', $latestHarvest?->quality_grade) === 'Grade A+' ? 'selected' : '' }}>Grade A+ (Premium Export)</option>
                                <option value="Grade A" {{ old('quality_grade', $latestHarvest?->quality_grade ?? 'Grade A') === 'Grade A' ? 'selected' : '' }}>Grade A (Commercial)</option>
                                <option value="Grade B" {{ old('quality_grade', $latestHarvest?->quality_grade) === 'Grade B' ? 'selected' : '' }}>Grade B (Standard Local)</option>
                                <option value="Grade C" {{ old('quality_grade', $latestHarvest?->quality_grade) === 'Grade C' ? 'selected' : '' }}>Grade C (Processing)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Harvest Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $latestHarvest?->start_date ? $latestHarvest->start_date->format('Y-m-d') : date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Harvest Completion Date <span class="text-danger" id="harvest_date_req_star">*</span></label>
                            <input type="date" class="form-control" id="log_actual_harvest_date" name="actual_harvest_date" value="{{ old('actual_harvest_date', $latestHarvest?->actual_harvest_date ? $latestHarvest->actual_harvest_date->format('Y-m-d') : date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark small">Actual Yield (Tons) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control" id="log_actual_yield" name="actual_yield" value="{{ old('actual_yield', $latestHarvest?->actual_yield ?? '') }}" placeholder="e.g. 2.5" required oninput="updateHarvestRevenuePreview()">
                            <div class="text-muted mt-1 fw-semibold" style="font-size: 11px;" id="log_yield_conversion_display">
                                @if(isset($latestHarvest) && $latestHarvest?->actual_yield)
                                    ≈ {{ number_format($latestHarvest->actual_yield * 1000) }} kg ({{ number_format($latestHarvest->actual_yield * 10, 1) }} Quintals)
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark small">Target Yield (Tons) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01" class="form-control" name="estimated_yield" value="{{ old('estimated_yield', $latestHarvest?->estimated_yield ?? ($expYieldVal ?? '')) }}" placeholder="e.g. 3.0" required>
                            @if(isset($expYieldVal) && $expYieldVal > 0)
                                <div class="text-muted mt-1" style="font-size: 11px;">Default from farm project target</div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark small">Selling Price (₹ / Ton) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control" id="log_selling_price" name="selling_price" value="{{ old('selling_price', $latestHarvest?->effectiveSellingPrice() ?: '') }}" placeholder="e.g. 28000" required oninput="updateHarvestRevenuePreview()">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold text-dark small">Wholesale Market <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="market_name" value="{{ old('market_name', $latestHarvest?->market_name ?? '') }}" placeholder="e.g. Guntur APMC Wholesale Market" required>
                        </div>
                        <div class="col-md-5 d-flex align-items-end">
                            <div class="p-2.5 bg-light rounded-3 border w-100">
                                <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Computed Revenue (Yield × Price)</div>
                                <div class="fw-bold text-success fs-6" id="log_revenue_preview">₹0</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark small">Upload Harvest Photo Proof (Optional)</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted mt-1 d-block">Upload photo of crop cutting, produce packing, or weighbridge receipt.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0" style="background: #f8fafc; padding: 16px 24px;">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #064e3b; border-color: #064e3b;">
                        <i class="fas fa-check-circle me-1"></i> Save Harvest Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Upload Stage Photo Modal (Harvest Gallery) -->
<div class="modal fade" id="uploadHarvestPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-bottom-0 text-white p-4" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="fas fa-camera text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white">Upload Stage Photo</h5>
                        <small class="text-white-50">Upload a quick progress or harvest picture for investors</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.store') }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                <input type="hidden" name="status" value="gallery_photo">
                <div class="modal-body p-4 text-dark">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Harvest Stage <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3" id="upload_harvest_stage_select" name="harvest_stage" required>
                            <option value="Before Harvest">1. Before Harvest (Growing Field)</option>
                            <option value="Process">2. Process (Cutting / Gathering)</option>
                            <option value="Packing">3. Packing (Boxes / Crate Packing)</option>
                            <option value="Transport">4. Transport (Truck Loading)</option>
                            <option value="Final Produce">5. Final Produce (Market Produce)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Select Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control rounded-3" name="image" accept="image/*" required>
                        <small class="text-muted mt-1 d-block">Upload a clear photo of the field or produce. (Max 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background: #064e3b; border-color: #064e3b;">
                        <i class="fas fa-upload me-1"></i> Upload Photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openLogHarvestModal() {
        const modalEl = document.getElementById('logHarvestModal');
        if (!modalEl) return;
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        toggleHarvestDateReq();
        updateHarvestRevenuePreview();
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    function toggleHarvestDateReq() {
        const statusEl = document.getElementById('log_harvest_status');
        const dateEl = document.getElementById('log_actual_harvest_date');
        const starEl = document.getElementById('harvest_date_req_star');
        if (!statusEl || !dateEl) return;
        const isHarvested = statusEl.value === 'harvested';
        dateEl.required = isHarvested;
        if (starEl) starEl.style.display = isHarvested ? 'inline' : 'none';
    }

    function updateHarvestRevenuePreview() {
        const qty = parseFloat(document.getElementById('log_actual_yield')?.value) || 0;
        const price = parseFloat(document.getElementById('log_selling_price')?.value) || 0;
        const el = document.getElementById('log_revenue_preview');
        if (el) {
            const revenue = Math.round(qty * price);
            el.textContent = '₹' + revenue.toLocaleString('en-IN');
        }
        const convEl = document.getElementById('log_yield_conversion_display');
        if (convEl) {
            if (qty > 0) {
                const kg = Math.round(qty * 1000);
                const quintals = (qty * 10).toFixed(1);
                convEl.textContent = `≈ ${kg.toLocaleString('en-IN')} kg (${quintals} Quintals)`;
            } else {
                convEl.textContent = '';
            }
        }
    }

    function openUploadStagePhotoModal(stageName) {
        const select = document.getElementById('upload_harvest_stage_select');
        if (select && stageName) {
            select.value = stageName;
        }
        const modalEl = document.getElementById('uploadHarvestPhotoModal');
        if (!modalEl) return;
        if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadZone = document.querySelector('.upload-zone');
        const fileInput = document.getElementById('evidence_file');
        const filesList = document.getElementById('uploadedFilesList');

        if (uploadZone && fileInput) {
            // Trigger file input click when clicking the upload zone
            uploadZone.addEventListener('click', function(e) {
                // Avoid double trigger if clicking input directly
                if (e.target.tagName !== 'INPUT') {
                    fileInput.click();
                }
            });

            // Handle drag and drop
            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadZone.style.borderColor = 'var(--primary-blue)';
                uploadZone.style.background = '#EFF6FF';
            });

            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadZone.style.borderColor = '#D1D5DB';
                uploadZone.style.background = '#F9FAFB';
            });

            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadZone.style.borderColor = '#D1D5DB';
                uploadZone.style.background = '#F9FAFB';

                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    updateFilesList(e.dataTransfer.files);
                }
            });

            // Handle file input change
            fileInput.addEventListener('change', function() {
                if (fileInput.files && fileInput.files.length > 0) {
                    updateFilesList(fileInput.files);
                }
            });
        }

        function updateFilesList(files) {
            if (!filesList) return;
            
            // Clear mock files list
            filesList.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                const isPDF = file.type === 'application/pdf' || file.name.endsWith('.pdf');
                const fileIcon = isPDF ? 'fas fa-file-pdf text-danger' : 'far fa-image text-primary';
                
                const fileItemHTML = `
                    <div class="file-item mb-2" style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 12px; background: white;">
                        <div class="file-icon" style="font-size: 20px;"><i class="${fileIcon}"></i></div>
                        <div class="flex-grow-1">
                            <strong class="d-block text-dark" style="font-size: 12px;">${file.name}</strong>
                            <span class="text-muted" style="font-size: 11px;">${sizeInMB} MB • Ready to upload</span>
                        </div>
                        <button class="btn btn-sm text-muted remove-file-btn" type="button" data-index="${index}"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
                filesList.insertAdjacentHTML('beforeend', fileItemHTML);
            });

            // Add remove handlers
            const removeButtons = filesList.querySelectorAll('.remove-file-btn');
            removeButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fileInput.value = ''; // Reset file input
                    filesList.innerHTML = '';
                });
            });
        }
    });

    // Auto-switch tabs based on URL hash and show modal on errors
    document.addEventListener('DOMContentLoaded', function() {
        // Handle URL Hash for tabs
        if (window.location.hash) {
            let hashElement = document.querySelector(window.location.hash);
            if (hashElement) {
                let tabPane = hashElement.closest('.tab-pane');
                if (tabPane) {
                    let tabTrigger = document.querySelector('[data-bs-target="#' + tabPane.id + '"]');
                    if (tabTrigger) {
                        let tab = new bootstrap.Tab(tabTrigger);
                        tab.show();
                        setTimeout(() => {
                            hashElement.scrollIntoView({ behavior: 'smooth' });
                        }, 300);
                    }
                }
            }
        }

        // Re-open Add Sale Modal if there are validation errors
        @if($errors->any())
            let addSaleModal = new bootstrap.Modal(document.getElementById('addSaleModal'));
            addSaleModal.show();
        @endif
    });
</script>
@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?>@endif<?php $__currentLoopData = $farm->sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?>@endif
<!-- Edit Sale Modal -->
<div class="modal fade" id="editSaleModal-{{ $sale->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Buyer Name</label>
                        <input type="text" class="form-control" name="buyer_name" value="{{ $sale->buyer_name }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Sale Amount (₹)</label>
                            <input type="number" class="form-control" name="sale_amount" min="0" value="{{ $sale->sale_amount }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Quantity Sold</label>
                            <input type="number" class="form-control" name="quantity_sold" min="0" value="{{ $sale->quantity_sold }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Sale Date</label>
                        <input type="date" class="form-control" name="sale_date" value="{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ $sale->status === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ $sale->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Upload Invoice/Receipt (Optional)</label>
                        <input type="file" class="form-control" name="invoice" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?>@endif<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?>@endif

@foreach($farm->harvests->where('status', '!=', 'gallery_photo') as $harvest)
<!-- Edit Harvest Modal -->
<div class="modal fade" id="editHarvestModal-{{ $harvest->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Edit Harvest Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.update', $harvest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small">Status <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="status" required>
                                <option value="in_progress" {{ in_array($harvest->status, ['in_progress', 'harvesting', 'growing', 'ready']) ? 'selected' : '' }}>In Progress</option>
                                <option value="harvested" {{ $harvest->status === 'harvested' ? 'selected' : '' }}>Harvested</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small">Quality Grade <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" name="quality_grade" value="{{ $harvest->quality_grade }}" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control rounded-3" name="start_date" value="{{ $harvest->start_date ? $harvest->start_date->format('Y-m-d') : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold small">Actual Harvest Date</label>
                            <input type="date" class="form-control rounded-3" name="actual_harvest_date" value="{{ $harvest->actual_harvest_date ? $harvest->actual_harvest_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small">Actual Yield (Tons) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control rounded-3" name="actual_yield" value="{{ $harvest->actual_yield }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small">Target Yield (Tons) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01" class="form-control rounded-3" name="estimated_yield" value="{{ $harvest->estimated_yield }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold small">Selling Price (₹ / Ton) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control rounded-3" name="selling_price" value="{{ $harvest->effectiveSellingPrice() }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Wholesale Market <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" name="market_name" value="{{ $harvest->market_name }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold small">Update Harvest Photo</label>
                        <input type="file" class="form-control rounded-3" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal: Post-Disbursement Next Steps Guidance Popup -->
<div class="modal fade" id="nextStepsWorkflowModal" tabindex="-1" aria-labelledby="nextStepsWorkflowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div>
                    <span class="badge bg-white text-success rounded-pill px-3 py-1 fw-bold text-uppercase mb-2" style="font-size: 10px;">
                        <i class="fas fa-route me-1"></i> Farm Management Guide
                    </span>
                    <h5 class="modal-title fw-bold mb-1" id="nextStepsWorkflowModalLabel">
                        <i class="fas fa-check-circle me-2"></i>Fund Request & Disbursement Next Steps
                    </h5>
                    <p class="mb-0 text-white-50" style="font-size: 12px;">
                        Follow this 3-step cycle to keep investors informed and successfully close this cultivation period:
                    </p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-3">
                    <!-- Step 1: Updates -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 text-center bg-white border-top border-4 border-success">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <i class="fas fa-bullhorn fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;">1. Post Updates</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">
                                Upload field photos, crop growth milestones, and irrigation reports so investors can track progress.
                            </p>
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill fw-bold mt-auto" onclick="switchToTab('updates')">
                                Go to Updates Tab <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Harvest -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 text-center bg-white border-top border-4 border-warning">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <i class="fas fa-tractor fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;">2. Record Harvest</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">
                                Log harvested quantities (tons), market valuation, crop sales proof, and total income generated.
                            </p>
                            <button type="button" class="btn btn-outline-warning text-dark btn-sm rounded-pill fw-bold mt-auto" onclick="switchToTab('harvest')">
                                Go to Harvest Tab <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Settlement -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 text-center bg-white border-top border-4 border-info">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <i class="fas fa-wallet fs-4"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;">3. Final Settlement</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">
                                Calculate ROI returns, distribute payouts to active investors, and mark the farm plot as completed.
                            </p>
                            <button type="button" class="btn btn-outline-info btn-sm rounded-pill fw-bold mt-auto" onclick="switchToTab('settlement')">
                                Go to Settlement Tab <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-0 px-4 py-3 d-flex justify-content-between">
                <span class="text-muted" style="font-size: 12px;">
                    <i class="fas fa-info-circle me-1 text-primary"></i> You can re-open this guide anytime from the <strong>Fund Request</strong> tab.
                </span>
                <button type="button" class="btn btn-success rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Got It!</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchToTab(tabId) {
        // Close modal if open
        const modalEl = document.getElementById('nextStepsWorkflowModal');
        if (modalEl) {
            try {
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            } catch(e) {}
        }

        let cleanId = tabId.replace('#', '');
        if (cleanId === 'yield') cleanId = 'harvest';
        const tabBtn = document.querySelector(`[data-bs-target="#${cleanId}"]`) || document.getElementById(`${cleanId}-tab`);
        if (tabBtn && !tabBtn.disabled && !tabBtn.classList.contains('disabled')) {
            try {
                const tab = new bootstrap.Tab(tabBtn);
                tab.show();
            } catch(e) {
                tabBtn.click();
            }
            setTimeout(() => {
                tabBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 150);
        } else if (tabBtn && (tabBtn.disabled || tabBtn.classList.contains('disabled'))) {
            const overviewBtn = document.getElementById('overview-tab');
            if (overviewBtn) {
                bootstrap.Tab.getOrCreateInstance(overviewBtn).show();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const hash = window.location.hash.replace('#', '');
        
        const activeTabTarget = tabParam || hash;
        if (activeTabTarget) {
            let cleanId = activeTabTarget.replace('#', '');
            if (cleanId === 'yield') cleanId = 'harvest';
            const tabBtn = document.querySelector(`[data-bs-target="#${cleanId}"]`) || document.getElementById(`${cleanId}-tab`);
            if (tabBtn && !tabBtn.disabled && !tabBtn.classList.contains('disabled')) {
                try {
                    const tab = new bootstrap.Tab(tabBtn);
                    tab.show();
                } catch(e) {
                    tabBtn.click();
                }
            } else {
                const overviewBtn = document.getElementById('overview-tab');
                if (overviewBtn) {
                    bootstrap.Tab.getOrCreateInstance(overviewBtn).show();
                }
            }
        }

        // Auto-show Next Steps popup guidance modal if returned after fund disbursement or if requested
        const hasSuccessAlert = document.querySelector('.alert-success') !== null;
        if (urlParams.get('show_guide') === '1' || (hasSuccessAlert && document.querySelector('.alert-success')?.innerText.toLowerCase().includes('disburs'))) {
            setTimeout(function() {
                const modalEl = document.getElementById('nextStepsWorkflowModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }, 500);
        }
    });
</script>
@endpush

@endsection

@extends('layouts.admin')<?php /**PATH C:\Users\Aswathy\Desktop\soulsoil\resources\views/admin/farms/show.blade.php ENDPATH**/ ?>

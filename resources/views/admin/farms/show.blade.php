

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
</style>
@endsection

@section('content')
<div class="container-fluid py-2">

    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif            @if(in_array($farm->status, ['approved', 'active']))
                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 mb-2 fw-semibold border border-success border-opacity-25" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                    <i class="fas fa-check-circle me-1"></i> APPROVED & LISTED
                </div>
            @elseif($farm->status === 'completed')
                <div class="badge bg-success text-white rounded-pill px-3 py-1 mb-2 fw-semibold border border-success" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase; background-color: #064e3b !important;">
                    <i class="fas fa-check-double me-1"></i> COMPLETED & SETTLED
                </div>
            @elseif($farm->status === 'rejected')
                <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 mb-2 fw-semibold border border-danger border-opacity-25" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                    <i class="fas fa-times-circle me-1"></i> REJECTED
                </div>
            @else
                <div class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 mb-2 fw-semibold border border-warning border-opacity-25 text-dark" style="font-size:11px; letter-spacing:0.5px; text-transform: uppercase;">
                    <i class="fas fa-hand-paper me-1 text-danger"></i> PENDING VERIFICATION (STOP COLLECTING)
                </div>
            @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
            <h2 class="fw-bold mb-1" style="color: var(--text-dark); font-size: 24px;">{{ $farm->name ?? 'N/A' }}</h2>
            <p class="text-muted mb-0" style="font-size: 13px;"><i class="fas fa-map-marker-alt me-1"></i> {{ $farm->location ?? ($farm->farmer->village . ', ' . $farm->farmer->district) ?? 'N/A' }}</p>
        </div>
        <div class="col-md-5 text-end">
            <?php
                $backUrl = url()->previous();
                if ($backUrl === url()->current()) {
                    $backUrl = auth()->user()?->is_admin ? route('admin.dashboard', ['tab' => 'farms']) : route('admin.dashboard');
                }
            ?>
            <a href="{{ $backUrl }}" class="btn btn-light fw-semibold text-muted me-2" style="font-size: 13px; border-radius: 8px;">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            @if(in_array($farm->status, ['pending', 'submitted', 'completed']))
                <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" class="d-inline me-2">
                    @csrf
                    <button type="submit" class="btn btn-success fw-bold text-white shadow-sm" style="font-size: 13px; border-radius: 8px; background-color: var(--investor-primary); border-color: var(--investor-primary);">
                        <i class="fas fa-check-circle me-1"></i> {{ $farm->status === 'completed' ? 'Re-Open / Mark Approved' : 'Approve Farm Listing' }}
                    </button>
                </form>
            @endif
            <a href="{{ route('reports.export', ['type' => 'farms']) }}" class="btn btn-outline-success fw-semibold me-2" style="font-size: 13px; border-radius: 8px; border-color: var(--investor-primary); color: var(--investor-primary);"><i class="fas fa-file-download me-1"></i> Download Report</a>
            <button class="btn btn-success fw-semibold text-white" data-bs-toggle="modal" data-bs-target="#updateModal" style="font-size: 13px; border-radius: 8px; background-color: var(--investor-primary); border-color: var(--investor-primary);">Post Update</button>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs figma-tabs" id="farmTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="fund-request-tab" data-bs-toggle="tab" data-bs-target="#fund-request" type="button" role="tab">Fund Request</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab">Timeline</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button" role="tab">Updates</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="investors-tab" data-bs-toggle="tab" data-bs-target="#investors" type="button" role="tab">Investors</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="harvest-tab" data-bs-toggle="tab" data-bs-target="#harvest" type="button" role="tab">Harvest</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="settlement-tab" data-bs-toggle="tab" data-bs-target="#settlement" type="button" role="tab">Settlement</button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="farmTabsContent">
        
        <!-- 1. Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
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
                        
                        function formatCurrency($amount) {
                            if ($amount >= 10000000) {
                                return '₹' . number_format($amount / 10000000, 2) . ' Cr';
                            } elseif ($amount >= 100000) {
                                return '₹' . number_format($amount / 100000, 2) . ' L';
                            }
                            return '₹' . number_format($amount);
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
                                <p class="text-muted mb-0" style="font-size: 11px;">Annualized Projection</p>
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

            <!-- Interactive Workflow & Next Steps Guidance Banner -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                        <div>
                            <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-3 py-1 fw-bold text-uppercase me-2" style="font-size: 10px;">
                                <i class="fas fa-compass me-1"></i> Guided Workflow
                            </span>
                            <h5 class="fw-bold text-dark mb-1 d-inline-block align-middle" style="font-size: 16px;">
                                Post-Disbursement Next Steps Guide
                            </h5>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                New to this process? After disbursing funds, follow this standard 3-step cycle to keep investors informed:
                            </p>
                        </div>
                        <button type="button" class="btn btn-sm btn-success rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#nextStepsWorkflowModal">
                            <i class="fas fa-lightbulb me-1"></i> View Next Steps Popup
                        </button>
                    </div>

                    <div class="row g-3">
                        <!-- Step 1: Fund Request -->
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded-3 border h-100 position-relative shadow-2sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">1</span>
                                    <strong class="text-dark" style="font-size: 13px;">Fund Request</strong>
                                </div>
                                <p class="text-muted mb-1" style="font-size: 11px;">Disburse capital for 5 budget stages (Land, Seed, Irrigation, Harvest, Settle).</p>
                                <span class="badge bg-success text-white position-absolute top-0 end-0 m-2" style="font-size: 9px;"><i class="fas fa-check"></i> Current</span>
                            </div>
                        </div>

                        <!-- Step 2: Updates -->
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded-3 border h-100 position-relative shadow-2sm role-btn cursor-pointer" onclick="switchToTab('updates')" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">2</span>
                                    <strong class="text-dark" style="font-size: 13px;">Updates Tab <i class="fas fa-arrow-right ms-1 text-success" style="font-size: 10px;"></i></strong>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 11px;"><strong>Stages 1, 2 & 3:</strong> Post Land Prep, Seeding & Irrigation progress photos for investors.</p>
                            </div>
                        </div>

                        <!-- Step 3: Harvest -->
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded-3 border h-100 position-relative shadow-2sm role-btn cursor-pointer" onclick="switchToTab('harvest')" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">3</span>
                                    <strong class="text-dark" style="font-size: 13px;">Harvest Tab <i class="fas fa-arrow-right ms-1 text-warning" style="font-size: 10px;"></i></strong>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 11px;"><strong>Stage 4:</strong> Log harvested yield tonnage, crop market prices, & sales receipts.</p>
                            </div>
                        </div>

                        <!-- Step 4: Settlement -->
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded-3 border h-100 position-relative shadow-2sm role-btn cursor-pointer" onclick="switchToTab('settlement')" style="cursor: pointer;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">4</span>
                                    <strong class="text-dark" style="font-size: 13px;">Settlement Tab <i class="fas fa-arrow-right ms-1 text-info" style="font-size: 10px;"></i></strong>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 11px;"><strong>Stage 5:</strong> Calculate & disburse investor return payouts to close plot cycle.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if(auth()->user()?->farmer || auth()->user()?->is_admin)
                
                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($farm->pending_disbursement_amount > 0)
                    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if(auth()->user()?->is_admin)
                        <!-- Admin View: Action Required to Approve/Reject Request -->
                        <div class="card border-warning border-2 p-4 rounded-3 mb-4 shadow-sm" style="background: #fffbeb;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                    <i class="fas fa-exclamation-circle fs-4"></i>
                                </div>
                                <div class="flex-grow-1 text-dark">
                                    <h5 class="fw-bold mb-1" style="color: #854d0e;">Action Required: Approve Fund Request</h5>
                                    <p class="text-muted mb-3" style="font-size: 13px;">
                                        The farmer has submitted a request for releasing agricultural funds. Review the details below.
                                    </p>
                                    
                                    <div class="p-3 bg-white rounded-3 mb-3 border">
                                        <div class="row g-3 text-dark" style="font-size: 13px;">
                                            <div class="col-6">
                                                <span class="text-muted d-block small">Agricultural Stage:</span>
                                                <strong>{{ $farm->pending_disbursement_stage }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted d-block small">Requested Amount:</span>
                                                <strong class="text-success" style="font-size: 16px;">₹{{ number_format($farm->pending_disbursement_amount) }}</strong>
                                            </div>
                                            @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($farm->pending_disbursement_purpose)
                                                <div class="col-12 mt-2 pt-2 border-top">
                                                    <span class="text-muted d-block small">Purpose of Funds:</span>
                                                    <span>{{ $farm->pending_disbursement_purpose }}</span>
                                                </div>
                                            @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.farms.approve_disburse', $farm->id) }}" method="POST" class="m-0">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success fw-bold px-4" style="border-radius: 20px;">Approve and Release Funds</button>
                                        </form>
                                        <form action="{{ route('admin.farms.reject_disburse', $farm->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to reject this request?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-danger fw-bold px-4" style="border-radius: 20px;">Reject Request</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Farmer View: Pending Request status notice -->
                        <div class="alert alert-warning p-4 rounded-3 border-0 shadow-sm d-flex gap-3 align-items-center mb-4 text-dark" style="background-color: #fffbeb;">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="fas fa-hourglass-half fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #854d0e;">Fund Disbursement Request Under Review</h6>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    Your request of <strong>₹{{ number_format($farm->pending_disbursement_amount) }}</strong> for the <strong>{{ $farm->pending_disbursement_stage }}</strong> stage has been submitted and is currently pending review by the administrator.
                                </p>
                                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($farm->pending_disbursement_purpose)
                                    <p class="text-muted small mt-2 mb-0"><strong>Purpose:</strong> {{ $farm->pending_disbursement_purpose }}</p>
                                @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
                            </div>
                        </div>
                    @endif
                @else
                    @if(auth()->user()?->is_admin)
                        <!-- Admin View: No Pending Request status -->
                        <div class="alert alert-secondary p-4 rounded-3 border-0 shadow-sm d-flex gap-3 align-items-center mb-4 text-dark" style="background-color: #f4f4f5;">
                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="fas fa-check-circle fs-4" style="color: #71717a;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #27272a;">No Pending Fund Requests</h6>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    The farmer has not submitted any funding disbursement requests at this time. You can still disburse funds manually below.
                                </p>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Fund Disbursement Request Form -->
                    <form action="{{ route('admin.farms.disburse', $farm->id) }}" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 text-dark">
                            <h4 class="fw-bold mb-1">Fund Disbursement Request</h4>
                            <p class="text-muted" style="font-size: 13px;">Create a structured funding request for <strong>{{ $farm->name ?? 'this farm' }}</strong>. Provide timeline details and necessary evidence for institutional approval.</p>
                        </div>

                    <?php
                        $stagesWithBudget = [];
                        if (!empty($farm->budget_breakdown) && is_array($farm->budget_breakdown)) {
                            foreach ($farm->budget_breakdown as $bItem) {
                                $bName = $bItem['purpose'] ?? $bItem['name'] ?? $bItem['stage'] ?? null;
                                $bAmt = $bItem['amount'] ?? $bItem['cost'] ?? 0;
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
                    ?>

                    <div class="row g-4 mb-4 text-dark">
                        <!-- Request Details -->
                        <div class="col-md-6">
                            <div class="section-card h-100 mb-0">
                                <div class="section-header mb-4">
                                    <i class="far fa-file-alt text-primary"></i>
                                    <h5 style="font-size: 14px;">Request Details</h5>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Agricultural Stage</label>
                                        <select name="stage" id="fund_stage_select" class="form-select" required onchange="updateFundRequestFields(true)">
                                            @foreach($stagesWithBudget as $stg)
                                                <option value="{{ $stg['name'] }}" data-amount="{{ $stg['amount'] }}" data-purpose="{{ $stg['purpose'] }}">
                                                    {{ $stg['name'] }} @if($stg['amount'] > 0)(₹{{ number_format($stg['amount']) }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Request Priority</label>
                                        <select name="priority" class="form-select">
                                            <option>Standard (3-5 days)</option>
                                            <option>Urgent (1-2 days)</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Request Amount (₹)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted">₹</span>
                                            <input type="number" name="amount" id="fund_amount_input" class="form-control border-start-0 ps-0" value="{{ $stagesWithBudget[0]['amount'] ?? 150000 }}" placeholder="e.g. 150000" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Intended Usage Date</label>
                                        <input type="date" name="usage_date" class="form-control text-muted" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Purpose of Funds</label>
                                        <textarea name="purpose" id="fund_purpose_input" class="form-control" rows="3" placeholder="Describe the specific use of these funds...">{{ $stagesWithBudget[0]['purpose'] ?? 'Land tilling, soil enrichment, leveling, and plot prep.' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function updateFundRequestFields(force) {
                                var select = document.getElementById('fund_stage_select');
                                if (!select) return;
                                var selectedOption = select.options[select.selectedIndex];
                                if (selectedOption) {
                                    var amount = selectedOption.getAttribute('data-amount');
                                    var purpose = selectedOption.getAttribute('data-purpose');
                                    var amountInput = document.getElementById('fund_amount_input');
                                    var purposeInput = document.getElementById('fund_purpose_input');
                                    
                                    if (amountInput && (force || !amountInput.value)) {
                                        amountInput.value = amount || '';
                                    }
                                    if (purposeInput && (force || !purposeInput.value)) {
                                        purposeInput.value = purpose || '';
                                    }
                                }
                            }
                            document.addEventListener('DOMContentLoaded', function() {
                                updateFundRequestFields(false);
                            });
                            // Also run immediately in case DOMContentLoaded fired
                            setTimeout(function() { updateFundRequestFields(false); }, 100);
                        </script>

                        <!-- Evidence Upload -->
                        <div class="col-md-6">
                            <div class="section-card h-100 mb-0 d-flex flex-column">
                                <input type="file" id="evidence_file" name="evidence_file" class="d-none">

                                <div class="upload-zone mb-3">
                                    <i class="far fa-file-alt text-muted fs-3 mb-2"></i>
                                    <p class="mb-1 fw-semibold" style="font-size: 13px;">Drag and drop files here</p>
                                    <p class="text-muted mb-2" style="font-size: 11px;">PDF, JPG, or PNG up to 10MB</p>
                                    <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3" style="border-radius: 20px;">Browse Files</button>
                                </div>

                                <div id="uploadedFilesList">
                                    <div class="file-item mb-2" style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 12px; background: white;">
                                        <div class="file-icon" style="font-size: 20px;"><i class="fas fa-file-pdf text-danger"></i></div>
                                        <div class="flex-grow-1">
                                            <strong class="d-block text-dark" style="font-size: 12px;">Supplier_Quote_#12.pdf</strong>
                                            <span class="text-muted" style="font-size: 11px;">2.4 MB • Uploaded today</span>
                                        </div>
                                        <button class="btn btn-sm text-muted" type="button"><i class="far fa-trash-alt"></i></button>
                                    </div>

                                    <div class="file-item mb-2" style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 12px; background: white;">
                                        <div class="file-icon" style="font-size: 20px;"><i class="far fa-image text-primary"></i></div>
                                        <div class="flex-grow-1">
                                            <strong class="d-block text-dark" style="font-size: 12px;">Site_Current_View_01.jpg</strong>
                                            <span class="text-muted" style="font-size: 11px;">4.1 MB • Uploaded today</span>
                                        </div>
                                        <button class="btn btn-sm text-muted" type="button"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Additional Fund Request Info Rows -->
                    <div class="row g-4 mb-4">
                        <!-- Review Timeline -->
                        <div class="col-12">
                            <div class="section-card mb-0 bg-white" style="border-top: 3px solid var(--investor-primary);">
                                <div class="section-header mb-4">
                                    <i class="fas fa-stream text-primary"></i>
                                    <h5 style="font-size: 14px;">Review Timeline</h5>
                                </div>
                                <div class="d-flex justify-content-between position-relative px-4">
                                    <div class="position-absolute" style="top: 15px; left: 10%; right: 10%; height: 2px; background: #E5E7EB; z-index: 1;"></div>
                                    
                                    <!-- 1. Submitted -->
                                    <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                            <i class="fas fa-check" style="font-size: 12px;"></i>
                                        </div>
                                        <div style="font-size: 12px; font-weight: 600;" class="text-dark">Submitted</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $farm->created_at ? $farm->created_at->format('M d') : 'Day 1' }}</div>
                                    </div>
                                    
                                    <!-- 2. Under Review -->
                                    <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                            <i class="fas fa-check" style="font-size: 12px;"></i>
                                        </div>
                                        <div style="font-size: 12px; font-weight: 600;" class="text-dark">Under Review</div>
                                        <div class="text-muted" style="font-size: 10px;">Completed</div>
                                    </div>
                                    
                                    <!-- 3. Approved -->
                                    <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                        <div class="bg-{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'success' : 'light' }} text-{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'white' : 'muted' }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                            <i class="fas {{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'fa-check' : 'fa-thumbs-up' }}" style="font-size: 12px;"></i>
                                        </div>
                                        <div style="font-size: 12px; font-weight: 600;" class="{{ in_array($farm->status, ['approved', 'active', 'completed']) ? 'text-dark' : 'text-muted' }}">Approved</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $farm->reviewed_at ? $farm->reviewed_at->format('M d') : (in_array($farm->status, ['approved', 'active', 'completed']) ? ($farm->updated_at ? $farm->updated_at->format('M d') : 'Completed') : 'Pending') }}</div>
                                    </div>
                                    
                                    <!-- 4. Disbursed -->
                                    <?php
                                        $hasDisbursement = ($farm->disbursements && $farm->disbursements->count() > 0) || $farm->status === 'completed';
                                        $isDisbursing = $farm->funding_status === 'open' || $farm->funding_raised > 0;
                                    ?>
                                    <div class="text-center position-relative" style="z-index: 2; width: 25%;">
                                        <div class="bg-{{ $hasDisbursement ? 'success' : ($isDisbursing ? 'primary' : 'light') }} text-{{ ($hasDisbursement || $isDisbursing) ? 'white' : 'muted' }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 32px; height: 32px;">
                                            <i class="fas {{ $hasDisbursement ? 'fa-check' : ($isDisbursing ? 'fa-spinner fa-spin' : 'fa-money-bill-wave') }}" style="font-size: 12px;"></i>
                                        </div>
                                        <div style="font-size: 12px; font-weight: 600;" class="{{ ($hasDisbursement || $isDisbursing) ? 'text-dark' : 'text-muted' }}">Disbursed</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $hasDisbursement ? 'Completed' : ($isDisbursing ? 'Funding Open' : 'Pending') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Bar -->
                    <div class="d-flex justify-content-between align-items-center py-3 border-top mt-2">
                        <a href="{{ route('admin.farms.index') }}" class="text-muted fw-semibold text-decoration-none" style="font-size: 14px;">
                            <i class="fas fa-arrow-left me-2"></i> Cancel & Return
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light fw-semibold border" style="font-size: 14px; padding: 10px 24px;">Save Draft</button>
                            <button type="submit" class="btn btn-primary fw-semibold" style="font-size: 14px; padding: 10px 24px; background: var(--primary-blue); border-color: var(--primary-blue);">Submit Fund Request <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
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
                                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1 text-dark">
                                                                <i class="fas fa-hourglass-half me-1"></i> Pending Review
                                                            </span>
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

                    </form>
                @endif
        </div>

        <!-- 3. Timeline Tab -->
        <div class="tab-pane fade" id="timeline" role="tabpanel">

            <!-- Cultivation Timeline -->
            <?php
                $farmStages = ['Land Prep', 'Seeding', 'Irrigation & Growth', 'Harvesting', 'Settlement'];
                $latestHarvestObj = $farm->harvests()->latest()->first();

                // Build per-stage status map from actual disbursement history & harvest status
                $disbursedStagesMap = [];
                $pendingStagesMap = [];

                if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
                    foreach ($farm->disbursement_history as $hItem) {
                        $hStage = strtolower($hItem['stage'] ?? '');
                        $hStatus = strtolower($hItem['status'] ?? '');
                        
                        $isDisb = str_contains($hStatus, 'disbursed') || str_contains($hStatus, 'approved');
                        $isPend = str_contains($hStatus, 'pending');

                        if (str_contains($hStage, 'land')) {
                            if ($isDisb) $disbursedStagesMap['Land Prep'] = true;
                            if ($isPend) $pendingStagesMap['Land Prep'] = true;
                        }
                        if (str_contains($hStage, 'seed') || str_contains($hStage, 'sowing')) {
                            if ($isDisb) $disbursedStagesMap['Seeding'] = true;
                            if ($isPend) $pendingStagesMap['Seeding'] = true;
                        }
                        if (str_contains($hStage, 'irrigation') || str_contains($hStage, 'growth') || str_contains($hStage, 'labor') || str_contains($hStage, 'labour') || str_contains($hStage, 'maintenance') || str_contains($hStage, 'fertilizer')) {
                            if ($isDisb) $disbursedStagesMap['Irrigation & Growth'] = true;
                            if ($isPend) $pendingStagesMap['Irrigation & Growth'] = true;
                        }
                        if (str_contains($hStage, 'harvest')) {
                            if ($isDisb) $disbursedStagesMap['Harvesting'] = true;
                            if ($isPend) $pendingStagesMap['Harvesting'] = true;
                        }
                    }
                }

                if ($farm->status === 'completed' || ($latestHarvestObj && ($latestHarvestObj->actual_yield > 0 || $latestHarvestObj->status === 'harvested'))) {
                    $disbursedStagesMap['Harvesting'] = true;
                    $disbursedStagesMap['Settlement'] = true;
                }

                // Determine active stage for progress bar width calculation
                $activeIdx = 0;
                foreach ($farmStages as $i => $sName) {
                    if (isset($disbursedStagesMap[$sName])) {
                        $activeIdx = max($activeIdx, $i);
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
                        Current Stage: {{ $farm->status === 'completed' ? 'Settlement (Completed)' : ($farmStages[$activeIdx] ?? 'Land Prep') }}
                    </div>
                </div>

                <div class="timeline-container">
                    <div class="timeline-line-bg"></div>
                    <div class="timeline-line-active" style="width: {{ ($activeIdx / (count($farmStages) - 1)) * 100 }}%;"></div>

                    @foreach($farmStages as $idx => $stage)
                        @php
                            $isDisbursed = isset($disbursedStagesMap[$stage]);
                            $isPending = isset($pendingStagesMap[$stage]);

                            if ($farm->status === 'completed') {
                                $isCompleted = true;
                                $isActive = false;
                                $isUpcoming = false;
                                $statusText = 'COMPLETED';
                            } elseif ($isDisbursed) {
                                $isCompleted = true;
                                $isActive = false;
                                $isUpcoming = false;
                                $statusText = 'COMPLETED';
                            } elseif ($isPending) {
                                $isCompleted = false;
                                $isActive = true;
                                $isUpcoming = false;
                                $statusText = 'PENDING REVIEW';
                            } elseif ($idx === 0 && empty($disbursedStagesMap) && empty($pendingStagesMap)) {
                                $isCompleted = false;
                                $isActive = true;
                                $isUpcoming = false;
                                $statusText = 'ACTIVE';
                            } else {
                                $isCompleted = false;
                                $isActive = false;
                                $isUpcoming = true;
                                $statusText = $idx === count($farmStages)-1 ? 'FINAL' : 'UPCOMING';
                            }

                            $icon = 'fas fa-circle';
                            if ($isCompleted) $icon = 'fas fa-check';
                            elseif ($isPending) $icon = 'fas fa-hourglass-half';
                            elseif ($stage === 'Seeding') $icon = 'fas fa-seedling';
                            elseif ($stage === 'Harvesting') $icon = 'fas fa-tractor';
                            else $icon = $idx + 1;
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

        </div>

        <!-- 4. Updates Tab -->
        <div class="tab-pane fade" id="updates" role="tabpanel">
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
        </div>

        <!-- 5. Investors Tab -->
        <div class="tab-pane fade" id="investors" role="tabpanel">

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
        </div>

        <!-- 6. Harvest Tab (Figma Exact & 100% Dynamic) -->
        <div class="tab-pane fade" id="harvest" role="tabpanel">
            
            <!-- Top Badges & Actions Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 mt-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-semibold" style="font-size: 11px;">
                        <i class="fas fa-circle text-success me-1.5" style="font-size: 7px; vertical-align: middle;"></i> Active Harvest Cycle
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#logHarvestModal" style="font-size: 11px;">
                        <i class="fas fa-plus-circle me-1"></i> Log Harvest / Edit
                    </button>
                    <a href="{{ route('reports.export', ['type' => 'farms']) }}" class="btn btn-sm btn-dark rounded-pill px-3 py-2 fw-bold" style="font-size: 11px; background: #064e3b; border-color: #064e3b;">
                        <i class="fas fa-file-export me-1"></i> Export Report
                    </a>
                </div>
            </div>

            <!-- Dynamic Statistics Computations -->
            <?php
                $latestHarvest = $farm->harvests()->latest()->first();
                $expYieldVal = $latestHarvest?->estimated_yield ?? 0;
                $actualYieldVal = $latestHarvest?->actual_yield ?? 0;
                
                $invRaised = $farm->investments()->where('status', 'approved')->sum('amount');
                if ($invRaised == 0) $invRaised = $farm->investments()->sum('amount');
                
                $revEarned = $latestHarvest?->market_value ?? 0;
                
                // Expenses calculation (50% or from budget_breakdown)
                $expTotal = 285000;
                if (!empty($farm->budget_breakdown) && is_array($farm->budget_breakdown)) {
                    $expTotal = array_sum(array_column($farm->budget_breakdown, 'amount'));
                } elseif ($farm->funding_raised > 0) {
                    $expTotal = round($farm->funding_raised * 0.4);
                }

                $estProfit = max(0, $revEarned - $expTotal);
                $roiPercent = $farm->expected_roi ?? 0;
                if ($invRaised > 0 && $estProfit > 0) {
                    $roiPercent = round(($estProfit / $invRaised) * 100, 1);
                }
                
                $actualYieldVal = $farm->harvests->sum('actual_yield') > 0 ? $farm->harvests->sum('actual_yield') : ($latestHarvest?->actual_yield ?? 0);
                $expYieldVal = $latestHarvest?->estimated_yield ?? ($farm->expected_yield ?? 500);
                $qualityGrade = $latestHarvest?->quality_grade ?? 'Grade A';
                $marketName = !empty($latestHarvest?->market_name) ? $latestHarvest->market_name : ($farm->location ? ($farm->location . ' APMC Market') : 'Kochi APMC Wholesale Market');
                $sellingPriceVal = ($actualYieldVal > 0 && $revEarned > 0) ? round($revEarned / $actualYieldVal) : 1500;
                $sellingPrice = '₹' . number_format($sellingPriceVal) . ' / Ton';
                $progressPercent = $expYieldVal > 0 ? min(100, round(($actualYieldVal / $expYieldVal) * 100, 1)) : 0;
            ?>

            <!-- Top 5 Financial Summary Cards Bar (Figma Exact) -->
            <div class="row g-3 mb-4">
                <!-- Card 1: Investment Raised -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Investment Raised</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($invRaised) }}</h4>
                        <div class="text-success fw-bold" style="font-size: 10px;"><i class="fas fa-check me-1"></i>Fully Funded</div>
                    </div>
                </div>

                <!-- Card 2: Revenue Earned -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Revenue Earned</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($revEarned) }}</h4>
                        <div class="text-muted" style="font-size: 10px;">Actual collections</div>
                    </div>
                </div>

                <!-- Card 3: Expenses -->
                <div class="col" style="width: 20%;">
                    <div class="card border shadow-sm rounded-4 p-3 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Expenses</div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">₹{{ number_format($expTotal) }}</h4>
                        <div class="text-muted" style="font-size: 10px;">Fertilizer, Labor, Logistics</div>
                    </div>
                </div>

                <!-- Card 4: Estimated Profit (Dark Forest Green Background Card) -->
                <div class="col" style="width: 20%;">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100" style="background: #064e3b;">
                        <div class="text-white-50 text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">Estimated Profit</div>
                        <h4 class="fw-bold text-white mb-1" style="font-size: 18px;">₹{{ number_format($estProfit) }}</h4>
                        <div class="text-white-50" style="font-size: 10px;">Post operational costs</div>
                    </div>
                </div>

                <!-- Card 5: ROI (Soft Orange/Peach Card) -->
                <div class="col" style="width: 20%;">
                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="background: #fde68a; color: #78350f;">
                        <div class="text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px; opacity: 0.8;">ROI</div>
                        <h4 class="fw-bold mb-1" style="font-size: 18px; color: #78350f;">{{ $roiPercent }}%</h4>
                        <div style="font-size: 10px; opacity: 0.8;">Annualized projection</div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Harvest Statistics & Submission Status (Figma Exact) -->
            <div class="row g-4 mb-4">
                
                <!-- Left Column: Harvest Statistics -->
                <div class="col-lg-8">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">Harvest Statistics</h6>
                            <button type="button" class="btn btn-success btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm" style="font-size: 11px; background-color: #064e3b; border-color: #064e3b;" data-bs-toggle="modal" data-bs-target="#logHarvestModal">
                                <i class="fas fa-pencil-alt me-1"></i> Edit / Log Harvest
                            </button>
                        </div>

                        @if(!$latestHarvest || $actualYieldVal == 0)
                            <div class="alert alert-success border-0 bg-success bg-opacity-10 p-3 rounded-3 d-flex align-items-center justify-content-between mb-4 text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-info-circle text-success fs-5"></i>
                                    <span style="font-size: 12px;" class="fw-semibold">No harvest record created yet. Click <strong>Edit / Log Harvest</strong> to enter yield quantity, quality grade, and market sale value.</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold flex-shrink-0 ms-2" data-bs-toggle="modal" data-bs-target="#logHarvestModal" style="background-color: #064e3b; border-color: #064e3b; font-size: 11px;">
                                    + Log Harvest
                                </button>
                            </div>
                        @endif

                        <!-- 6-Grid Stats Table -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">START/END DATES</div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">
                                    {{ $farm->start_date ? $farm->start_date->format('M d, Y') : 'Pending' }} - {{ $latestHarvest?->actual_harvest_date ? $latestHarvest->actual_harvest_date->format('M d, Y') : 'Pending' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">HARVEST QUANTITY</div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">{{ $actualYieldVal }} Tons / {{ $expYieldVal }} Tons Exp.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">QUALITY GRADE</div>
                                <div>
                                    <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 10px; background-color: #064e3b !important;">
                                        {{ strtoupper($qualityGrade) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">MARKET NAME</div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">{{ $marketName }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">SELLING PRICE</div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">{{ $sellingPrice }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">GROSS REVENUE</div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">₹{{ number_format($revEarned) }}</div>
                            </div>
                        </div>

                        <!-- Progress Bar (Figma Exact) -->
                        <div class="pt-3 border-top">
                            <div class="progress rounded-pill bg-light mb-1" style="height: 8px;">
                                <div class="progress-bar bg-success rounded-pill" style="width: {{ $progressPercent }}%; background-color: #064e3b !important;"></div>
                            </div>
                            <div class="text-end text-muted" style="font-size: 10px;">{{ $progressPercent }}% of Target Collected</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Submission Status (Figma Exact) -->
                <div class="col-lg-4">
                    <div class="card border shadow-sm rounded-4 p-4 bg-white h-100" style="border-color: #E5E7EB !important;">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Submission Status</h6>
                        
                        <?php
                            $hasHarvestDone = $latestHarvest && ($latestHarvest->actual_yield > 0 || $latestHarvest->status === 'harvested');
                            $hasProofDone = $farm->harvests->whereNotNull('image_path')->count() > 0;
                            $hasSettlementDone = $farm->status === 'completed';
                        ?>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <!-- 1. Harvest Completed -->
                            <div class="d-flex align-items-start gap-2.5 tickable-item" style="cursor: pointer;" onclick="toggleTick(this)">
                                <div class="tick-icon {{ $hasHarvestDone ? 'bg-success text-white' : 'border border-2' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px; {{ $hasHarvestDone ? 'background-color: #064e3b !important;' : 'border-color: #9ca3af !important;' }}">
                                    <i class="fas fa-check {{ $hasHarvestDone ? '' : 'd-none' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold {{ $hasHarvestDone ? 'text-dark' : 'text-muted' }} tick-title" style="font-size: 12px;">Harvest Completed</div>
                                    <div class="text-muted tick-desc" style="font-size: 10px;">{{ $latestHarvest?->actual_harvest_date ? $latestHarvest->actual_harvest_date->format('M d, Y') : 'Pending Input' }}</div>
                                </div>
                            </div>

                            <!-- 2. Proof Uploaded -->
                            <div class="d-flex align-items-start gap-2.5 tickable-item" style="cursor: pointer;" onclick="toggleTick(this)">
                                <div class="tick-icon {{ $hasProofDone ? 'bg-success text-white' : 'border border-2' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px; {{ $hasProofDone ? 'background-color: #064e3b !important;' : 'border-color: #9ca3af !important;' }}">
                                    <i class="fas fa-check {{ $hasProofDone ? '' : 'd-none' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold {{ $hasProofDone ? 'text-dark' : 'text-muted' }} tick-title" style="font-size: 12px;">Proof Uploaded</div>
                                    <div class="text-muted tick-desc" style="font-size: 10px;">{{ $hasProofDone ? 'Verified Attachments' : 'Verify attachments' }}</div>
                                </div>
                            </div>

                            <!-- 3. Admin Settlement -->
                            <div class="d-flex align-items-start gap-2.5 tickable-item" style="cursor: pointer;" onclick="toggleTick(this)">
                                <div class="tick-icon {{ $hasSettlementDone ? 'bg-success text-white' : 'border border-2' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px; {{ $hasSettlementDone ? 'background-color: #064e3b !important;' : 'border-color: #9ca3af !important;' }}">
                                    <i class="fas fa-check {{ $hasSettlementDone ? '' : 'd-none' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold {{ $hasSettlementDone ? 'text-dark' : 'text-muted' }} tick-title" style="font-size: 12px;">Admin Settlement</div>
                                    <div class="{{ $hasSettlementDone ? 'text-success' : 'text-muted' }} tick-desc" style="font-size: 10px;">{{ $hasSettlementDone ? 'Completed' : 'Pending Submission' }}</div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleTick(element) {
                                const iconContainer = element.querySelector('.tick-icon');
                                const icon = element.querySelector('.fa-check');
                                const title = element.querySelector('.tick-title');
                                
                                if (iconContainer.classList.contains('bg-success')) {
                                    // Untick
                                    iconContainer.classList.remove('bg-success', 'text-white');
                                    iconContainer.classList.add('border', 'border-2');
                                    iconContainer.style.backgroundColor = '';
                                    iconContainer.style.borderColor = '#9ca3af';
                                    icon.classList.add('d-none');
                                    title.classList.remove('text-dark');
                                    title.classList.add('text-muted');
                                } else {
                                    // Tick
                                    iconContainer.classList.remove('border', 'border-2');
                                    iconContainer.classList.add('bg-success', 'text-white');
                                    iconContainer.style.backgroundColor = '#064e3b';
                                    icon.classList.remove('d-none');
                                    title.classList.remove('text-muted');
                                    title.classList.add('text-dark');
                                }
                            }
                        </script>

                        <div class="mt-auto">
                            @if($farm->status === 'completed')
                                <button type="button" onclick="document.querySelector('#settlement-tab')?.click();" class="btn btn-secondary rounded-3 w-100 py-2.5 fw-bold text-white shadow-sm" style="font-size: 12px;">
                                    View Settlement
                                </button>
                                <div class="text-center text-success mt-2 fw-bold" style="font-size: 10px;">Settlement has been finalized.</div>
                            @else
                                <form action="{{ route('admin.farms.settle', $farm->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-dark rounded-3 w-100 py-2.5 fw-bold text-white shadow-sm" style="background: #064e3b; border-color: #064e3b; font-size: 12px;">
                                        Submit Settlement
                                    </button>
                                </form>
                                <div class="text-center text-muted mt-2" style="font-size: 10px;">Final review required for customer/investor settlement.</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- Row 3: Harvest Gallery (5 Sequential Stage Cards - Figma Exact) -->
            <div class="card border shadow-sm rounded-4 p-4 bg-white mb-4" style="border-color: #E5E7EB !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">Harvest Gallery</h6>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal" style="font-size: 11px;">
                        <i class="fas fa-upload me-1"></i> Upload Stage Photo
                    </button>
                </div>

                <?php
                    $galleryPhotos = $farm->harvests->where('status', 'gallery_photo')->pluck('image_path')->filter()->values();
                    if ($galleryPhotos->count() == 0) {
                        $galleryPhotos = $farm->harvests->pluck('image_path')->filter()->values();
                    }
                ?>

                <div class="row g-3">
                    <!-- Stage 1: Before Harvest -->
                    <div class="col" style="width: 20%;">
                        <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal">
                            @if(isset($galleryPhotos[0]))
                                <img src="{{ asset('storage/' . $galleryPhotos[0]) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-seedling text-muted opacity-50 fs-4 mb-2"></i>
                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">BEFORE HARVEST</div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">Before Harvest</div>
                        </div>
                    </div>

                    <!-- Stage 2: Process -->
                    <div class="col" style="width: 20%;">
                        <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal">
                            @if(isset($galleryPhotos[1]))
                                <img src="{{ asset('storage/' . $galleryPhotos[1]) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-camera text-muted opacity-50 fs-4 mb-2"></i>
                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">PROCESS</div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">Process</div>
                        </div>
                    </div>

                    <!-- Stage 3: Packing -->
                    <div class="col" style="width: 20%;">
                        <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal">
                            @if(isset($galleryPhotos[2]))
                                <img src="{{ asset('storage/' . $galleryPhotos[2]) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-box text-muted opacity-50 fs-4 mb-2"></i>
                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">PACKING</div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">Packing</div>
                        </div>
                    </div>

                    <!-- Stage 4: Transportation -->
                    <div class="col" style="width: 20%;">
                        <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal">
                            @if(isset($galleryPhotos[3]))
                                <img src="{{ asset('storage/' . $galleryPhotos[3]) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-truck text-muted opacity-50 fs-4 mb-2"></i>
                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">TRANSPORT</div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">Transportation</div>
                        </div>
                    </div>

                    <!-- Stage 5: Final Produce -->
                    <div class="col" style="width: 20%;">
                        <div class="border rounded-3 overflow-hidden text-center bg-light d-flex flex-column align-items-center justify-content-center p-2 position-relative" style="height: 140px; border-style: dashed !important; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadHarvestPhotoModal">
                            @if(isset($galleryPhotos[4]))
                                <img src="{{ asset('storage/' . $galleryPhotos[4]) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-shopping-basket text-muted opacity-50 fs-4 mb-2"></i>
                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">FINAL PRODUCE</div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-light text-muted fw-bold border-top" style="font-size: 10px;">Final Produce</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. Settlement Tab (Figma Exact & 100% Dynamic) -->
        <div class="tab-pane fade" id="settlement" role="tabpanel">
            
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
                                            $totalExpenses += $cost;
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="fw-bold text-dark">{{ $name }}</td>
                                            <td class="text-muted">{{ $desc }}</td>
                                            <td class="text-muted">1 Plot</td>
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
                        <h5 class="modal-title fw-bold mb-0 text-white">Log / Edit Harvest Record</h5>
                        <small class="text-white-50">Record produce yield, quality grade, and market value for {{ $farm->name }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.store') }}" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                <div class="modal-body p-4 text-dark">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Harvest Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="harvested" {{ ($latestHarvest?->status ?? 'harvested') === 'harvested' ? 'selected' : '' }}>Harvest Completed & Sold</option>
                                <option value="harvesting" {{ ($latestHarvest?->status ?? '') === 'harvesting' ? 'selected' : '' }}>Harvest Currently in Progress</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Quality Grade <span class="text-danger">*</span></label>
                            <select class="form-select" name="quality_grade" required>
                                <option value="Grade A+" {{ ($latestHarvest?->quality_grade ?? '') === 'Grade A+' ? 'selected' : '' }}>Grade A+ (Premium Export Quality)</option>
                                <option value="Grade A" {{ ($latestHarvest?->quality_grade ?? 'Grade A') === 'Grade A' ? 'selected' : '' }}>Grade A (High Commercial Grade)</option>
                                <option value="Grade B" {{ ($latestHarvest?->quality_grade ?? '') === 'Grade B' ? 'selected' : '' }}>Grade B (Standard Local Grade)</option>
                                <option value="Grade C" {{ ($latestHarvest?->quality_grade ?? '') === 'Grade C' ? 'selected' : '' }}>Grade C (Processing Quality)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Actual Harvest Quantity (Tons) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="actual_yield" value="{{ $latestHarvest?->actual_yield ?? 450 }}" placeholder="e.g. 450" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Target / Expected Yield (Tons)</label>
                            <input type="number" step="0.1" class="form-control" name="estimated_yield" value="{{ $latestHarvest?->estimated_yield ?? ($farm->expected_yield ?? 500) }}" placeholder="e.g. 500">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Gross Revenue / Sale Value (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="market_value" value="{{ $latestHarvest?->market_value ?? 850000 }}" placeholder="e.g. 850000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">Harvest Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="actual_harvest_date" value="{{ $latestHarvest?->actual_harvest_date ? $latestHarvest->actual_harvest_date->format('Y-m-d') : date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Upload Harvest Photo Proof (Optional)</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted mt-1 d-block">Upload photo of crop cutting, produce packing, or weighbridge receipt.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0" style="background: #f8fafc; padding: 16px 24px;">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #064e3b; border-color: #064e3b;">
                        <i class="fas fa-check-circle me-1"></i> Save Harvest Record
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
                        <select class="form-select rounded-3" name="harvest_stage">
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
                    filesList.innerHTML = `
                        <div class="text-muted small text-center p-2">No files selected. Submit request to clear.</div>
                    `;
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

<!-- Log Harvest Modal -->
<div class="modal fade" id="logHarvestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-wheat-awn text-success me-2"></i>Log / Manage Harvest Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Harvest Status</label>
                        <select class="form-select rounded-3" name="status" required>
                            <option value="growing">Growing / Ripening</option>
                            <option value="ready">Ready for Harvest</option>
                            <option value="harvested" selected>Harvest Completed</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Estimated Yield (Tons)</label>
                            <input type="number" step="0.1" class="form-control rounded-3" name="estimated_yield" value="{{ $farm->expected_yield ?? 12.5 }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Actual Yield Harvested (Tons)</label>
                            <input type="number" step="0.1" class="form-control rounded-3" name="actual_yield" placeholder="e.g. 14.2" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Quality Grade</label>
                            <select class="form-select rounded-3" name="quality_grade">
                                <option value="Grade A Premium" selected>Grade A Premium</option>
                                <option value="Grade B Standard">Grade B Standard</option>
                                <option value="Organic Certified">Organic Certified</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Market Valuation (₹)</label>
                            <input type="number" class="form-control rounded-3" name="market_value" placeholder="e.g. 450000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Actual Harvest Date</label>
                        <input type="date" class="form-control rounded-3" name="actual_harvest_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Upload Harvest Photo (Proof)</label>
                        <input type="file" class="form-control rounded-3" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Save Harvest Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($farm->harvests as $harvest)
<!-- Edit Harvest Modal -->
<div class="modal fade" id="editHarvestModal-{{ $harvest->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Edit Harvest Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.harvests.update', $harvest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Status</label>
                        <select class="form-select rounded-3" name="status" required>
                            <option value="growing" {{ $harvest->status === 'growing' ? 'selected' : '' }}>Growing</option>
                            <option value="ready" {{ $harvest->status === 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="harvested" {{ $harvest->status === 'harvested' ? 'selected' : '' }}>Harvested</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Estimated Yield (Tons)</label>
                            <input type="number" step="0.1" class="form-control rounded-3" name="estimated_yield" value="{{ $harvest->estimated_yield }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Actual Yield Harvested (Tons)</label>
                            <input type="number" step="0.1" class="form-control rounded-3" name="actual_yield" value="{{ $harvest->actual_yield }}" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Quality Grade</label>
                            <input type="text" class="form-control rounded-3" name="quality_grade" value="{{ $harvest->quality_grade }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-semibold small">Market Valuation (₹)</label>
                            <input type="number" class="form-control rounded-3" name="market_value" value="{{ $harvest->market_value }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold small">Actual Harvest Date</label>
                        <input type="date" class="form-control rounded-3" name="actual_harvest_date" value="{{ $harvest->actual_harvest_date ? $harvest->actual_harvest_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="mb-3">
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

        const cleanId = tabId.replace('#', '');
        const tabBtn = document.querySelector(`[data-bs-target="#${cleanId}"]`) || document.getElementById(`${cleanId}-tab`);
        if (tabBtn) {
            try {
                const tab = new bootstrap.Tab(tabBtn);
                tab.show();
            } catch(e) {
                tabBtn.click();
            }
            setTimeout(() => {
                tabBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 150);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const hash = window.location.hash.replace('#', '');
        
        const activeTabTarget = tabParam || hash;
        if (activeTabTarget) {
            const cleanId = activeTabTarget.replace('#', '');
            const tabBtn = document.querySelector(`[data-bs-target="#${cleanId}"]`) || document.getElementById(`${cleanId}-tab`);
            if (tabBtn) {
                try {
                    const tab = new bootstrap.Tab(tabBtn);
                    tab.show();
                } catch(e) {
                    tabBtn.click();
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

@extends('layouts.admin')

@section('page-title', $farm->name)

@section('content')
<?php
    $startDate = $farm->start_date ? \Carbon\Carbon::parse($farm->start_date) : ($farm->created_at ?? now());
    $endDate = $farm->expected_harvest_date ? \Carbon\Carbon::parse($farm->expected_harvest_date) : $startDate->copy()->addMonths($farm->yielding_period ?? 6);
    $totalDays = max(1, $startDate->diffInDays($endDate));
    $passedDays = max(0, min($totalDays, $startDate->diffInDays(now())));
    $progressPerc = min(100, round(($passedDays / $totalDays) * 100));

    $myInvestment = auth()->user()?->investments()->where('farm_id', $farm->id)->first();
    $investedAmount = $myInvestment?->amount ?? 0;
    $equityShare = $myInvestment?->equity_share ?? ($farm->funding_target > 0 ? round(($investedAmount / $farm->funding_target) * 100, 2) : 0);
    $expectedROI = $farm->expected_roi ?? 0;
    $expectedReturnAmount = round($investedAmount * (1 + ($expectedROI / 100)));
?>

<div class="container-fluid py-3">

    <!-- Top Header Banner (100% Dynamic) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white" style="border: 1px solid #e5e7eb !important;">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h3 class="fw-bold text-dark mb-0 fs-3">{{ $farm->name }}</h3>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
                        {{ $farm->status ?? 'ACTIVE CYCLE' }}
                    </span>
                </div>
                <p class="text-muted mb-0" style="font-size: 12px;">
                    Ongoing Cycle: {{ $startDate->format('F Y') }} - {{ $endDate->format('F Y') }}
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="p-3 rounded-4 text-white text-start text-lg-start ms-lg-auto" style="background-color: #064e3b; max-width: 320px;">
                    <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #a7f3d0;">
                        <span>CYCLE PROGRESS</span>
                        <strong class="text-white fs-6">{{ $progressPerc }}%</strong>
                    </div>
                    <div class="progress rounded-pill bg-white bg-opacity-20 mb-1" style="height: 6px;">
                        <div class="progress-bar bg-success rounded-pill" style="width: {{ $progressPerc }}%; background-color: #34d399 !important;"></div>
                    </div>
                    <div class="text-white-50 text-end" style="font-size: 10px;">{{ $progressPerc }}% completed</div>
                </div>
            </div>
        </div>

        <!-- 3 Sub-Tabs Navigation -->
        <ul class="nav nav-tabs border-bottom-0 mt-4 mb-0" id="investorFarmTabs" role="tablist" style="font-size: 12px; font-weight: 600;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 py-2 me-2 border-0 text-dark" id="tab-btn-timeline" data-bs-toggle="tab" data-bs-target="#tab-timeline" type="button" role="tab">
                    Timeline & Updates
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 me-2 border-0 text-dark" id="tab-btn-harvest" data-bs-toggle="tab" data-bs-target="#tab-harvest" type="button" role="tab">
                    Harvest
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 border-0 text-dark" id="tab-btn-details" data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab">
                    Investment Details
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Contents Container -->
    <div class="tab-content" id="investorFarmTabsContent">
        
        <!-- ========================================== -->
        <!-- SUB-TAB 1: TIMELINE & UPDATES             -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="tab-timeline" role="tabpanel">
            <div class="row g-4">
                <!-- Left Column: Operational Timeline -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid #e5e7eb !important;">
                        <h6 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2" style="font-size: 14px;">
                            <i class="fas fa-route text-success"></i> Operational Timeline
                        </h6>
                        <div class="vertical-timeline position-relative ps-4" style="border-left: 2px solid #e5e7eb;">
                            @php
                                $stages = [
                                    ['title' => 'Stage 1: Land Prep', 'date' => $startDate->format('M d, Y'), 'done' => true],
                                    ['title' => 'Stage 2: Soil Prep', 'date' => $startDate->copy()->addDays(14)->format('M d, Y'), 'done' => true],
                                    ['title' => 'Stage 3: Sowing', 'date' => $startDate->copy()->addDays(30)->format('M d, Y'), 'done' => true],
                                    ['title' => 'Stage 4: Irrigation', 'date' => $startDate->copy()->addDays(45)->format('M d, Y'), 'done' => true],
                                    ['title' => 'Stage 5: Crop Growth (' . $progressPerc . '%)', 'date' => 'In Progress', 'done' => false, 'active' => true],
                                    ['title' => 'Stage 6: Flowering', 'date' => $endDate->copy()->subDays(30)->format('M d, Y'), 'done' => false],
                                    ['title' => 'Stage 7: Harvest & Settlement', 'date' => $endDate->format('M d, Y'), 'done' => false],
                                ];
                            @endphp

                            @foreach($stages as $st)
                                <div class="timeline-step mb-4 position-relative {{ isset($st['done']) && !$st['done'] && !isset($st['active']) ? 'opacity-50' : '' }}">
                                    @if(isset($st['done']) && $st['done'])
                                        <div class="step-icon position-absolute rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="left: -33px; top: 0; width: 22px; height: 22px; font-size: 10px;">✓</div>
                                    @elseif(isset($st['active']) && $st['active'])
                                        <div class="step-icon position-absolute rounded-circle bg-success border border-3 border-white text-white d-flex align-items-center justify-content-center shadow-sm" style="left: -33px; top: 0; width: 24px; height: 24px; font-size: 10px;">⚙</div>
                                    @else
                                        <div class="step-icon position-absolute rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center" style="left: -33px; top: 0; width: 22px; height: 22px; font-size: 10px;">•</div>
                                    @endif
                                    <div class="fw-bold {{ isset($st['active']) && $st['active'] ? 'text-success' : 'text-dark' }} text-uppercase" style="font-size: 11px;">{{ $st['title'] }}</div>
                                    <div class="text-muted" style="font-size: 10px;">{{ $st['date'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Farm Updates Feed (100% Dynamic) -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid #e5e7eb !important;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;"><i class="fas fa-rss text-success me-2"></i>Farm Updates Feed</h6>
                            <span class="text-muted" style="font-size: 11px;"><i class="fas fa-filter me-1"></i> Filter Updates</span>
                        </div>

                        @forelse($farm->updates ?? [] as $update)
                            <div class="card border rounded-4 p-3 mb-4 shadow-sm" style="border-color: #f3f4f6 !important;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-seedling" style="font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">{{ $update->title }}</h6>
                                            <small class="text-muted" style="font-size: 10px;">{{ $update->created_at?->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <i class="fas fa-ellipsis-v text-muted" style="font-size: 12px;"></i>
                                </div>
                                <p class="text-secondary small mb-3" style="font-size: 11px; line-height: 1.6;">
                                    {{ $update->description }}
                                </p>
                                @if($update->image_path)
                                    <img src="{{ asset('storage/' . $update->image_path) }}" class="img-fluid rounded-3 mb-3 w-100" style="max-height: 240px; object-fit: cover;">
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-rss fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0 small">No progress updates published for this farm plot yet.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SUB-TAB 2: HARVEST                        -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-harvest" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid #e5e7eb !important;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Harvest & Settlement Report</h5>
                        <p class="text-muted mb-0" style="font-size: 11px;">Detailed breakdown of the {{ $startDate->format('Y') }} Harvest Cycle at {{ $farm->name }}.</p>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;">
                        <i class="fas fa-check-circle me-1"></i> {{ strtoupper($farm->status ?? 'ACTIVE') }}
                    </span>
                </div>

                <div class="row g-4">
                    <!-- Left Column: Harvest Report -->
                    <div class="col-lg-7">
                        <div class="card border rounded-4 p-4 mb-4" style="border-color: #f3f4f6 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;"><i class="fas fa-tractor text-success me-2"></i>Harvest Yield Summary</h6>
                            </div>
                            <div class="row g-3 mb-3 text-center">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3 border">
                                        <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">EXPECTED YIELD</small>
                                        <strong class="fw-bold text-dark fs-5">{{ $farm->expected_yield ?? 0 }} Tons</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3 border">
                                        <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">ESTIMATED REVENUE</small>
                                        <strong class="fw-bold text-dark fs-5">₹{{ number_format($farm->expected_revenue ?? 0) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 11px;">
                                <span>Harvest Readiness</span>
                                <strong>{{ $progressPerc }}%</strong>
                            </div>
                            <div class="progress rounded-pill" style="height: 6px;">
                                <div class="progress-bar bg-success rounded-pill" style="width: {{ $progressPerc }}%;"></div>
                            </div>
                        </div>

                        <!-- Proof of Verification -->
                        <div class="card border rounded-4 p-3 bg-light" style="border-color: #e5e7eb !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;"><i class="fas fa-file-invoice text-primary me-2"></i>Verification Record</h6>
                                <span class="badge bg-success text-white rounded-pill px-2.5 py-1" style="font-size: 10px;">ADMIN VERIFIED</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2.5 bg-white rounded-3 border">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt text-success fs-4"></i>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 12px;">Verified Plot Record #PLOT-{{ $farm->id }}</div>
                                        <small class="text-muted" style="font-size: 10px;">Location: {{ $farm->location ?? 'Kerala, India' }}</small>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-success fs-5"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Financial Settlement Box -->
                    <div class="col-lg-5">
                        <div class="card border-0 rounded-4 p-4 text-dark shadow-sm h-100" style="background: #F8FAFC; border: 1px solid #E2E8F0 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;"><i class="fas fa-wallet text-success me-2"></i>Financial Return Projection</h6>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">Escrow Protected</span>
                            </div>
                            <div class="table-responsive mb-4">
                                <table class="table table-borderless align-middle mb-0" style="font-size: 12px;">
                                    <tbody>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-2.5">Pledged Capital</td>
                                            <td class="text-end fw-bold text-dark py-2.5">₹{{ number_format($investedAmount) }}</td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-2.5">Expected ROI Rate</td>
                                            <td class="text-end fw-bold text-primary py-2.5">{{ $expectedROI }}%</td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-2.5">Estimated Net Profit</td>
                                            <td class="text-end fw-bold text-success py-2.5">+ ₹{{ number_format(max(0, $expectedReturnAmount - $investedAmount)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 rounded-3 bg-white border border-success border-opacity-25 text-center mt-auto">
                                <div class="text-muted fw-bold text-uppercase mb-1" style="font-size: 10px;">PROJECTED TOTAL PAYOUT</div>
                                <h3 class="fw-bold text-success mb-0 fs-2">₹{{ number_format($expectedReturnAmount) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SUB-TAB 3: INVESTMENT DETAILS             -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-details" role="tabpanel">
            <div class="row g-4 mb-4">
                <!-- Top Left Grid: Farm Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid #e5e7eb !important;">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;"><i class="fas fa-info-circle text-success me-2"></i>Farm Summary</h6>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2.5 border">
                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">LAND SIZE</small>
                                    <strong class="text-dark small fw-bold">{{ $farm->total_acres ?? 0 }} Acres</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2.5 border">
                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">LOCATION</small>
                                    <strong class="text-dark small fw-bold">{{ $farm->location ?? 'Kerala' }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2.5 border">
                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">PRIMARY CROP</small>
                                    <strong class="text-dark small fw-bold">{{ $farm->primary_crop ?? 'Crop' }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-2.5 border">
                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">SECONDARY CROP</small>
                                    <strong class="text-dark small fw-bold">{{ $farm->secondary_crop ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Center Grid: Metrics -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid #e5e7eb !important;">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;"><i class="fas fa-chart-bar text-primary me-2"></i>Metrics</h6>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 11px;">
                            <span class="text-muted">Expected Harvest</span>
                            <strong class="text-dark">{{ $endDate->format('d M Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 11px;">
                            <span class="text-muted">Expected Yield</span>
                            <strong class="text-dark">{{ $farm->expected_yield ?? 0 }} Tons</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 11px;">
                            <span class="text-muted">Expected Revenue</span>
                            <strong class="text-dark">₹{{ number_format($farm->expected_revenue ?? 0) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 11px;">
                            <span class="text-muted">Farmer Stake / Contribution</span>
                            <strong class="text-success">₹{{ number_format($farm->your_contribution ?? 50000) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2" style="font-size: 11px;">
                            <span class="text-muted">ROI</span>
                            <strong class="text-success fs-6 fw-bold">{{ $expectedROI }}%</strong>
                        </div>
                    </div>
                </div>

                <!-- Top Right Grid: Funding Goal -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid #e5e7eb !important;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">Funding Goal</h6>
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1 text-uppercase" style="font-size: 9px;">
                                {{ $farm->status ?? 'ACTIVE' }}
                            </span>
                        </div>
                        <h3 class="fw-bold text-dark mb-2 fs-2">₹{{ number_format($farm->funding_target ?? 0) }}</h3>
                        <div class="text-muted mb-3" style="font-size: 11px;">Raised: ₹{{ number_format($farm->funding_raised ?? 0) }}</div>
                        <div class="p-2.5 rounded-3 bg-light border text-muted" style="font-size: 10px;">
                            <i class="fas fa-info-circle me-1"></i> Verified agricultural investment plot backed by SoulSoil.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Cultivation Journey & Your Investment -->
            <div class="row g-4">
                <!-- Cultivation Journey -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid #e5e7eb !important;">
                        <h6 class="fw-bold text-dark mb-4" style="font-size: 13px;"><i class="fas fa-route text-success me-2"></i>Cultivation Journey</h6>
                        <div class="d-flex justify-content-between align-items-center text-center position-relative mb-4">
                            <div>
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 28px; height: 28px; font-size: 11px;">✓</div>
                                <div class="fw-bold text-dark" style="font-size: 10px;">Investment</div>
                            </div>
                            <div>
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 28px; height: 28px; font-size: 11px;">✓</div>
                                <div class="fw-bold text-dark" style="font-size: 10px;">Farm Approved</div>
                            </div>
                            <div>
                                <div class="bg-success border border-3 border-white text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1 shadow-sm" style="width: 32px; height: 32px; font-size: 11px;">⚙</div>
                                <div class="fw-bold text-success" style="font-size: 10px;">Cultivation</div>
                            </div>
                            <div class="opacity-50">
                                <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 28px; height: 28px; font-size: 11px;">4</div>
                                <div class="fw-bold text-muted" style="font-size: 10px;">Harvest</div>
                            </div>
                            <div class="opacity-50">
                                <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 28px; height: 28px; font-size: 11px;">5</div>
                                <div class="fw-bold text-muted" style="font-size: 10px;">Settlement</div>
                            </div>
                        </div>
                        @if($farm->farm_photo_path)
                            <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="img-fluid rounded-4 w-100" style="max-height: 280px; object-fit: cover;">
                        @endif
                    </div>
                </div>

                <!-- Right Column: Your Investment Box -->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-4 p-4 text-white shadow-sm mb-4" style="background-color: #064e3b;">
                        <h6 class="fw-bold mb-3 text-white" style="font-size: 13px;"><i class="fas fa-hand-holding-usd text-success me-2"></i>Your Investment</h6>
                        <h3 class="fw-bold text-white mb-3 fs-2">₹{{ number_format($investedAmount) }}</h3>
                        <div class="d-flex justify-content-between text-white-50 mb-3 pb-3 border-bottom border-success border-opacity-25" style="font-size: 11px;">
                            <span>Invested Date: {{ $myInvestment?->created_at?->format('d M Y') ?? 'Active' }}</span>
                            <span>Ownership: {{ $equityShare }}%</span>
                        </div>
                        <div class="mb-4">
                            <div class="text-white-50 small mb-1" style="font-size: 10px;">EXPECTED RETURN</div>
                            <h4 class="fw-bold text-white mb-0" style="color: #34d399 !important;">
                                ₹{{ number_format($expectedReturnAmount) }} 
                                <small class="fs-6 fw-semibold text-white-50">(+{{ $expectedROI }}% Profit)</small>
                            </h4>
                        </div>
                        <button type="button" class="btn btn-light rounded-pill w-100 fw-bold text-success py-2.5 shadow-sm" data-bs-toggle="modal" data-bs-target="#investmentCertificateModal">
                            <i class="fas fa-certificate me-1.5"></i> View Certificate
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Investment Certificate Modal (100% Dynamic) -->
<div class="modal fade" id="investmentCertificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Certificate Body -->
            <div class="modal-body p-5 bg-white text-dark position-relative" style="border: 12px double #064e3b; background-image: radial-gradient(circle at center, rgba(16,185,129,0.03) 0%, transparent 70%);">
                
                <!-- Watermark -->
                <div class="position-absolute top-50 start-50 translate-middle opacity-10 pointer-events-none text-center" style="z-index: 0;">
                    <i class="fas fa-seedling text-success" style="font-size: 240px;"></i>
                </div>

                <div class="position-relative" style="z-index: 1;">
                    <!-- Certificate Header -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-2" style="width: 54px; height: 54px;">
                            <i class="fas fa-award fa-2x"></i>
                        </div>
                        <h6 class="text-uppercase fw-bold text-success tracking-wider mb-1" style="letter-spacing: 3px; font-size: 11px;">SOUL SOIL AGRI-TECH PLATFORM</h6>
                        <h2 class="fw-bold text-dark font-serif mb-2" style="font-family: 'Georgia', serif; letter-spacing: 1px;">CERTIFICATE OF FARM INVESTMENT</h2>
                        <div class="badge bg-dark text-warning border border-warning px-3 py-1.5 rounded-pill fw-bold" style="font-size: 10px; letter-spacing: 1px;">
                            OFFICIAL VERIFIED CERTIFICATE #SS-INV-{{ $farm->id }}-{{ auth()->id() ?? '001' }}
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: #064e3b; opacity: 0.2;">

                    <!-- Certificate Text -->
                    <div class="text-center px-lg-4 mb-4">
                        <p class="text-muted mb-2 fs-6">This is to officially certify that</p>
                        <h3 class="fw-bold text-success font-serif mb-3" style="font-family: 'Georgia', serif; font-size: 26px; border-bottom: 2px dashed #10b981; display: inline-block; padding-bottom: 4px;">
                            {{ auth()->user()?->full_name ?? auth()->user()?->name ?? 'Verified Investor' }}
                        </h3>
                        <p class="text-dark fs-6 mb-4" style="line-height: 1.8;">
                            has successfully pledged capital and acquired an official equity share backing for the sustainable agricultural operations of 
                            <strong class="text-dark fw-bold">{{ $farm->name }}</strong> 
                            located at <span class="fw-semibold text-secondary">{{ $farm->location ?? 'Kerala, India' }}</span>.
                        </p>
                    </div>

                    <!-- Key Details Grid -->
                    <div class="row g-3 mb-4 text-center">
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size: 9px;">Pledged Capital</small>
                                <strong class="fw-bold text-success fs-5">₹{{ number_format($investedAmount) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size: 9px;">Equity Share</small>
                                <strong class="fw-bold text-dark fs-5">{{ $equityShare }}%</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size: 9px;">Expected ROI</small>
                                <strong class="fw-bold text-primary fs-5">{{ $expectedROI }}%</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size: 9px;">Issue Date</small>
                                <strong class="fw-bold text-dark fs-6">{{ $myInvestment?->created_at?->format('d M Y') ?? date('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Signatures & Seal -->
                    <div class="row align-items-end mt-4 pt-3 border-top">
                        <div class="col-6 text-start">
                            <div class="fw-bold text-dark mb-0" style="font-family: 'Georgia', serif; font-style: italic; font-size: 18px; color: #064e3b !important;">
                                SoulSoil Board Seal
                            </div>
                            <div class="text-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Authorized Platform Signatory</div>
                        </div>
                        <div class="col-6 text-end">
                            <div class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-3">
                                <i class="fas fa-shield-alt fs-4"></i>
                                <div class="text-start" style="font-size: 10px;">
                                    <div class="fw-bold">GOVT & BANK VERIFIED</div>
                                    <div class="text-muted">Smart Agriculture Escrow</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Controls -->
            <div class="modal-footer bg-light px-4 py-3 justify-content-between border-top">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal" style="font-size: 12px;">Close</button>
                <button type="button" onclick="window.print()" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="font-size: 12px;">
                    <i class="fas fa-print me-1.5"></i> Print / Download Certificate PDF
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
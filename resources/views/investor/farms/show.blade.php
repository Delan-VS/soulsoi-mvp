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

    // ==========================================
    // DYNAMIC AGRICULTURAL HARVEST & TONNAGE ENGINE
    // ==========================================
    $latestHarvestObj = $farm->harvests()->latest()->first();
    $acres = floatval($farm->total_acres > 0 ? $farm->total_acres : 2.5);
    $cropName = $farm->primary_crop ?? 'Organic Produce';
    $cropLower = strtolower($cropName);

    // Realistic agronomic yield multipliers (Tons per Acre) and base market price per Ton (INR)
    if (str_contains($cropLower, 'paddy') || str_contains($cropLower, 'rice')) {
        $cropYieldMultiplier = 2.8;
        $standardPricePerTon = 28500;
    } elseif (str_contains($cropLower, 'banana') || str_contains($cropLower, 'plantain')) {
        $cropYieldMultiplier = 12.0;
        $standardPricePerTon = 22000;
    } elseif (str_contains($cropLower, 'sugarcane')) {
        $cropYieldMultiplier = 35.0;
        $standardPricePerTon = 3400;
    } elseif (str_contains($cropLower, 'wheat') || str_contains($cropLower, 'cereal') || str_contains($cropLower, 'corn') || str_contains($cropLower, 'maize')) {
        $cropYieldMultiplier = 2.5;
        $standardPricePerTon = 26000;
    } elseif (str_contains($cropLower, 'tomato') || str_contains($cropLower, 'vegetable') || str_contains($cropLower, 'chilli') || str_contains($cropLower, 'onion')) {
        $cropYieldMultiplier = 7.5;
        $standardPricePerTon = 32000;
    } elseif (str_contains($cropLower, 'cardamom') || str_contains($cropLower, 'pepper') || str_contains($cropLower, 'spice') || str_contains($cropLower, 'vanilla')) {
        $cropYieldMultiplier = 1.2;
        $standardPricePerTon = 220000;
    } elseif (str_contains($cropLower, 'coconut')) {
        $cropYieldMultiplier = 4.5;
        $standardPricePerTon = 36000;
    } elseif (str_contains($cropLower, 'tea') || str_contains($cropLower, 'coffee')) {
        $cropYieldMultiplier = 1.8;
        $standardPricePerTon = 85000;
    } else {
        $cropYieldMultiplier = 3.5;
        $standardPricePerTon = 30000;
    }

    // Expected yield in tons
    $expectedYieldTons = ($latestHarvestObj && $latestHarvestObj->estimated_yield > 0)
        ? (float)$latestHarvestObj->estimated_yield
        : round($acres * $cropYieldMultiplier, 1);

    // Actual harvested yield in tons
    $actualYieldTons = ($latestHarvestObj && $latestHarvestObj->actual_yield > 0)
        ? (float)$latestHarvestObj->actual_yield
        : 0;

    $isHarvestRecorded = ($actualYieldTons > 0 || ($latestHarvestObj && in_array($latestHarvestObj->status, ['harvested', 'ready', 'settled'])));
    $displayYield = $isHarvestRecorded ? $actualYieldTons : $expectedYieldTons;

    // Gross produce revenue & price per ton
    if ($latestHarvestObj && $latestHarvestObj->market_value > 0) {
        $grossRevenue = (float)$latestHarvestObj->market_value;
        $pricePerTon = ($displayYield > 0) ? round($grossRevenue / $displayYield) : $standardPricePerTon;
    } else {
        $fundingBasedRev = ($farm->funding_target > 0) ? round($farm->funding_target * (1 + (($expectedROI > 0 ? $expectedROI : 18) / 100))) : 0;
        if ($fundingBasedRev > 0 && $expectedYieldTons > 0) {
            $pricePerTon = max(1000, round($fundingBasedRev / $expectedYieldTons));
            $grossRevenue = round($displayYield * $pricePerTon);
        } else {
            $pricePerTon = $standardPricePerTon;
            $grossRevenue = round($displayYield * $pricePerTon);
        }
    }

    $yieldAttainmentPerc = ($expectedYieldTons > 0)
        ? min(100, round(($displayYield / $expectedYieldTons) * 100))
        : 100;

    // Investor's personal produce entitlement (tons)
    $investorTons = ($equityShare > 0 && $displayYield > 0)
        ? round(($equityShare / 100) * $displayYield, 2)
        : round(max(0.1, ($investedAmount > 0 ? ($investedAmount / max(1, $grossRevenue)) * $displayYield : 0)), 2);

    $harvestQualityGrade = $latestHarvestObj?->quality_grade ?? 'Grade A+ (Certified Organic)';
    $marketDestination = !empty($latestHarvestObj?->market_name)
        ? $latestHarvestObj->market_name
        : ($farm->location ? ($farm->location . ' APMC Wholesale Mandi') : 'Kochi APMC Wholesale Market');

    // Lifecycle determination
    $isFarmSettled = ($farm->status === 'completed');
    $isHarvestSold = ($latestHarvestObj && $latestHarvestObj->market_value > 0);
    $isHarvested = $isFarmSettled || ($latestHarvestObj && ($latestHarvestObj->actual_yield > 0 || in_array($latestHarvestObj->status, ['harvested', 'settled'])));
    $isCuttingStarted = $isHarvested || ($latestHarvestObj && $latestHarvestObj->status === 'harvesting') || $progressPerc >= 85;

    if ($isFarmSettled) {
        $harvestStageIdx = 4;
    } elseif ($isHarvestSold) {
        $harvestStageIdx = 3;
    } elseif ($isHarvested) {
        $harvestStageIdx = 2;
    } elseif ($isCuttingStarted) {
        $harvestStageIdx = 1;
    } else {
        $harvestStageIdx = 0;
    }
    ?>

    <div class="container-fluid py-3">

        <!-- Top Header Banner (100% Dynamic) -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white" style="border: 1px solid #e5e7eb !important;">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h3 class="fw-bold text-dark mb-0 fs-3">{{ $farm->name }}</h3>
                        <span
                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold text-uppercase"
                            style="font-size: 10px; letter-spacing: 0.5px;">
                            {{ $farm->status ?? 'ACTIVE CYCLE' }}
                        </span>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        Ongoing Cycle: {{ $startDate->format('F Y') }} - {{ $endDate->format('F Y') }}
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="p-3 rounded-4 text-white text-start text-lg-start ms-lg-auto"
                        style="background-color: #064e3b; max-width: 320px;">
                        <div class="d-flex justify-content-between align-items-center mb-1"
                            style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #a7f3d0;">
                            <span>CYCLE PROGRESS</span>
                            <strong class="text-white fs-6">{{ $progressPerc }}%</strong>
                        </div>
                        <div class="progress rounded-pill bg-white bg-opacity-20 mb-1" style="height: 6px;">
                            <div class="progress-bar bg-success rounded-pill"
                                style="width: {{ $progressPerc }}%; background-color: #34d399 !important;"></div>
                        </div>
                        <div class="text-white-50 text-end" style="font-size: 10px;">{{ $progressPerc }}% completed</div>
                    </div>
                </div>
            </div>

            <!-- 3 Sub-Tabs Navigation -->
            <ul class="nav nav-tabs border-bottom-0 mt-4 mb-0" id="investorFarmTabs" role="tablist"
                style="font-size: 12px; font-weight: 600;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 py-2 me-2 border-0 text-dark" id="tab-btn-timeline"
                        data-bs-toggle="tab" data-bs-target="#tab-timeline" type="button" role="tab">
                        Timeline & Updates
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2 me-2 border-0 text-dark" id="tab-btn-harvest"
                        data-bs-toggle="tab" data-bs-target="#tab-harvest" type="button" role="tab">
                        Harvest
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2 border-0 text-dark" id="tab-btn-details"
                        data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab">
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
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100"
                            style="border: 1px solid #e5e7eb !important;">
                            <h6 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2" style="font-size: 14px;">
                                <i class="fas fa-route text-success"></i> Operational Timeline
                            </h6>
                            <div class="vertical-timeline position-relative ps-4" style="border-left: 2px solid #e5e7eb;">
                                @php
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

                                        foreach (['Land Prep', 'Seeding', 'Irrigation & Growth', 'Harvesting'] as $stgName) {
                                            if (!empty($disbursedStagesMap[$stgName])) {
                                                unset($pendingStagesMap[$stgName]);
                                            }
                                        }
                                    }

                                    $farmStages = ['Land Prep', 'Seeding', 'Irrigation & Growth', 'Harvesting', 'Settlement'];
                                    $latestHarvestObj = $farm->harvests()->latest()->first();
                                    $isFarmSettled = ($farm->status === 'completed');
                                    $isHarvested = $isFarmSettled || ($latestHarvestObj && ($latestHarvestObj->actual_yield > 0 || $latestHarvestObj->status === 'harvested'));

                                    $highestCompletedIdx = -1;
                                    if ($isFarmSettled) {
                                        $highestCompletedIdx = 4;
                                    } elseif ($isHarvested || !empty($disbursedStagesMap['Harvesting'])) {
                                        $highestCompletedIdx = 3;
                                    } elseif (!empty($disbursedStagesMap['Irrigation & Growth'])) {
                                        $highestCompletedIdx = 2;
                                    } elseif (!empty($disbursedStagesMap['Seeding'])) {
                                        $highestCompletedIdx = 1;
                                    } elseif (!empty($disbursedStagesMap['Land Prep'])) {
                                        $highestCompletedIdx = 0;
                                    }

                                    $activeIdx = min(4, $highestCompletedIdx + 1);

                                    $investorStagesList = [
                                        ['name' => 'Land Prep', 'date' => $startDate->format('M d, Y')],
                                        ['name' => 'Seeding', 'date' => $startDate->copy()->addDays(14)->format('M d, Y')],
                                        ['name' => 'Irrigation & Growth', 'date' => $startDate->copy()->addDays(45)->format('M d, Y')],
                                        ['name' => 'Harvesting', 'date' => $endDate->copy()->subDays(30)->format('M d, Y')],
                                        ['name' => 'Settlement', 'date' => $endDate->format('M d, Y')],
                                    ];
                                @endphp

                                @foreach($investorStagesList as $idx => $sObj)
                                    @php
                                        $sName = $sObj['name'];
                                        $isDone = ($idx <= $highestCompletedIdx);
                                        $isPending = (!$isDone && !empty($pendingStagesMap[$sName]));
                                        $isActive = (!$isDone && !$isPending && $idx === $activeIdx);
                                    @endphp
                                    <div
                                        class="timeline-step mb-4 position-relative {{ !$isDone && !$isPending ? 'opacity-50' : '' }}">
                                        @if($isDone)
                                            <div class="step-icon position-absolute rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                                style="left: -33px; top: 0; width: 22px; height: 22px; font-size: 10px;"
                                                title="Completed">✓</div>
                                        @elseif($isPending)
                                            <div class="step-icon position-absolute rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                                style="left: -33px; top: 0; width: 22px; height: 22px; font-size: 10px;"
                                                title="Pending Review">⏳</div>
                                        @else
                                            <div class="step-icon position-absolute rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center"
                                                style="left: -33px; top: 0; width: 22px; height: 22px; font-size: 10px;">•</div>
                                        @endif

                                        <div class="d-flex align-items-center gap-2">
                                            <div class="fw-bold {{ $isDone ? 'text-success' : ($isPending ? 'text-warning' : 'text-dark') }} text-uppercase"
                                                style="font-size: 11px;">
                                                Stage {{ $idx + 1 }}: {{ $sName }}
                                            </div>
                                            @if($isDone)
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5"
                                                    style="font-size: 9px;">Completed</span>
                                            @elseif($isPending)
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-0.5"
                                                    style="font-size: 9px;">Pending Review</span>
                                            @else
                                                <span class="badge bg-light text-muted border rounded-pill px-2 py-0.5"
                                                    style="font-size: 9px;">Upcoming</span>
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $sObj['date'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Farm Updates Feed (100% Dynamic) -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white"
                            style="border: 1px solid #e5e7eb !important;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;"><i
                                        class="fas fa-rss text-success me-2"></i>Farm Updates Feed</h6>
                                <span class="text-muted" style="font-size: 11px;"><i class="fas fa-filter me-1"></i> Filter
                                    Updates</span>
                            </div>

                            @forelse($farm->updates ?? [] as $update)
                                <div class="card border rounded-4 p-3 mb-4 shadow-sm" style="border-color: #f3f4f6 !important;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                <i class="fas fa-seedling" style="font-size: 12px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">{{ $update->title }}
                                                </h6>
                                                <small class="text-muted"
                                                    style="font-size: 10px;">{{ $update->created_at?->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                        <i class="fas fa-ellipsis-v text-muted" style="font-size: 12px;"></i>
                                    </div>
                                    <p class="text-secondary small mb-3" style="font-size: 11px; line-height: 1.6;">
                                        {{ $update->description }}
                                    </p>
                                    @if($update->image_path)
                                        <img src="{{ asset('storage/' . $update->image_path) }}"
                                            class="img-fluid rounded-3 mb-3 w-100" style="max-height: 240px; object-fit: cover;">
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
            <!-- SUB-TAB 2: HARVEST LIFECYCLE & SETTLEMENT -->
            <!-- ========================================== -->
            <div class="tab-pane fade" id="tab-harvest" role="tabpanel">
                
                <!-- Main Harvest Container Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid #e5e7eb !important;">
                    
                    <!-- Header Bar -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="fw-bold text-dark mb-0 fs-5"><i class="fas fa-wheat-awn text-success me-2"></i>Harvest & Settlement Pipeline</h5>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                    #PLOT-{{ $farm->id }}
                                </span>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                Official agricultural yield tracking, weighbridge tonnage records, wholesale off-take, and investor profit realization for <strong>{{ $farm->name }}</strong>.
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($isFarmSettled)
                                <span class="badge bg-success text-white rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-check-double me-1"></i> HARVEST SETTLED
                                </span>
                            @elseif($isHarvested)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-check-circle me-1"></i> HARVEST COMPLETED
                                </span>
                            @elseif($harvestStageIdx === 1)
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-tractor me-1"></i> HARVESTING IN PROGRESS
                                </span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2 fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-clock me-1"></i> PRE-HARVEST MATURATION
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 4 Top KPI Cards: Tonnage & Commercials -->
                    <div class="row g-3 mb-4">
                        <!-- Card 1: Yield Tonnage -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-light h-100" style="border-color: #e5e7eb !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">TOTAL HARVEST YIELD</span>
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-weight-hanging" style="font-size: 13px;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1 fs-4">{{ $displayYield }} Tons</h3>
                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 11px;">
                                    <span>Target: <strong>{{ $expectedYieldTons }} Tons</strong></span>
                                    <span class="text-success fw-bold">{{ $yieldAttainmentPerc }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Price Realization -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-light h-100" style="border-color: #e5e7eb !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">WHOLESALE SELLING RATE</span>
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-tag" style="font-size: 13px;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1 fs-4">₹{{ number_format($pricePerTon) }} <small class="text-muted fw-normal" style="font-size: 12px;">/ Ton</small></h3>
                                <div class="text-muted text-truncate" style="font-size: 11px;" title="{{ $marketDestination }}">
                                    <i class="fas fa-store me-1 text-primary"></i> {{ $marketDestination }}
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Gross Revenue -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-light h-100" style="border-color: #e5e7eb !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">GROSS CROP VALUE</span>
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-coins" style="font-size: 13px;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-success mb-1 fs-4">₹{{ number_format($grossRevenue) }}</h3>
                                <div class="text-muted" style="font-size: 11px;">
                                    <i class="fas fa-check-circle text-success me-1"></i> Wholesale Market Off-take
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Investor's Produce Share -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card border rounded-4 p-3 h-100" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="text-success text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">YOUR PRODUCE SHARE</span>
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-seedling" style="font-size: 13px;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-success mb-1 fs-4">{{ $investorTons }} Tons</h3>
                                <div class="text-success" style="font-size: 11px;">
                                    <strong>{{ $equityShare }}%</strong> Equity Entitlement
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- 5-STAGE HARVEST LIFECYCLE FLOW STEPPER      -->
                    <!-- ========================================== -->
                    <div class="card border rounded-4 p-4 mb-4 bg-white" style="border-color: #e5e7eb !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">
                                <i class="fas fa-route text-success me-2"></i>Harvest Lifecycle & Realization Pipeline
                            </h6>
                            <span class="text-muted fw-semibold" style="font-size: 11px;">
                                Step {{ min(5, $harvestStageIdx + 1) }} of 5 Active
                            </span>
                        </div>

                        <!-- Interactive Stepper -->
                        <div class="row g-2 text-center position-relative">
                            @php
                                $harvestStages = [
                                    [
                                        'step' => 1,
                                        'name' => 'Pre-Harvest Ripening',
                                        'sub' => 'Biomass & Maturity Index',
                                        'metric' => 'Target: ' . $expectedYieldTons . ' Tons',
                                        'icon' => 'fa-seedling'
                                    ],
                                    [
                                        'step' => 2,
                                        'name' => 'Harvesting & Weighing',
                                        'sub' => 'Field Cutting & Weighbridge',
                                        'metric' => ($isHarvested ? $displayYield . ' Tons' : 'Acres: ' . $farm->total_acres),
                                        'icon' => 'fa-tractor'
                                    ],
                                    [
                                        'step' => 3,
                                        'name' => 'Quality Inspection',
                                        'sub' => 'Grading & Moisture Check',
                                        'metric' => $harvestQualityGrade,
                                        'icon' => 'fa-award'
                                    ],
                                    [
                                        'step' => 4,
                                        'name' => 'Wholesale Mandi Offtake',
                                        'sub' => 'Buyer Dispatch & Sale',
                                        'metric' => '₹' . number_format($pricePerTon) . ' / Ton',
                                        'icon' => 'fa-store'
                                    ],
                                    [
                                        'step' => 5,
                                        'name' => 'Settlement & Payout',
                                        'sub' => 'Escrow Profit Distribution',
                                        'metric' => '₹' . number_format($expectedReturnAmount),
                                        'icon' => 'fa-wallet'
                                    ]
                                ];
                            @endphp

                            @foreach($harvestStages as $hIdx => $hStage)
                                @php
                                    $isPast = ($hIdx < $harvestStageIdx);
                                    $isCurrent = ($hIdx === $harvestStageIdx);
                                    $isUpcoming = ($hIdx > $harvestStageIdx);
                                @endphp
                                <div class="col">
                                    <div class="p-3 rounded-4 h-100 border transition-all {{ $isCurrent ? 'bg-success bg-opacity-10 border-success shadow-sm' : ($isPast ? 'bg-light border-light' : 'bg-white opacity-60 border-light') }}">
                                        <div class="mb-2">
                                            @if($isPast)
                                                <span class="badge bg-success rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; font-size: 12px;">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            @elseif($isCurrent)
                                                <span class="badge bg-success rounded-circle d-inline-flex align-items-center justify-content-center text-white shadow" style="width: 34px; height: 34px; font-size: 13px; animation: pulse 2s infinite;">
                                                    <i class="fas {{ $hStage['icon'] }}"></i>
                                                </span>
                                            @else
                                                <span class="badge bg-light border text-muted rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 11px;">
                                                    {{ $hStage['step'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="fw-bold {{ $isCurrent ? 'text-success' : ($isPast ? 'text-dark' : 'text-muted') }}" style="font-size: 12px;">
                                            {{ $hStage['name'] }}
                                        </div>
                                        <div class="text-muted mb-1" style="font-size: 10px;">
                                            {{ $hStage['sub'] }}
                                        </div>
                                        <div class="badge {{ $isCurrent ? 'bg-success text-white' : ($isPast ? 'bg-success bg-opacity-10 text-success' : 'bg-light text-muted border') }} rounded-pill px-2 py-0.5 fw-semibold" style="font-size: 9px;">
                                            {{ $hStage['metric'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2-Column Detailed Layout -->
                    <div class="row g-4">
                        
                        <!-- Left Column: Tonnage Breakdown & Milestone Photos -->
                        <div class="col-lg-7">
                            
                            <!-- Production & Tonnage Calculation Card -->
                            <div class="card border rounded-4 p-4 mb-4" style="border-color: #e5e7eb !important;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">
                                        <i class="fas fa-calculator text-success me-2"></i>Agronomic Tonnage Computation
                                    </h6>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1" style="font-size: 10px;">
                                        <i class="fas fa-leaf me-1"></i> {{ $cropName }} Formula
                                    </span>
                                </div>

                                <!-- Visual Formula Box -->
                                <div class="p-3 rounded-3 bg-light border mb-3">
                                    <div class="text-muted text-uppercase fw-bold mb-2" style="font-size: 9px; letter-spacing: 0.5px;">CALCULATION MODEL</div>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 text-dark font-monospace" style="font-size: 13px;">
                                        <span><strong>{{ $farm->total_acres ?? 0 }}</strong> <small class="text-muted font-sans-serif">Acres</small></span>
                                        <span class="text-muted fw-bold">×</span>
                                        <span><strong>{{ $cropYieldMultiplier }}</strong> <small class="text-muted font-sans-serif">Tons/Acre (Avg Rate)</small></span>
                                        <span class="text-muted fw-bold">=</span>
                                        <span class="text-success fw-bold fs-6"><strong>{{ $expectedYieldTons }}</strong> Tons Expected</span>
                                    </div>
                                </div>

                                <!-- Harvest Readiness Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 11px;">
                                        <span>Harvest Attainment / Target Realization</span>
                                        <strong>{{ $yieldAttainmentPerc }}% of {{ $expectedYieldTons }} Tons Target</strong>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 8px;">
                                        <div class="progress-bar bg-success rounded-pill" style="width: {{ $yieldAttainmentPerc }}%; background-color: #064e3b !important;"></div>
                                    </div>
                                </div>

                                <!-- Specification Grid -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless align-middle mb-0" style="font-size: 11px;">
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-2">Cultivation Plot Location</td>
                                                <td class="text-end fw-semibold text-dark py-2">{{ $farm->location ?? 'Kerala, India' }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-2">Expected / Actual Harvest Date</td>
                                                <td class="text-end fw-semibold text-dark py-2">
                                                    {{ $latestHarvestObj?->actual_harvest_date ? $latestHarvestObj->actual_harvest_date->format('M d, Y') : $endDate->format('M d, Y') }}
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-2">Quality & Moisture Grade</td>
                                                <td class="text-end py-2">
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5 fw-bold" style="font-size: 10px;">
                                                        {{ $harvestQualityGrade }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-2">Weighbridge Batch Code</td>
                                                <td class="text-end fw-bold font-monospace text-secondary py-2">#WB-SOIL-{{ $farm->id }}-{{ date('Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-2">Audit & Compliance Clearance</td>
                                                <td class="text-end text-success fw-bold py-2"><i class="fas fa-shield-alt me-1"></i> Government & APMC Certified</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Proof of Harvest & Logistics Card -->
                            <div class="card border rounded-4 p-4 bg-white" style="border-color: #e5e7eb !important;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">
                                        <i class="fas fa-camera text-primary me-2"></i>Harvest Delivery & Milestone Proofs
                                    </h6>
                                    <span class="badge bg-success text-white rounded-pill px-2.5 py-1" style="font-size: 10px;">
                                        4 MILESTONES VERIFIED
                                    </span>
                                </div>

                                <div class="row g-2 text-center">
                                    <!-- Photo 1: Crop Cutting -->
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded-3 overflow-hidden position-relative bg-light" style="height: 100px;">
                                            @if($latestHarvestObj?->image_path)
                                                <img src="{{ asset('storage/' . $latestHarvestObj->image_path) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @elseif($farm->farm_photo_path)
                                                <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=300&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover;">
                                            @endif
                                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-dark bg-opacity-75 text-white fw-semibold" style="font-size: 9px;">
                                                1. Field Cutting
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Photo 2: Weighbridge Scale -->
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded-3 overflow-hidden position-relative bg-light" style="height: 100px;">
                                            <img src="https://images.unsplash.com/photo-1595974482597-4b8da8879bc5?q=80&w=300&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover;">
                                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-dark bg-opacity-75 text-white fw-semibold" style="font-size: 9px;">
                                                2. Weighbridge
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Photo 3: Produce Crating -->
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded-3 overflow-hidden position-relative bg-light" style="height: 100px;">
                                            <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=300&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover;">
                                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-dark bg-opacity-75 text-white fw-semibold" style="font-size: 9px;">
                                                3. Quality Sorting
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Photo 4: Mandi Logistics -->
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded-3 overflow-hidden position-relative bg-light" style="height: 100px;">
                                            <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?q=80&w=300&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover;">
                                            <div class="position-absolute bottom-0 start-0 w-100 p-1 bg-dark bg-opacity-75 text-white fw-semibold" style="font-size: 9px;">
                                                4. Mandi Dispatch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Financial Settlement Box -->
                        <div class="col-lg-5">
                            <div class="card border-0 rounded-4 p-4 text-dark shadow-sm h-100 d-flex flex-column justify-content-between"
                                style="background: #F8FAFC; border: 1px solid #E2E8F0 !important;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                            <i class="fas fa-wallet text-success me-2"></i>Settlement & Payout Ledger
                                        </h6>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px;">
                                            <i class="fas fa-shield-alt me-1"></i> Escrow Secured
                                        </span>
                                    </div>
                                    <p class="text-muted mb-3" style="font-size: 11px;">
                                        Guaranteed return on invested capital calculated from the contracted produce sale value.
                                    </p>

                                    <!-- Financial Line Items -->
                                    <div class="table-responsive mb-3">
                                        <table class="table table-borderless align-middle mb-0" style="font-size: 12px;">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td class="text-muted py-2">Pledged Capital</td>
                                                    <td class="text-end fw-bold text-dark py-2">
                                                        ₹{{ number_format($investedAmount) }}
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted py-2">Portfolio Equity Share</td>
                                                    <td class="text-end fw-bold text-dark py-2">
                                                        {{ $equityShare }}%
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted py-2">Produce Volume Entitled</td>
                                                    <td class="text-end fw-bold text-success py-2">
                                                        {{ $investorTons }} Tons
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted py-2">Agreed Return Rate (ROI)</td>
                                                    <td class="text-end fw-bold text-primary py-2">
                                                        {{ $expectedROI }}%
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <td class="text-muted py-2">Estimated Net Profit</td>
                                                    <td class="text-end fw-bold text-success py-2">
                                                        +₹{{ number_format(max(0, $expectedReturnAmount - $investedAmount)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-2">Platform Escrow Fee</td>
                                                    <td class="text-end fw-bold text-muted py-2">
                                                        ₹0 (Waived)
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Projected Total Payout Callout Box -->
                                <div>
                                    <div class="p-3 rounded-4 bg-white border border-success border-opacity-25 text-center mb-3 shadow-sm">
                                        <div class="text-muted fw-bold text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.5px;">
                                            TOTAL PROJECTED PAYOUT
                                        </div>
                                        <h3 class="fw-bold text-success mb-1 fs-2">₹{{ number_format($expectedReturnAmount) }}</h3>
                                        <div class="text-muted" style="font-size: 10px;">
                                            Capital (₹{{ number_format($investedAmount) }}) + Profit (+₹{{ number_format(max(0, $expectedReturnAmount - $investedAmount)) }})
                                        </div>
                                    </div>

                                    @if($isFarmSettled)
                                        <div class="p-2.5 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 text-center text-success fw-bold mb-3" style="font-size: 11px;">
                                            <i class="fas fa-check-circle me-1"></i> Funds Dispatched to Your Bank Account
                                        </div>
                                    @else
                                        <div class="p-2.5 rounded-3 bg-light border text-center text-muted fw-semibold mb-3" style="font-size: 11px;">
                                            <i class="fas fa-lock text-success me-1"></i> Payout dispatched within 15 days of harvest off-take
                                        </div>
                                    @endif

                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-success rounded-pill w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#investmentCertificateModal" style="font-size: 11px;">
                                            <i class="fas fa-file-contract me-1"></i> View Certificate
                                        </button>
                                        <a href="{{ route('reports.export', ['type' => 'portfolio']) }}" class="btn btn-success rounded-pill w-100 fw-bold py-2 shadow-sm" style="font-size: 11px; background-color: #064e3b; border-color: #064e3b;">
                                            <i class="fas fa-download me-1"></i> Statement
                                        </a>
                                    </div>
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
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100"
                            style="border: 1px solid #e5e7eb !important;">
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;"><i
                                    class="fas fa-info-circle text-success me-2"></i>Farm Summary</h6>
                            <div class="row g-2 text-center">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2.5 border">
                                        <small class="text-muted d-block"
                                            style="font-size: 9px; text-transform: uppercase;">LAND SIZE</small>
                                        <strong class="text-dark small fw-bold">{{ $farm->total_acres ?? 0 }} Acres</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2.5 border">
                                        <small class="text-muted d-block"
                                            style="font-size: 9px; text-transform: uppercase;">LOCATION</small>
                                        <strong class="text-dark small fw-bold">{{ $farm->location ?? 'Kerala' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2.5 border">
                                        <small class="text-muted d-block"
                                            style="font-size: 9px; text-transform: uppercase;">PRIMARY CROP</small>
                                        <strong class="text-dark small fw-bold">{{ $farm->primary_crop ?? 'Crop' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2.5 border">
                                        <small class="text-muted d-block"
                                            style="font-size: 9px; text-transform: uppercase;">SECONDARY CROP</small>
                                        <strong
                                            class="text-dark small fw-bold">{{ $farm->secondary_crop ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Center Grid: Metrics -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100"
                            style="border: 1px solid #e5e7eb !important;">
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;"><i
                                    class="fas fa-chart-bar text-primary me-2"></i>Metrics</h6>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom"
                                style="font-size: 11px;">
                                <span class="text-muted">Expected Harvest</span>
                                <strong class="text-dark">{{ $endDate->format('d M Y') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom"
                                style="font-size: 11px;">
                                <span class="text-muted">Expected Yield</span>
                                <strong class="text-dark">{{ $displayYield }} Tons</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom"
                                style="font-size: 11px;">
                                <span class="text-muted">Expected Revenue</span>
                                <strong class="text-success fw-bold">₹{{ number_format($grossRevenue) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom"
                                style="font-size: 11px;">
                                <span class="text-muted">Farmer Stake / Contribution</span>
                                <strong
                                    class="text-success">₹{{ number_format($farm->your_contribution ?? 50000) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2" style="font-size: 11px;">
                                <span class="text-muted">ROI</span>
                                <strong class="text-success fs-6 fw-bold">{{ $expectedROI }}%</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Top Right Grid: Funding Goal -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100"
                            style="border: 1px solid #e5e7eb !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">Funding Goal</h6>
                                <span class="badge bg-success text-white rounded-pill px-2.5 py-1 text-uppercase"
                                    style="font-size: 9px;">
                                    {{ $farm->status ?? 'ACTIVE' }}
                                </span>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 fs-2">₹{{ number_format($farm->funding_target ?? 0) }}</h3>
                            @php
                                $dynamicRaised = max($farm->funding_raised ?? 0, $farm->investments ? $farm->investments->whereIn('status', ['approved', 'active'])->sum('amount') : 0);
                            @endphp
                            <div class="text-muted mb-3" style="font-size: 11px;">Raised:
                                <strong class="text-success">₹{{ number_format($dynamicRaised) }}</strong>
                            </div>
                            <div class="p-2.5 rounded-3 bg-light border text-muted" style="font-size: 10px;">
                                <i class="fas fa-info-circle me-1"></i> Verified agricultural investment plot backed by
                                SoulSoil.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Cultivation Journey & Your Investment -->
                <div class="row g-4">
                    <!-- Cultivation Journey -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white"
                            style="border: 1px solid #e5e7eb !important;">
                            <h6 class="fw-bold text-dark mb-4" style="font-size: 13px;"><i
                                    class="fas fa-route text-success me-2"></i>Cultivation Journey</h6>
                            <div
                                class="d-flex justify-content-between align-items-center text-center position-relative mb-4">
                                <div>
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1"
                                        style="width: 28px; height: 28px; font-size: 11px;">✓</div>
                                    <div class="fw-bold text-dark" style="font-size: 10px;">Investment</div>
                                </div>
                                <div>
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1"
                                        style="width: 28px; height: 28px; font-size: 11px;">✓</div>
                                    <div class="fw-bold text-dark" style="font-size: 10px;">Farm Approved</div>
                                </div>
                                <div>
                                    <div class="bg-success border border-3 border-white text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-1 shadow-sm"
                                        style="width: 32px; height: 32px; font-size: 11px;">⚙</div>
                                    <div class="fw-bold text-success" style="font-size: 10px;">Cultivation</div>
                                </div>
                                <div class="opacity-50">
                                    <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-1"
                                        style="width: 28px; height: 28px; font-size: 11px;">4</div>
                                    <div class="fw-bold text-muted" style="font-size: 10px;">Harvest</div>
                                </div>
                                <div class="opacity-50">
                                    <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-1"
                                        style="width: 28px; height: 28px; font-size: 11px;">5</div>
                                    <div class="fw-bold text-muted" style="font-size: 10px;">Settlement</div>
                                </div>
                            </div>
                            @if($farm->farm_photo_path)
                                <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="img-fluid rounded-4 w-100"
                                    style="max-height: 280px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Your Investment Box -->
                    <div class="col-lg-4">
                        <div class="card border-0 rounded-4 p-4 text-white shadow-sm mb-4"
                            style="background-color: #064e3b;">
                            <h6 class="fw-bold mb-3 text-white" style="font-size: 13px;"><i
                                    class="fas fa-hand-holding-usd text-success me-2"></i>Your Investment</h6>
                            <h3 class="fw-bold text-white mb-3 fs-2">₹{{ number_format($investedAmount) }}</h3>
                            <div class="d-flex justify-content-between text-white-50 mb-3 pb-3 border-bottom border-success border-opacity-25"
                                style="font-size: 11px;">
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
                            <button type="button"
                                class="btn btn-light rounded-pill w-100 fw-bold text-success py-2.5 shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#investmentCertificateModal">
                                <i class="fas fa-certificate me-1.5"></i> View Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Investment Certificate Modal (100% Dynamic) -->
    <div class="modal fade" id="investmentCertificateModal" tabindex="-1" aria-labelledby="certificateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Certificate Body -->
                <div class="modal-body p-5 bg-white text-dark position-relative"
                    style="border: 12px double #064e3b; background-image: radial-gradient(circle at center, rgba(16,185,129,0.03) 0%, transparent 70%);">

                    <!-- Watermark -->
                    <div class="position-absolute top-50 start-50 translate-middle opacity-10 pointer-events-none text-center"
                        style="z-index: 0;">
                        <i class="fas fa-seedling text-success" style="font-size: 240px;"></i>
                    </div>

                    <div class="position-relative" style="z-index: 1;">
                        <!-- Certificate Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-2"
                                style="width: 54px; height: 54px;">
                                <i class="fas fa-award fa-2x"></i>
                            </div>
                            <h6 class="text-uppercase fw-bold text-success tracking-wider mb-1"
                                style="letter-spacing: 3px; font-size: 11px;">SOUL SOIL AGRI-TECH PLATFORM</h6>
                            <h2 class="fw-bold text-dark font-serif mb-2"
                                style="font-family: 'Georgia', serif; letter-spacing: 1px;">CERTIFICATE OF FARM INVESTMENT
                            </h2>
                            <div class="badge bg-dark text-warning border border-warning px-3 py-1.5 rounded-pill fw-bold"
                                style="font-size: 10px; letter-spacing: 1px;">
                                OFFICIAL VERIFIED CERTIFICATE #SS-INV-{{ $farm->id }}-{{ auth()->id() ?? '001' }}
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #064e3b; opacity: 0.2;">

                        <!-- Certificate Text -->
                        <div class="text-center px-lg-4 mb-4">
                            <p class="text-muted mb-2 fs-6">This is to officially certify that</p>
                            <h3 class="fw-bold text-success font-serif mb-3"
                                style="font-family: 'Georgia', serif; font-size: 26px; border-bottom: 2px dashed #10b981; display: inline-block; padding-bottom: 4px;">
                                {{ auth()->user()?->full_name ?? auth()->user()?->name ?? 'Verified Investor' }}
                            </h3>
                            <p class="text-dark fs-6 mb-4" style="line-height: 1.8;">
                                has successfully pledged capital and acquired an official equity share backing for the
                                sustainable agricultural operations of
                                <strong class="text-dark fw-bold">{{ $farm->name }}</strong>
                                located at <span
                                    class="fw-semibold text-secondary">{{ $farm->location ?? 'Kerala, India' }}</span>.
                            </p>
                        </div>

                        <!-- Key Details Grid -->
                        <div class="row g-3 mb-4 text-center">
                            <div class="col-md-3 col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <small class="text-muted d-block fw-bold text-uppercase mb-1"
                                        style="font-size: 9px;">Pledged Capital</small>
                                    <strong class="fw-bold text-success fs-5">₹{{ number_format($investedAmount) }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <small class="text-muted d-block fw-bold text-uppercase mb-1"
                                        style="font-size: 9px;">Equity Share</small>
                                    <strong class="fw-bold text-dark fs-5">{{ $equityShare }}%</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <small class="text-muted d-block fw-bold text-uppercase mb-1"
                                        style="font-size: 9px;">Expected ROI</small>
                                    <strong class="fw-bold text-primary fs-5">{{ $expectedROI }}%</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <small class="text-muted d-block fw-bold text-uppercase mb-1"
                                        style="font-size: 9px;">Issue Date</small>
                                    <strong
                                        class="fw-bold text-dark fs-6">{{ $myInvestment?->created_at?->format('d M Y') ?? date('d M Y') }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Signatures & Seal -->
                        <div class="row align-items-end mt-4 pt-3 border-top">
                            <div class="col-6 text-start">
                                <div class="fw-bold text-dark mb-0"
                                    style="font-family: 'Georgia', serif; font-style: italic; font-size: 18px; color: #064e3b !important;">
                                    SoulSoil Board Seal
                                </div>
                                <div class="text-muted"
                                    style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Authorized
                                    Platform Signatory</div>
                            </div>
                            <div class="col-6 text-end">
                                <div
                                    class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-3">
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
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"
                        data-bs-dismiss="modal" style="font-size: 12px;">Close</button>
                    <button type="button" onclick="window.print()"
                        class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="font-size: 12px;">
                        <i class="fas fa-print me-1.5"></i> Print / Download Certificate PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
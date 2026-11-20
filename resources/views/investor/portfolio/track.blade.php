@extends('layouts.admin')

@section('page-title', 'Track Investment - ' . ($farm->name ?? 'Farm Plot'))

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.9);
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.2);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(0,0,0,0.1);
            --timeline-active: #3b82f6;
            --timeline-done: #10b981;
        }

        .track-wrapper {
            background-color: var(--primary-bg);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(16, 185, 129, 0.05), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(59, 130, 246, 0.05), transparent 25%);
            min-height: 100vh;
            margin: -1.5rem; /* Offset any padding from admin layout */
            padding: 1.5rem;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Hero Section */
        .track-hero {
            position: relative;
            padding: 3rem 0;
            margin-bottom: 2rem;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .hero-bg {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url({{ $farm->farm_photo_path ? asset('storage/' . $farm->farm_photo_path) : 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1920&q=80' }});
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 0 15px var(--accent-glow);
        }

        /* Financial Metrics Grid */
        .metric-box {
            padding: 1.5rem;
            border-radius: 16px;
            background: rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        
        .metric-box:hover {
            transform: translateY(-5px);
            background: rgba(0,0,0,0.06);
            border-color: rgba(0,0,0,0.1);
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 1rem;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .metric-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Live Timeline Stepper */
        .timeline-container {
            padding: 2rem 0;
            position: relative;
        }

        .timeline-track {
            position: absolute;
            top: 50%;
            left: 5%;
            right: 5%;
            height: 4px;
            background: rgba(0,0,0,0.1);
            transform: translateY(-50%);
            border-radius: 2px;
            z-index: 0;
        }

        .timeline-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--timeline-active));
            border-radius: 2px;
            box-shadow: 0 0 10px var(--accent-glow);
            transition: width 1s ease-in-out;
        }

        .timeline-steps {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
        }

        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 120px;
            text-align: center;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-bg);
            border: 3px solid rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .step-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .timeline-step.done .step-circle {
            background: var(--timeline-done);
            border-color: var(--timeline-done);
            color: var(--text-main);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);
        }

        .timeline-step.done .step-label {
            color: var(--text-main);
        }

        .timeline-step.active .step-circle {
            background: var(--timeline-active);
            border-color: var(--timeline-active);
            color: var(--text-main);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
            animation: pulse 2s infinite;
        }

        .timeline-step.active .step-label {
            color: var(--timeline-active);
            font-weight: 700;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }

        /* Farmer Updates Gallery */
        .update-card {
            border-radius: 16px;
            overflow: hidden;
            background: rgba(0,0,0,0.02);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }

        .update-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0,0,0,0.15);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .update-img-wrapper {
            position: relative;
            padding-top: 60%;
            overflow: hidden;
        }

        .update-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .update-card:hover .update-img {
            transform: scale(1.05);
        }

        .update-date-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            color: var(--text-main);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(0,0,0,0.2);
        }

        .update-content {
            padding: 1.25rem;
        }

        /* Settlement Receipt */
        .receipt-box {
            background: linear-gradient(145deg, rgba(16, 185, 129, 0.1) 0%, rgba(30, 41, 59, 0.4) 100%);
            border: 1px dashed var(--accent);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .receipt-box::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 150px; height: 150px;
            background: var(--accent);
            opacity: 0.1;
            border-radius: 50%;
            filter: blur(40px);
        }

    </style>
@endsection

@section('content')
<div class="track-wrapper">

<!-- Navbar placeholder (use your app's existing nav if applicable) -->
<nav class="navbar navbar-light bg-transparent py-4">
    <div class="container text-center d-block">
        <a href="{{ auth()->user()?->farmer ? route('admin.dashboard') . '#portfolio' : route('admin.dashboard') . '#investments' }}" class="btn btn-outline-dark rounded-pill px-4 position-absolute start-0 ms-4 shadow-sm" style="border-color: rgba(0,0,0,0.2); font-size: 13px;">
            <i class="fas fa-arrow-left me-2"></i> Back to Portfolio
        </a>
        <h4 class="mb-0 fw-bold tracking-wider" style="color: rgba(0,0,0,0.8); letter-spacing: 2px;">SOUL SOIL <span style="color: var(--accent);">TRACKER</span></h4>
    </div>
</nav>

<!-- Hero Section -->
<section class="track-hero">
    <div class="hero-bg"></div>
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="status-badge mb-3" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4);">
                    <i class="fas fa-sync-alt fa-spin me-2"></i> LIVE TRACKING
                </span>
                <h1 class="display-4 fw-bold mb-2 text-dark">{{ $farm->name ?? 'Riverside Paddy Farm' }}</h1>
                <p class="fs-5 mb-4" style="color: var(--text-muted);"><i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $farm->location ?? 'Kerala, India' }} &nbsp;|&nbsp; <i class="fas fa-user-check me-2 text-success"></i>Farmer: {{ $farm->farmer->full_name ?? 'Remesh' }}</p>
                
                <div class="d-flex gap-3 flex-wrap">
                    <span class="badge bg-white border border-secondary p-2 px-3 text-dark">Crop: {{ $farm->crop_type ?? 'Rice' }}</span>
                    <span class="badge bg-white border border-secondary p-2 px-3 text-dark">Area: {{ $farm->total_area ?? '5 Acres' }}</span>
                </div>
            </div>
            <div class="col-lg-4 text-end mt-4 mt-lg-0">
                <div class="glass-card p-4 text-center">
                    <p class="text-uppercase text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 1px;">Current Stage</p>
                    <h3 class="fw-bold mb-3" style="color: var(--timeline-active);">{{ $investmentDetails['status'] }}</h3>
                    <div class="bg-white rounded-pill p-2 d-inline-flex align-items-center gap-2 border shadow-sm" style="border-color: rgba(0,0,0,0.1) !important;">
                        <i class="fas fa-{{ $investmentDetails['status'] === 'Settled' ? 'check-circle text-success' : 'clock text-warning' }} ms-2"></i>
                        <span class="fw-bold pe-2">{{ $investmentDetails['status'] === 'Settled' ? 'Cycle Completed & Settled' : $investmentDetails['timeline']['days_to_harvest'] . ' Days to Harvest' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container pb-5">
    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($investmentDetails['is_pending'] ?? false)
        <div class="alert alert-warning p-4 rounded-3 border-0 shadow-sm d-flex gap-3 align-items-center mb-5 text-dark" style="background-color: #fffbeb;">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                <i class="fas fa-hourglass-half fs-4" style="color: #854d0e;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #854d0e;">Investment Awaiting Verification</h6>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Your investment transaction is currently <strong>pending approval</strong> by the platform administrator. Once payment details are verified, live tracking and farm updates will activate.
                </p>
            </div>
        </div>
    @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
    
    <!-- Financial Metrics Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
            <div class="metric-box text-center">
                <div class="metric-icon mx-auto bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="metric-value text-dark">₹{{ number_format($investmentDetails['capital_committed']) }}</div>
                <div class="metric-label">Capital Committed</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-box text-center">
                <div class="metric-icon mx-auto bg-info bg-opacity-10 text-info">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="metric-value text-dark">{{ $investmentDetails['equity_share'] }}</div>
                <div class="metric-label">Your Equity Share</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-box text-center">
                <div class="metric-icon mx-auto bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="metric-value text-dark">{{ $investmentDetails['expected_roi'] }}</div>
                <div class="metric-label">Expected ROI</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-box text-center" style="border-color: rgba(16, 185, 129, 0.3); background: rgba(16, 185, 129, 0.05);">
                <div class="metric-icon mx-auto bg-success bg-opacity-10 text-success">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="metric-value text-success">₹{{ number_format($investmentDetails['expected_returns']) }}</div>
                <div class="metric-label text-success">Expected Payout</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Project Overview -->
        <div class="col-lg-8">
            <div class="glass-card p-5 h-100">
                <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-info-circle me-2 text-primary"></i> Farm Details</h4>
                <div class="row mb-4 g-3">
                    <div class="col-sm-3 border-end" style="border-color: var(--border-color) !important;">
                        <span class="d-block text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Primary Crop</span>
                        <span class="fw-bold fs-6 text-dark">{{ $farm->primary_crop ?? 'Spices' }}</span>
                    </div>
                    <div class="col-sm-3 border-end ps-sm-3" style="border-color: var(--border-color) !important;">
                        <span class="d-block text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Total Area</span>
                        <span class="fw-bold fs-6 text-dark">{{ $farm->total_acres ?? '0.27' }} Acres</span>
                    </div>
                    <div class="col-sm-3 border-end ps-sm-3" style="border-color: var(--border-color) !important;">
                        <span class="d-block text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Total Funding Target</span>
                        <span class="fw-bold fs-6 text-dark">₹{{ number_format($farm->funding_target ?? 280640) }}</span>
                    </div>
                    <div class="col-sm-3 ps-sm-3">
                        <span class="d-block text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Funding Raised</span>
                        <span class="fw-bold fs-6 text-success">₹{{ number_format($farm->funding_raised ?? 20000) }}</span>
                    </div>
                </div>
                <p class="text-muted" style="font-size: 15px; line-height: 1.7;">
                    The {{ $farm->name ?? 'Riverside Paddy Farm' }} project focuses on high-yield, sustainable agricultural practices. By leveraging smart farming IoT technologies, we optimize water usage and monitor crop health in real time. This ensures not only a premium quality harvest but also minimizes risks associated with traditional farming. 
                </p>
                <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.7;">
                    The funds raised will be directly utilized for premium seed procurement, advanced drip irrigation setup, and organic fertilizers, ensuring the highest possible return on your investment upon the successful harvest.
                </p>
            </div>
        </div>

        <!-- Harvest Projections & Realization -->
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-tractor me-2 text-warning"></i> Harvest & Realization</h5>
                <div class="p-4 rounded-4 mb-3" style="background: rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.08);">
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Harvest Date</span>
                        <span class="fw-bold text-dark" style="font-size: 13px;">{{ $investmentDetails['timeline']['expected_harvest'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Harvest Yield</span>
                        <span class="fw-bold text-success" style="font-size: 13px;">
                            @if(!empty($investmentDetails['latest_harvest']) && (float)($investmentDetails['latest_harvest']->actual_yield ?? 0) > 0)
                                {{ number_format($investmentDetails['latest_harvest']->actual_yield, 2) }} Tons <small class="badge bg-success bg-opacity-10 text-success p-1 ms-1">Actual</small>
                            @elseif(!empty($investmentDetails['latest_harvest']) && (float)($investmentDetails['latest_harvest']->estimated_yield ?? 0) > 0)
                                {{ number_format($investmentDetails['latest_harvest']->estimated_yield, 2) }} Tons <small class="text-muted">(Target)</small>
                            @else
                                {{ number_format(($farm->total_acres ?? 2.5) * 2.8, 1) }} Tons <small class="text-muted">(Target)</small>
                            @endif
                        </span>
                    </div>
                    @if(!empty($investmentDetails['latest_harvest']?->quality_grade))
                        <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                            <span class="text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Quality Grade</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11px;">{{ $investmentDetails['latest_harvest']->quality_grade }}</span>
                        </div>
                    @endif
                    @if(!empty($investmentDetails['latest_harvest']?->market_name))
                        <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                            <span class="text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Wholesale Market</span>
                            <span class="fw-semibold text-dark" style="font-size: 12px;">{{ $investmentDetails['latest_harvest']->market_name }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Gross Revenue</span>
                        <strong class="text-dark" style="font-size: 14px;">₹{{ number_format($investmentDetails['revenue_earned'] ?? 0) }}</strong>
                    </div>
                </div>
                <p class="text-muted flex-grow-1" style="font-size: 12px; line-height: 1.6;">
                    Produce is sold to verified agricultural APMC markets and institutional off-takers with guaranteed settlements. Returns are distributed per equity share upon cycle closure.
                </p>
                <div class="d-flex gap-2 mt-2">
                    <button class="btn btn-outline-success w-100 rounded-pill fw-semibold py-2" data-bs-toggle="modal" data-bs-target="#contractModal" style="border-color: rgba(16, 185, 129, 0.5); font-size: 11px;">
                        <i class="fas fa-file-contract me-1"></i> Contract Terms
                    </button>
                    @if(auth()->user()?->is_admin || (auth()->user()?->farmer && (int)auth()->user()->farmer->id === (int)$farm->farmer_id))
                        <a href="{{ route('admin.farms.show', $farm->id) }}" class="btn btn-dark rounded-pill fw-semibold py-2 px-3 text-nowrap" style="font-size: 11px;">
                            <i class="fas fa-cog me-1"></i> Farm Details
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Live Timeline -->
    <div class="glass-card p-5 mb-5">
        <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-tasks me-2 text-primary"></i> Cultivation Timeline</h4>
        
        <?php
            $stages = ['Land Prep', 'Sowing', 'Growing', 'Harvesting', 'Settled'];
            $currentStatus = $investmentDetails['status'];
            $currentIndex = array_search($currentStatus, $stages);
            if ($currentIndex === false) {
                $currentIndex = ($currentStatus === 'Pending Approval') ? 0 : 2;
            }
            $progressPercent = $currentStatus === 'Settled' ? 100 : (($currentIndex / (count($stages) - 1)) * 100);
        ?>

        <div class="timeline-container mt-5 mb-3">
            <div class="timeline-track">
                <div class="timeline-progress" style="width: {{ $progressPercent }}%;"></div>
            </div>
            <div class="timeline-steps">
                @foreach($stages as $index => $stage)
                    <?php
                        $stateClass = '';
                        $icon = 'fas fa-check';
                        if ($index < $currentIndex || ($currentStatus === 'Settled' && $index <= $currentIndex)) {
                            $stateClass = 'done';
                            $icon = 'fas fa-check';
                        } elseif ($index == $currentIndex) {
                            $stateClass = 'active';
                            $icon = 'fas fa-spinner fa-spin';
                        } else {
                            $icon = 'fas fa-circle';
                        }
                    ?>
                    <div class="timeline-step {{ $stateClass }}">
                        <div class="step-circle">
                            <i class="{{ $icon }}" style="{{ $index > $currentIndex && $currentStatus !== 'Settled' ? 'font-size: 8px;' : '' }}"></i>
                        </div>
                        <div class="step-label">{{ $stage }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4 px-3 text-muted small fw-bold">
            <div><i class="fas fa-play-circle me-1 text-primary"></i> Started: {{ $investmentDetails['timeline']['start_date'] }}</div>
            <div><i class="fas fa-flag-checkered me-1 text-success"></i> Est. Harvest: {{ $investmentDetails['timeline']['expected_harvest'] }}</div>
        </div>
    </div>

    <!-- Conditional Payout Section (If Settled / Completed) -->
    @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($investmentDetails['is_settled'])
        <div class="receipt-box mb-5 animate-fade-in shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
                            <i class="fas fa-check-double me-1"></i> SETTLEMENT COMPLETED
                        </span>
                        <span class="text-muted small">Recorded in Ledger</span>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Harvest Cycle Finalized & Settled</h3>
                    <p class="text-muted mb-4" style="font-size: 13px;">The produce has been harvested and sold at wholesale market. Capital return and yield dividends have been finalized for this cycle.</p>
                    
                    <div class="d-flex gap-4 flex-wrap">
                        <div>
                            <span class="d-block text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Gross Produce Revenue</span>
                            <h4 class="text-dark fw-bold mb-0" style="font-size: 18px;">₹{{ number_format($investmentDetails['revenue_earned'] ?? 0) }}</h4>
                        </div>
                        <div style="border-left: 1px solid rgba(0,0,0,0.1); padding-left: 1.5rem;">
                            <span class="d-block text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Net Cycle Profit</span>
                            <h4 class="{{ ($investmentDetails['net_profit'] ?? 0) < 0 ? 'text-danger' : 'text-success' }} fw-bold mb-0" style="font-size: 18px;">
                                {{ ($investmentDetails['net_profit'] ?? 0) < 0 ? '-₹' . number_format(abs($investmentDetails['net_profit'])) : '₹' . number_format($investmentDetails['net_profit'] ?? 0) }}
                            </h4>
                        </div>
                        <div style="border-left: 1px solid rgba(0,0,0,0.1); padding-left: 1.5rem;">
                            <span class="d-block text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Total Dispatched Payout</span>
                            <h4 class="text-success fw-bold mb-0" style="font-size: 20px;">₹{{ number_format($investmentDetails['actual_payout'] ?? $investmentDetails['capital_committed']) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-end mt-4 mt-md-0">
                    <a href="{{ route('reports.export', ['type' => 'harvest', 'farm_id' => $farm->id]) }}" class="btn btn-lg btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #064e3b; border-color: #064e3b; font-size: 13px;">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Download Settlement Statement (.csv)
                    </a>
                </div>
            </div>
        </div>
    @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif

    <!-- Farmer Updates Gallery -->
    <h4 class="fw-bold mb-4 mt-5 text-dark"><i class="fas fa-camera-retro me-2 text-primary"></i> Farmer's Live Updates</h4>
    <p class="mb-4" style="color: var(--text-muted);">View recent photos and field logs uploaded directly by the farmer.</p>
    
    <div class="row g-4">
        @forelse($investmentDetails['updates'] as $update)
            <div class="col-md-4">
                <div class="update-card bg-white shadow-sm border rounded-4 overflow-hidden h-100">
                    <div class="update-img-wrapper" style="position: relative; height: 190px; overflow: hidden; background: #f3f4f6;">
                        <img src="{{ !empty($update['image']) ? $update['image'] : 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=800&q=80' }}" class="update-img w-100 h-100" style="object-fit: cover;" alt="Farm Update">
                        <div class="update-date-badge shadow-sm" style="position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.65); color: #fff; font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                            <i class="far fa-calendar-alt me-1"></i> {{ $update['date'] }}
                        </div>
                        @if(($update['type'] ?? '') === 'harvest_milestone')
                            <div style="position: absolute; bottom: 12px; left: 12px;">
                                <span class="badge bg-success text-white px-2.5 py-1 rounded-pill shadow-sm" style="font-size: 10px;">
                                    <i class="fas fa-check-circle me-1"></i> Harvest Milestone
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="update-content p-3.5">
                        <h6 class="fw-bold text-dark mb-1.5" style="font-size: 14px;">{{ $update['title'] }}</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 12px;">{{ $update['description'] }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 glass-card">
                <i class="fas fa-image fa-3x text-muted mb-3 opacity-50"></i>
                <h5 class="text-dark">No updates yet</h5>
                <p style="color: var(--text-muted);">The farmer hasn't uploaded any photos yet. Check back soon!</p>
            </div>
        @endforelse
    </div>

</div>
</div>

<!-- Contract Modal -->
<div class="modal fade" id="contractModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; background-color: var(--card-bg); backdrop-filter: blur(12px);">
            <div class="modal-header border-0 bg-success text-dark" style="border-radius: 16px 16px 0 0;">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-contract me-2"></i> Harvest Contract</h5>
                <button type="button" class="btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-lock text-muted mb-3" style="font-size: 40px; opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark">Confidential Document</h5>
                <p class="text-muted" style="font-size: 14px;">The full institutional buyer contract and guaranteed price terms will be revealed and securely signed after your investment commitment is verified.</p>
                @if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if BLOCK]><![endif]-->@endif@if($farm->lease_agreement_path ?? false)
                    <a href="{{ asset('storage/' . $farm->lease_agreement_path) }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 mt-2">View Public Land Lease</a>
                @endif@if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent())<!--[if ENDBLOCK]><![endif]-->@endif
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center pb-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" style="background-color: rgba(0,0,0,0.1); border: none; color: var(--text-main);">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     INVESTMENT SUCCESSFUL POPUP MODAL (WITH ROTATING 3D POP & SPIN CHECKMARK)
     ========================================================================= -->
<div class="modal fade" id="investmentSuccessModal" tabindex="-1" aria-labelledby="investmentSuccessModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg position-relative" style="border-radius: 28px; overflow: hidden; background: #FFFFFF;">
            
            <!-- Confetti Graphic Header Banner -->
            <div class="position-relative w-100 text-center py-4 px-4"
                style="background: linear-gradient(180deg, #F0FDF4 0%, #FFFFFF 100%); min-height: 140px;">
                
                <!-- Confetti particles overlay with floating animations -->
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-75 pointer-events-none" style="overflow: hidden;">
                    <span class="confetti-particle-1" style="position: absolute; top: 15%; left: 12%; width: 9px; height: 9px; background: #10B981; border-radius: 2px;"></span>
                    <span class="confetti-particle-2" style="position: absolute; top: 25%; left: 22%; width: 7px; height: 11px; background: #F59E0B; border-radius: 2px;"></span>
                    <span class="confetti-particle-1" style="position: absolute; top: 18%; left: 38%; width: 10px; height: 7px; background: #3B82F6; border-radius: 2px;"></span>
                    <span class="confetti-particle-2" style="position: absolute; top: 12%; right: 28%; width: 8px; height: 8px; background: #10B981; border-radius: 2px;"></span>
                    <span class="confetti-particle-1" style="position: absolute; top: 22%; right: 18%; width: 11px; height: 7px; background: #F59E0B; border-radius: 2px;"></span>
                    <span class="confetti-particle-2" style="position: absolute; top: 15%; right: 10%; width: 9px; height: 9px; background: #10B981; border-radius: 2px;"></span>
                </div>

                <!-- Green Checkmark Icon Circle with Spin & Pop -->
                <div class="mx-auto d-flex align-items-center justify-content-center mb-3 shadow-sm animated-check-circle"
                    style="width: 72px; height: 72px; background-color: #D1FAE5; border-radius: 50%;">
                    <div class="d-flex align-items-center justify-content-center text-white fw-bold"
                        style="width: 52px; height: 52px; background-color: #10B981; border-radius: 50%; font-size: 26px;">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <h3 class="fw-bold text-dark mb-1" style="font-family: 'Inter', sans-serif; letter-spacing: -0.5px;">Investment Successful!</h3>
                <p class="text-secondary small mb-0 fs-6">Your stewardship in sustainable agriculture has begun.</p>
            </div>

            <!-- Modal Body: Receipt Card -->
            <div class="modal-body px-4 pt-2 pb-4">
                <div class="p-4 rounded-4 bg-white border shadow-sm mx-auto mb-4" style="max-width: 620px; border-color: #E5E7EB !important; border-radius: 20px;">
                    
                    <!-- Header Row: Investment ID & Confirmed Badge -->
                    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                        <div>
                            <span class="d-block text-muted text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.8px;">Investment ID</span>
                            <strong class="text-dark fs-6" style="letter-spacing: 0.5px;">{{ session('investment_id', 'SS-INV-' . str_pad($farm->id ?? 1, 4, '0', STR_PAD_LEFT)) }}</strong>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
                            CONFIRMED
                        </span>
                    </div>

                    <!-- 2x2 Receipt Grid -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2.5 bg-light text-success rounded-3 border">
                                    <i class="fas fa-seedling fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Farm Name</small>
                                    <strong class="text-dark fw-bold" style="font-size: 14px;">{{ $farm->name ?? 'Highland Orchard' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2.5 bg-light text-success rounded-3 border">
                                    <i class="fas fa-wallet fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Amount Invested</small>
                                    <strong class="text-dark fw-bold" style="font-size: 14px;">₹{{ number_format(session('invest_amount', $investmentDetails['capital_committed'] ?? 50000)) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2.5 bg-light text-success rounded-3 border">
                                    <i class="fas fa-calendar-alt fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Expected Harvest</small>
                                    <strong class="text-dark fw-bold" style="font-size: 14px;">{{ session('expected_harvest', $investmentDetails['timeline']['expected_harvest'] ?? 'October 2026') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2.5 bg-light text-success rounded-3 border">
                                    <i class="fas fa-credit-card fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Payment Method</small>
                                    <strong class="text-dark fw-bold" style="font-size: 14px;">{{ session('pay_method', 'UPI / Digital Wallet') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notice Banner -->
                    <div class="p-2.5 rounded-3 d-flex align-items-center gap-2 text-success small border border-success border-opacity-25" style="background-color: #ECFDF5; font-size: 12px;">
                        <i class="fas fa-info-circle fs-6"></i>
                        <span>A confirmation email has been sent. You can track cultivation stages in your portfolio.</span>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <button type="button" class="btn btn-success px-4 py-2.5 fw-bold rounded-pill shadow-sm d-flex align-items-center gap-2"
                        data-bs-dismiss="modal"
                        style="background-color: #064E3B; border-color: #064E3B; color: white !important; font-size: 14px; min-width: 200px; justify-content: center;">
                        View My Investment <i class="fas fa-arrow-right"></i>
                    </button>

                    <a href="{{ route('admin.dashboard', ['tab' => 'invest']) }}"
                        class="btn btn-outline-secondary px-4 py-2.5 fw-bold rounded-pill border d-flex align-items-center gap-2"
                        style="font-size: 14px; color: #374151; border-color: #D1D5DB;">
                        Browse More Farms <i class="fas fa-search"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    .animate-fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Dynamic Pop, 3D Rotation & Confetti Animations */
    @keyframes modalPopRotate {
        0% {
            opacity: 0;
            transform: scale(0.6) rotate(-7deg) translateY(35px);
        }
        70% {
            transform: scale(1.03) rotate(1deg) translateY(-4px);
        }
        100% {
            opacity: 1;
            transform: scale(1) rotate(0deg) translateY(0);
        }
    }

    @keyframes spinCheckmark {
        0% {
            transform: scale(0) rotate(-180deg);
            opacity: 0;
        }
        75% {
            transform: scale(1.2) rotate(10deg);
            opacity: 1;
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    @keyframes floatConfetti1 {
        0% { transform: translateY(0px) rotate(15deg); }
        50% { transform: translateY(-8px) rotate(35deg); }
        100% { transform: translateY(0px) rotate(15deg); }
    }

    @keyframes floatConfetti2 {
        0% { transform: translateY(0px) rotate(-20deg); }
        50% { transform: translateY(-10px) rotate(15deg); }
        100% { transform: translateY(0px) rotate(-20deg); }
    }

    #investmentSuccessModal.show .modal-content {
        animation: modalPopRotate 0.65s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    #investmentSuccessModal.show .animated-check-circle {
        animation: spinCheckmark 0.75s cubic-bezier(0.34, 1.56, 0.64, 1) forwards 0.15s;
    }

    .confetti-particle-1 { animation: floatConfetti1 2.5s infinite ease-in-out; }
    .confetti-particle-2 { animation: floatConfetti2 3.2s infinite ease-in-out; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('investment_success') || request('show_success'))
        const modal = new bootstrap.Modal(document.getElementById('investmentSuccessModal'));
        modal.show();
    @endif
});
</script>
@endsection

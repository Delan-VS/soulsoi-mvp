@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

    @if(auth()->user()?->is_admin)
        <!-- ========================================== -->
        <!-- REAL ADMIN DASHBOARD (Executive Overview)  -->
        <!-- ========================================== -->
        <div class="tab-content">

            <!-- Tab 1: Executive Overview -->
            <div class="tab-pane fade {{ !request('tab') || request('tab') === 'overview' ? 'show active' : '' }}" id="overview"
                role="tabpanel"
                style="{{ !request('tab') || request('tab') === 'overview' ? 'display: block;' : 'display: none;' }}">

                <!-- Hero Welcome Header -->
                <div class="card border-0 shadow-sm rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="card-body p-4 p-lg-5 text-white">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-success bg-opacity-20 text-success border border-success border-opacity-30 mb-3"
                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                    <span class="spinner-grow spinner-grow-sm text-success" role="status"
                                        style="width: 8px; height: 8px;"></span>
                                    <span class="fw-bold text-uppercase">System Operational</span>
                                </div>
                                <h3 class="fw-bold mb-2 text-white">Welcome back, Admin 👋</h3>
                                <p class="text-white-50 mb-0" style="font-size: 12px; max-width: 600px;">
                                    Here is what's happening across SoulSoil today. You have <strong
                                        class="text-warning">{{ $pendingFarmers }} farmer applications</strong> and <strong
                                        class="text-warning">{{ $pendingFarms }} farm verification requests</strong> awaiting
                                    your review.
                                </p>
                            </div>
                            <div class="col-lg-4 text-end mt-3 mt-lg-0">
                                <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                                    <a href="{{ route('admin.farmers.index') }}"
                                        class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm"
                                        style="font-size: 11px;">
                                        <i class="fas fa-user-check me-1"></i> Review Farmers ({{ $pendingFarmers }})
                                    </a>
                                    <a href="{{ route('admin.farms.index') }}"
                                        class="btn btn-outline-light rounded-pill px-3 py-2 fw-semibold"
                                        style="font-size: 11px;">
                                        <i class="fas fa-tractor me-1"></i> Review Farms ({{ $pendingFarms }})
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI Metric Cards (Row of 4) -->
                <div class="row g-3 mb-4">

                    <!-- Card 1: Total Farmers -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                            style="background: #ffffff;">
                            <div class="card-body p-3 p-xl-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted text-uppercase fw-bold"
                                        style="font-size: 10px; letter-spacing: 0.8px;">Farmers Network</span>
                                    <div class="bg-primary bg-opacity-10 text-primary p-2.5 rounded-3">
                                        <i class="fas fa-users fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">{{ number_format($totalFarmers) }}
                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i>{{ $approvedFarmers }} Approved
                                    </span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-2 py-1 rounded-pill">
                                        <i class="fas fa-clock me-1"></i>{{ $pendingFarmers }} Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Total Farms & Acreage -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                            style="background: #ffffff;">
                            <div class="card-body p-3 p-xl-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted text-uppercase fw-bold"
                                        style="font-size: 10px; letter-spacing: 0.8px;">Farms & Land</span>
                                    <div class="bg-success bg-opacity-10 text-success p-2.5 rounded-3">
                                        <i class="fas fa-seedling fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">{{ number_format($totalFarms) }}
                                    <span class="text-muted fs-6 fw-normal">Farms</span>
                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="text-success fw-bold"><i
                                            class="fas fa-map-marked-alt me-1"></i>{{ number_format($totalAcres, 1) }} Total
                                        Acres</span>
                                    <span class="text-muted">&bull; {{ $approvedFarms }} Active</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Capital Raised -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                            style="background: #ffffff;">
                            <div class="card-body p-3 p-xl-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted text-uppercase fw-bold"
                                        style="font-size: 10px; letter-spacing: 0.8px;">Capital Committed</span>
                                    <div class="bg-info bg-opacity-10 text-info p-2.5 rounded-3">
                                        <i class="fas fa-hand-holding-usd fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">
                                    ₹{{ number_format($totalInvestedCapital) }}</h3>
                                <div class="progress mt-2 mb-1" style="height: 5px;">
                                    <?php    $percent = $totalFundingTarget > 0 ? min(100, round(($totalInvestedCapital / $totalFundingTarget) * 100)) : 0; ?>
                                    <div class="progress-bar bg-info" style="width: {{ $percent }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 10px;">
                                    <span class="text-muted">Target: ₹{{ number_format($totalFundingTarget) }}</span>
                                    <span class="fw-bold text-info">{{ $percent }}% Funded</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Action Required Queue -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden"
                            style="background: #ffffff;">
                            <div class="card-body p-3 p-xl-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted text-uppercase fw-bold"
                                        style="font-size: 10px; letter-spacing: 0.8px;">Pending Queue</span>
                                    <div class="bg-warning bg-opacity-10 text-warning p-2.5 rounded-3">
                                        <i class="fas fa-clipboard-check fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">
                                    {{ $pendingFarmers + $pendingFarms }} <span class="text-muted fs-6 fw-normal">Items</span>
                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="text-warning fw-bold"><i class="fas fa-exclamation-circle me-1"></i>Action
                                        Required</span>
                                    <span class="text-muted">&bull; {{ $pendingFarmers }} Farmers, {{ $pendingFarms }}
                                        Farms</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Main Content Grid: Recent Farmers & Recent Farms -->
                <div class="row g-4 mb-4">

                    <!-- Left Table: Recent Farmer Verification Requests -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div
                                class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Recent Farmer Applications</h6>
                                    <p class="text-muted mb-0" style="font-size: 11px;">Latest registration requests submitted
                                        by farmers.</p>
                                </div>
                                <a href="{{ route('admin.farmers.index') }}"
                                    class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-primary"
                                    style="font-size: 11px;">View All</a>
                            </div>
                            <div class="card-body p-0 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                        <thead class="bg-light text-muted">
                                            <tr>
                                                <th class="px-4 py-2.5 border-0 fw-semibold">Farmer Name</th>
                                                <th class="px-3 py-2.5 border-0 fw-semibold">District</th>
                                                <th class="px-3 py-2.5 border-0 fw-semibold">Status</th>
                                                <th class="px-4 py-2.5 border-0 text-end fw-semibold">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentFarmers as $farmer)
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                                style="width: 32px; height: 32px; font-size: 11px;">
                                                                {{ strtoupper(substr($farmer->full_name, 0, 2)) }}
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-dark">{{ $farmer->full_name }}</div>
                                                                <div class="text-muted" style="font-size: 10px;">
                                                                    {{ $farmer->user?->email ?? 'No email' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-3 text-muted">{{ $farmer->district ?? 'N/A' }}</td>
                                                    <td class="px-3 py-3">
                                                        @if($farmer->overall_status === 'approved')
                                                            <span
                                                                class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-check-circle me-1"></i>Approved</span>
                                                        @elseif($farmer->overall_status === 'rejected')
                                                            <span
                                                                class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-times-circle me-1"></i>Rejected</span>
                                                        @else
                                                            <span
                                                                class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-clock me-1"></i>Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-end">
                                                        <a href="{{ route('admin.farmers.show', $farmer) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                            style="font-size: 11px;">Review</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">No farmer applications
                                                        found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Table: Recent Farm Submissions -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div
                                class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Recent Farm Submissions</h6>
                                    <p class="text-muted mb-0" style="font-size: 11px;">Newly registered land plots seeking
                                        verification.</p>
                                </div>
                                <a href="{{ route('admin.farms.index') }}"
                                    class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-success"
                                    style="font-size: 11px;">View All</a>
                            </div>
                            <div class="card-body p-0 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                        <thead class="bg-light text-muted">
                                            <tr>
                                                <th class="px-4 py-2.5 border-0 fw-semibold">Farm Name</th>
                                                <th class="px-3 py-2.5 border-0 fw-semibold">Crop / Area</th>
                                                <th class="px-3 py-2.5 border-0 fw-semibold">Status</th>
                                                <th class="px-4 py-2.5 border-0 text-end fw-semibold">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentFarms as $farm)
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                                style="width: 32px; height: 32px;">
                                                                <i class="fas fa-tractor" style="font-size: 12px;"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-dark">{{ $farm->name }}</div>
                                                                <div class="text-muted" style="font-size: 10px;">
                                                                    {{ $farm->farmer?->full_name ?? 'Farmer' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="fw-medium text-dark">{{ $farm->primary_crop }}</div>
                                                        <div class="text-muted" style="font-size: 10px;">{{ $farm->total_acres }}
                                                            Acres</div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        @if($farm->status === 'approved')
                                                            <span
                                                                class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-check-circle me-1"></i>Approved</span>
                                                        @elseif($farm->status === 'rejected')
                                                            <span
                                                                class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-times-circle me-1"></i>Rejected</span>
                                                        @else
                                                            <span
                                                                class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-clock me-1"></i>Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-end">
                                                        <a href="{{ route('admin.farms.show', $farm) }}"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3 py-1"
                                                            style="font-size: 11px;">Review</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">No farm submissions found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Tab 2: Investors & Investment Approval Queue -->
            <div class="tab-pane fade {{ request('tab') === 'investors' ? 'show active' : '' }}" id="investors" role="tabpanel"
                style="{{ request('tab') === 'investors' ? 'display: block;' : '' }}">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Investors & Investment Verification Queue
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 11px;">Review investor capital commitments, manually
                            approve/reject investments, and manage investor accounts.</p>
                    </div>
                    <span
                        class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-bold border border-warning border-opacity-25"
                        style="font-size: 11px;">
                        <i class="fas fa-clock me-1"></i> {{ $pendingInvestmentsCount ?? 0 }} Investments Pending Approval
                    </span>
                </div>

                <!-- Section 1: Investment Approval Queue -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;"><i
                                    class="fas fa-hand-holding-usd text-warning me-2"></i>Investment Applications (Admin
                                Approval Required)</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">Investments submitted by users awaiting admin
                                payment & capital verification.</p>
                        </div>
                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th class="px-4 py-3 border-0 fw-semibold">Investment ID</th>
                                        <th class="px-4 py-3 border-0 fw-semibold">Investor</th>
                                        <th class="px-3 py-3 border-0 fw-semibold">Target Farm</th>
                                        <th class="px-3 py-3 border-0 fw-semibold">Amount & Equity</th>
                                        <th class="px-3 py-3 border-0 fw-semibold">Status</th>
                                        <th class="px-4 py-3 border-0 text-end fw-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allInvestments ?? [] as $inv)
                                        <tr>
                                            <!-- Investment ID -->
                                            <td class="px-4 py-3">
                                                <span class="fw-bold text-secondary"
                                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                                    #INV-{{ str_pad($inv->id, 4, '0', STR_PAD_LEFT) }}
                                                </span>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    {{ $inv->created_at ? $inv->created_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                            </td>

                                            <!-- Investor -->
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 11px;">
                                                        {{ strtoupper(substr($inv->user?->name ?? 'INV', 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $inv->user?->name ?? 'Investor' }}</div>
                                                        <div class="text-muted" style="font-size: 10px;">
                                                            {{ $inv->user?->email ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Target Farm -->
                                            <td class="px-3 py-3">
                                                <div class="fw-bold text-dark">{{ $inv->farm?->name ?? 'Farm Plot' }}</div>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    {{ $inv->farm?->primary_crop ?? 'Crop' }}
                                                </div>
                                            </td>

                                            <!-- Amount & Equity -->
                                            <td class="px-3 py-3">
                                                <div class="fw-bold text-success fs-6">₹{{ number_format($inv->amount) }}</div>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    {{ number_format($inv->equity_share, 1) }}% Equity Share
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-3 py-3">
                                                @if($inv->status === 'approved' || $inv->status === 'active')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Approved
                                                    </span>
                                                @elseif($inv->status === 'rejected')
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-clock me-1"></i> Pending Approval
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-4 py-3 text-end">
                                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                        style="font-size: 11px;" data-bs-toggle="modal"
                                                        data-bs-target="#investmentModal{{ $inv->id }}">
                                                        <i class="fas fa-eye me-1"></i> Review Details
                                                    </button>
                                                    @if($inv->status === 'pending')
                                                        <form action="{{ route('admin.investments.approve', $inv) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold shadow-sm"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.investments.reject', $inv) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-hand-holding-usd fa-3x mb-3 text-light"></i>
                                                <p class="mb-0">No investments submitted yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Registered Investor Account Verification Queue -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;"><i
                                    class="fas fa-users text-primary me-2"></i>Investor User Accounts (Account Approvals)</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">Investors registered via the frontend
                                registration form awaiting account activation.</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold"
                            style="font-size: 11px;">
                            {{ $pendingInvestorUsersCount ?? 0 }} Accounts Pending Review
                        </span>
                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th class="px-4 py-3 border-0 fw-semibold">Investor Name</th>
                                        <th class="px-4 py-3 border-0 fw-semibold">Email & Contact</th>
                                        <th class="px-3 py-3 border-0 fw-semibold">Registered On</th>
                                        <th class="px-3 py-3 border-0 fw-semibold">Account Status</th>
                                        <th class="px-4 py-3 border-0 text-end fw-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allInvestorUsers ?? [] as $invUser)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 11px;">
                                                        {{ strtoupper(substr($invUser->name, 0, 2)) }}
                                                    </div>
                                                    <div class="fw-bold text-dark">{{ $invUser->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-dark">{{ $invUser->email }}</div>
                                                <div class="text-muted" style="font-size: 10px;">{{ $invUser->phone ?? 'No phone' }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 text-muted">
                                                {{ $invUser->created_at ? $invUser->created_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-3 py-3">
                                                @if($invUser->investor_status === 'approved')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Active / Approved
                                                    </span>
                                                @elseif($invUser->investor_status === 'rejected')
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-clock me-1"></i> Pending Review
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                        style="font-size: 11px;" data-bs-toggle="modal"
                                                        data-bs-target="#investorModal{{ $invUser->id }}">
                                                        <i class="fas fa-eye me-1"></i> Review Details
                                                    </button>
                                                    @if($invUser->investor_status === 'pending')
                                                        <form action="{{ route('admin.investor_users.approve', $invUser) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold shadow-sm"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-user-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.investor_users.reject', $invUser) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-user-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No investor account applications
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ALL MODALS OUTSIDE CARDS/TABLES TO PREVENT BLINKING/FLICKERING -->
                <!-- Investment Details Modals -->
                @foreach($allInvestments ?? [] as $inv)
                    <div class="modal fade text-start" id="investmentModal{{ $inv->id }}" tabindex="-1"
                        aria-labelledby="investmentModalLabel{{ $inv->id }}" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header border-0 bg-dark text-white p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success text-white rounded-3 p-3 d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 48px; height: 48px;">
                                            <i class="fas fa-hand-holding-usd fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="modal-title fw-bold text-white mb-0" id="investmentModalLabel{{ $inv->id }}">
                                                Investment Pledge #INV-{{ str_pad($inv->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                            <small class="text-white-50">Submitted on
                                                {{ $inv->created_at ? $inv->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 bg-light">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Investor Name</small>
                                                <span class="fw-bold text-dark fs-6">{{ $inv->user?->name ?? 'N/A' }}</span>
                                                <small class="text-muted d-block"
                                                    style="font-size: 11px;">{{ $inv->user?->email }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Target Farm Plot</small>
                                                <span class="fw-bold text-dark fs-6">{{ $inv->farm?->name ?? 'N/A' }}</span>
                                                <small class="text-muted d-block" style="font-size: 11px;">Crop:
                                                    {{ $inv->farm?->primary_crop ?? 'N/A' }} | Location:
                                                    {{ $inv->farm?->location ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Amount Pledged</small>
                                                <span class="fw-bold text-success fs-5">₹{{ number_format($inv->amount) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Calculated Equity Share</small>
                                                <span
                                                    class="fw-bold text-info fs-5">{{ number_format($inv->equity_share, 2) }}%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Payment Method</small>
                                                <span
                                                    class="fw-bold text-dark fs-6">{{ $inv->payment_method ?? 'UPI Payment' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-white rounded-3 border mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark" style="font-size: 13px;">Payment Status</span>
                                            @if($inv->status === 'approved' || $inv->status === 'active')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-check-circle me-1"></i> Payment Approved</span>
                                            @elseif($inv->status === 'rejected')
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-times-circle me-1"></i> Payment Rejected</span>
                                            @else
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-clock me-1"></i> Pending Verification</span>
                                            @endif
                                        </div>
                                        <p class="text-muted mb-0" style="font-size: 11px;">
                                            Approving this application will add ₹{{ number_format($inv->amount) }} to
                                            {{ $inv->farm?->name ?? 'the farm plot' }}'s raised capital pool and issue
                                            {{ number_format($inv->equity_share, 2) }}% equity.
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-white p-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Close</button>
                                    <div class="d-flex gap-2">
                                        @if($inv->status === 'pending')
                                            <form action="{{ route('admin.investments.approve', $inv) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-check me-1"></i> Approve Payment
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.investments.reject', $inv) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-semibold">
                                                    <i class="fas fa-times me-1"></i> Reject Payment
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Investor User Profile Details Modals -->
                @foreach($allInvestorUsers ?? [] as $invUser)
                    <div class="modal fade text-start" id="investorModal{{ $invUser->id }}" tabindex="-1"
                        aria-labelledby="investorModalLabel{{ $invUser->id }}" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header border-0 bg-dark text-white p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 48px; height: 48px; font-size: 18px;">
                                            {{ strtoupper(substr($invUser->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h5 class="modal-title fw-bold text-white mb-0"
                                                id="investorModalLabel{{ $invUser->id }}">{{ $invUser->name }}</h5>
                                            <small class="text-white-50">Investor Account ID:
                                                #INV-USER-{{ str_pad($invUser->id, 4, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 bg-light">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Full Name</small>
                                                <span class="fw-bold text-dark">{{ $invUser->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Email Address</small>
                                                <span class="fw-bold text-dark">{{ $invUser->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Phone Number</small>
                                                <span class="fw-bold text-dark">{{ $invUser->phone ?? 'Not provided' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Registration Date</small>
                                                <span
                                                    class="fw-bold text-dark">{{ $invUser->created_at ? $invUser->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-white rounded-3 border mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark" style="font-size: 13px;">Verification & Account
                                                Status</span>
                                            @if($invUser->investor_status === 'approved')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-check-circle me-1"></i> Active / Approved</span>
                                            @elseif($invUser->investor_status === 'rejected')
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-times-circle me-1"></i> Rejected</span>
                                            @else
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-clock me-1"></i> Pending Review</span>
                                            @endif
                                        </div>
                                        <p class="text-muted mb-0" style="font-size: 11px;">
                                            Frontend investor registrations require administrative verification before users can
                                            access investment portfolios and pledge funds to farm listings.
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-white p-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Close</button>
                                    <div class="d-flex gap-2">
                                        @if($invUser->investor_status !== 'approved')
                                            <form action="{{ route('admin.investor_users.approve', $invUser) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-user-check me-1"></i> Approve Investor
                                                </button>
                                            </form>
                                        @endif
                                        @if($invUser->investor_status !== 'rejected')
                                            <form action="{{ route('admin.investor_users.reject', $invUser) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-semibold">
                                                    <i class="fas fa-user-times me-1"></i> Reject Investor
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tab 3: System Settings -->
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">System Settings</h4>
                <p class="text-muted mb-4" style="font-size: 11px;">Configure core platform preferences and automated
                    verification rules.</p>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-dark mb-3"><i
                                        class="fas fa-sliders-h me-2 text-primary"></i>Verification Controls</h6>

                                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">Auto-Approve Verified Aadhar
                                        </div>
                                        <div class="text-muted" style="font-size: 11px;">Automatically approve farmers with
                                            matching Government KYC records.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked id="autoApprove">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">Email Notifications for New
                                            Farms</div>
                                        <div class="text-muted" style="font-size: 11px;">Receive instant admin email when a
                                            farmer submits a new plot.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked id="emailNotif">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-3">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">Maintenance Mode</div>
                                        <div class="text-muted" style="font-size: 11px;">Temporarily disable new farmer
                                            applications and investment submissions.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintMode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-database me-2 text-success"></i>Platform
                                    Cache & Maintenance</h6>

                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Platform Name</label>
                                    <input type="text" class="form-control rounded-3" value="SoulSoil Agriculture Platform"
                                        readonly style="font-size: 12px;">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small fw-bold">Support Contact Email</label>
                                    <input type="email" class="form-control rounded-3" value="admin@soulsoil.com"
                                        style="font-size: 12px;">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2"
                                        style="font-size: 11px;"><i class="fas fa-sync me-1"></i> Clear Cache</button>
                                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2"
                                        style="font-size: 11px;"><i class="fas fa-save me-1"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @elseif(auth()->user()?->farmer)
            <!-- ========================================== -->
            <!-- FARMER VIEW (Client-side SPA Tabs)         -->
            <!-- ========================================== -->
            <div class="tab-content">

                <!-- 1. Dashboard Tab -->
                <div class="farmer-tab-content tab-pane fade show active" id="tab-dashboard" role="tabpanel">
                    <!-- Hero Welcome Header -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4"
                        style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                        <div class="card-body p-4 p-lg-5 text-white">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <span
                                        class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 rounded-pill fw-semibold mb-3"
                                        style="font-size: 11px;">
                                        <i class="fas fa-check-circle me-1"></i> Verified Farmer Profile
                                    </span>
                                    <h3 class="fw-bold mb-2 fs-2">Welcome back, {{ auth()->user()->name }}!</h3>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Manage your land plots, post crop
                                        updates
                                        for investors, and log sale proofs from your unified farmer dashboard.</p>
                                </div>
                                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                                    <button type="button" onclick="document.querySelector('[data-tab=\'add-farm\']').click();"
                                        class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-success shadow-sm"
                                        style="font-size: 12px;">
                                        <i class="fas fa-plus-circle me-1.5"></i> Register New Farm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                                            <i class="fas fa-seedling fs-4"></i>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Active Plots</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">{{ count($myFarms ?? []) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Total Registered Farms</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                            <i class="fas fa-hand-holding-usd fs-4"></i>
                                        </div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Capital</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">
                                        ₹{{ number_format($myFarms->sum('funding_raised') ?? 0) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Total Funding Raised</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                                            <i class="fas fa-ruler-combined fs-4"></i>
                                        </div>
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Acreage</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">{{ $myFarms->sum('total_acres') ?? 0 }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Total Acres Cultivated</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                            <i class="fas fa-clock fs-4"></i>
                                        </div>
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Status</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">{{ $myFarms->where('status', 'pending')->count() }}
                                    </h3>
                                    <div class="text-muted" style="font-size: 11px;">Plots Pending Approval</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. My Farms Tab -->
                <div class="farmer-tab-content tab-pane fade" id="tab-my-farms" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">My Registered Farms</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Manage your farm listings, track investor
                                funding
                                progress, and check admin verification status.</p>
                        </div>
                        <button type="button" onclick="document.querySelector('[data-tab=\'add-farm\']').click();"
                            class="btn btn-success rounded-pill px-3 py-2 fw-semibold" style="font-size: 11px;">
                            <i class="fas fa-plus me-1"></i> Add New Plot
                        </button>
                    </div>

                    <div class="row g-4">
                        @forelse ($myFarms ?? [] as $farm)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden position-relative">
                                            <div class="position-relative overflow-hidden" style="height: 150px;">
                                                @if($farm->farm_photo_path)
                                                    <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @elseif(!empty($farm->additional_photos) && is_array($farm->additional_photos) && count($farm->additional_photos) > 0)
                                                    <img src="{{ asset('storage/' . $farm->additional_photos[0]) }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                        class="w-100 h-100" style="object-fit: cover;">
                                                @endif
                                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>
                                                <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                                    <div class="fw-bold" style="font-size: 13px; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                                                        {{ $farm->name }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="position-absolute top-0 end-0 m-3">
                                                @if($farm->status === 'approved')
                                                    <span class="badge bg-success shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Approved</span>
                                                @elseif($farm->status === 'rejected')
                                                    <span class="badge bg-danger shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Pending Review</span>
                                                @endif
                                            </div>

                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-dark mb-1">{{ $farm->name }}</h6>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    {{ $farm->location ?? 'Kerala' }}
                                                </p>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Crop
                                                            </div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;">
                                                                {{ $farm->primary_crop }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Area
                                                            </div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;">{{ $farm->total_acres }}
                                                                Acres</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php        $target = $farm->funding_target > 0 ? $farm->funding_target : 1;
                            $raised = $farm->funding_raised ?? 0;
                            $perc = min(100, round(($raised / $target) * 100)); ?>
                                                <div class="d-flex justify-content-between align-items-center mb-1"
                                                    style="font-size: 11px;">
                                                    <span class="text-muted">Funding Raised</span>
                                                    <span class="fw-bold text-success">₹{{ number_format($raised) }} /
                                                        ₹{{ number_format($target) }}</span>
                                                </div>
                                                <div class="progress rounded-pill mb-3" style="height: 6px;">
                                                    <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                                        style="width: {{ $perc }}%;"></div>
                                                </div>

                                                <div class="pt-3 border-top d-flex gap-2 align-items-center">
                                                    <a href="{{ route('admin.farms.show', $farm) }}"
                                                        class="btn btn-outline-success btn-sm rounded-pill flex-fill fw-bold"
                                                        style="font-size: 11px;" title="View Verification Overview">
                                                        <i class="fas fa-eye me-1"></i> View Details
                                                    </a>
                                                    <a href="{{ route('admin.farms.edit', $farm) }}"
                                                        class="btn btn-outline-primary btn-sm rounded-pill flex-fill fw-bold"
                                                        style="font-size: 11px;" title="Edit Farm Plot">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.farms.destroy', $farm) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete {{ $farm->name }}?');"
                                                        class="d-inline flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold"
                                                            style="font-size: 11px;" title="Delete Farm Plot">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="card border-0 shadow-sm rounded-4 p-5">
                                    <i class="fas fa-seedling text-success fa-3x mb-3 opacity-50"></i>
                                    <h5 class="fw-bold text-dark mb-1">No Farms Added Yet</h5>
                                    <p class="text-muted mb-4" style="font-size: 12px;">Submit your first farm plot for admin
                                        verification and investor capital listing.</p>
                                    <div>
                                        <button type="button" onclick="document.querySelector('[data-tab=\'add-farm\']').click();"
                                            class="btn btn-success rounded-pill px-4 py-2 fw-semibold" style="font-size: 12px;">
                                            <i class="fas fa-plus-circle me-1.5"></i> Register New Farm Plot
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Add New Farm Tab (Figma Exact 6-Step Interactive Wizard) -->
                <div class="farmer-tab-content tab-pane fade" id="tab-add-farm" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Register New Farm Plot</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Complete the 6-step plot registration wizard to
                                submit your land for admin approval.</p>
                        </div>
                    </div>

                    <!-- Wizard Step Progress Indicator -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 text-center"
                                style="font-size: 11px;">
                                <div class="wizard-badge badge bg-success text-white px-3 py-2 rounded-pill fw-bold"
                                    id="step-badge-1"><i class="fas fa-info-circle me-1"></i>01 Basic Details</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-2"><i class="fas fa-coins me-1"></i>02 Investment</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-3"><i class="fas fa-camera me-1"></i>03 Media</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-4"><i class="fas fa-calendar-alt me-1"></i>04 Yield</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-5"><i class="fas fa-file-contract me-1"></i>05 Terms</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-6"><i class="fas fa-check-circle me-1"></i>06 Review</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <form action="{{ route('admin.farms.store') }}" method="POST" enctype="multipart/form-data"
                                id="addFarmWizardForm">
                                @csrf

                                <!-- Hidden JSON Fields for Controller -->
                                <input type="hidden" name="budget_breakdown" id="budget_breakdown_json"
                                    value="{{ old('budget_breakdown', '[]') }}">
                                <input type="hidden" name="farming_timeline" id="farming_timeline_json"
                                    value="{{ old('farming_timeline', '[]') }}">

                                @if($errors->any())
                                    <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 rounded-3 mb-4 p-3"
                                        style="font-size: 12px;">
                                        <div class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i> Please fix the
                                            following errors to submit your fund request:</div>
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <script>
                                        window.addEventListener('DOMContentLoaded', () => {
                                            // Auto-open Add Farm tab if there are validation errors
                                            const addFarmBtn = document.querySelector('[data-tab="add-farm"]');
                                            if (addFarmBtn) addFarmBtn.click();
                                        });
                                    </script>
                                @endif

                                <!-- STEP 1: Basic Plot Details (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-1">
                                    <h5 class="fw-bold text-dark mb-1">About this farm</h5>
                                    <p class="text-muted mb-4" style="font-size: 12px;">Start with the basics. Investors look
                                        for
                                        clear identity and scale first.</p>

                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Farm Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="wiz_name" class="form-control rounded-3 py-2"
                                            placeholder="e.g. Anantapur Paddy Plot - Block A" required style="font-size: 12px;"
                                            value="{{ old('name') }}">
                                        <div class="text-muted mt-1" style="font-size: 10px;">Use a descriptive name that helps
                                            investors identify the location or project.</div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Total Area
                                                (Acres) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="total_acres" id="wiz_acres"
                                                class="form-control rounded-3 py-2" placeholder="0.00 acres" required
                                                style="font-size: 12px;" value="{{ old('total_acres') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Primary
                                                Crop
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="primary_crop" id="wiz_primary_crop"
                                                class="form-control rounded-3 py-2" placeholder="e.g. Basmati Rice" required
                                                style="font-size: 12px;" value="{{ old('primary_crop') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Secondary Crop
                                            (Optional)</label>
                                        <input type="text" name="secondary_crop" id="wiz_secondary_crop"
                                            class="form-control rounded-3 py-2" placeholder="e.g. Turmeric, Vegetables"
                                            style="font-size: 12px;" value="{{ old('secondary_crop') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Location /
                                            Region
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="location" id="wiz_location" class="form-control rounded-3 py-2"
                                            placeholder="e.g. Anantapur, Andhra Pradesh" required style="font-size: 12px;"
                                            value="{{ old('location') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Listing
                                            Category
                                            <span class="text-danger">*</span></label>
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <button type="button" onclick="selectCategory('Vegetables', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill active"
                                                style="font-size: 11px;">Vegetables</button>
                                            <button type="button" onclick="selectCategory('Paddy', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill"
                                                style="font-size: 11px;">Paddy</button>
                                            <button type="button" onclick="selectCategory('Fruits', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill"
                                                style="font-size: 11px;">Fruits</button>
                                            <button type="button" onclick="selectCategory('Pulses', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill"
                                                style="font-size: 11px;">Pulses</button>
                                            <button type="button" onclick="selectCategory('Spices', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill"
                                                style="font-size: 11px;">Spices</button>
                                            <button type="button" onclick="selectCategory('Other', this)"
                                                class="btn btn-outline-success rounded-pill px-3 py-1 cat-pill"
                                                style="font-size: 11px;">Other</button>
                                        </div>
                                        <input type="hidden" name="listing_category" id="wiz_category"
                                            value="{{ old('listing_category', 'Vegetables') }}">
                                    </div>

                                    <div class="d-flex justify-content-end pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(2)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 2: Investment & Budget Breakdown (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-2" style="display: none;">
                                    <div class="row g-4 mb-4">
                                        <div class="col-lg-8">
                                            <h5 class="fw-bold text-dark mb-1">Budget Breakdown</h5>
                                            <p class="text-muted mb-3" style="font-size: 12px;">Specify individual expenses for
                                                this
                                                farm project.</p>

                                            <!-- Quick Expense Chips -->
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <button type="button" onclick="addBudgetItem('Seeds', 45000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Seeds</button>
                                                <button type="button" onclick="addBudgetItem('Labor', 120000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Labor</button>
                                                <button type="button" onclick="addBudgetItem('Irrigation', 85000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Irrigation</button>
                                                <button type="button" onclick="addBudgetItem('Equipment', 50000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Equipment</button>
                                                <button type="button" onclick="addBudgetItem('Fertilizer', 30000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Fertilizer</button>
                                                <button type="button" onclick="addBudgetItem('Land preparation', 20000)"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                                    style="font-size: 10px;">+
                                                    Land preparation</button>
                                            </div>

                                            <!-- Budget Breakdown Table -->
                                            <div class="table-responsive rounded-3 border mb-3">
                                                <table class="table table-bordered mb-0 align-middle" style="font-size: 12px;">
                                                    <thead class="bg-success text-white">
                                                        <tr>
                                                            <th>Purpose</th>
                                                            <th style="width: 200px;">Amount requested (₹)</th>
                                                            <th style="width: 50px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="budget_table_body">
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Seeds"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="45000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Labor"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="120000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Irrigation"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="85000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Equipment"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="50000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Fertilizer"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="30000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm b-purpose"
                                                                    value="Land preparation"></td>
                                                            <td><input type="number"
                                                                    class="form-control form-control-sm b-amount" value="20000"
                                                                    oninput="calculateBudgetTotal()"></td>
                                                            <td><button type="button" class="btn btn-sm text-danger"
                                                                    onclick="removeBudgetRow(this)"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="fw-bold bg-light">
                                                            <td>Total requested</td>
                                                            <td id="budget_total_display">₹3,50,000</td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <button type="button" onclick="addBudgetItem('Custom Expense', 0)"
                                                class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                style="font-size: 11px;">+
                                                Add custom row</button>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="card border-0 bg-light rounded-4 p-3 mb-3">
                                                <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;">Investment Totals
                                                </h6>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted" style="font-size: 11px;">Total Funding
                                                        Ask
                                                        (₹)</label>
                                                    <input type="number" name="funding_target" id="wiz_funding_target"
                                                        class="form-control form-control-sm rounded-3 fw-bold"
                                                        value="{{ old('funding_target', '350000') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted" style="font-size: 11px;">Your
                                                        Contribution
                                                        / Farmer's Stake (₹)</label>
                                                    <input type="number" name="your_contribution" id="wiz_your_contribution"
                                                        class="form-control form-control-sm rounded-3 fw-bold text-success"
                                                        value="{{ old('your_contribution', '50000') }}" required>
                                                    <div class="text-muted mt-1" style="font-size: 10px;">Amount of your own
                                                        capital
                                                        committed to this crop cycle.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted" style="font-size: 11px;">Expected
                                                        Investor
                                                        ROI (%)</label>
                                                    <input type="number" step="0.1" name="expected_roi" id="wiz_roi"
                                                        class="form-control form-control-sm rounded-3"
                                                        value="{{ old('expected_roi', '15') }}" required>
                                                    <div class="text-muted mt-1" style="font-size: 10px;">Subject to admin
                                                        review
                                                        and market conditions.</div>
                                                </div>
                                            </div>

                                            <div
                                                class="card border-0 bg-success bg-opacity-10 rounded-4 p-3 border-dashed border-success">
                                                <div class="fw-bold text-dark mb-1" style="font-size: 12px;"><i
                                                        class="fas fa-lightbulb text-warning me-1"></i>Why this matters</div>
                                                <p class="text-muted mb-0" style="font-size: 10px;">A clear breakdown helps
                                                    investors understand how their capital contributes to productivity. This
                                                    data
                                                    will be part of your public farm listing profile.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(1)"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2" style="font-size: 12px;">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </button>
                                        <button type="button" onclick="goToWizardStep(3)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue to Media <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 3: Media Uploads (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-3" style="display: none;">
                                    <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                                        <h6 class="fw-bold text-dark mb-1">Farm Photos</h6>
                                        <p class="text-muted mb-3" style="font-size: 11px;">Visual proof of your land,
                                            equipment,
                                            and current progress.</p>

                                        <div class="border border-2 border-dashed border-success rounded-4 p-4 bg-white mb-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-dark mb-1" style="font-size: 12px;"><i
                                                        class="fas fa-image text-success me-1"></i> Primary Farm Cover
                                                    Photo</label>
                                                <input type="file" name="farm_photo" id="wiz_farm_photo"
                                                    class="form-control form-control-sm" accept="image/*">
                                                <div class="text-muted" style="font-size: 10px;">Main featured image shown on
                                                    public listings. (JPG, PNG, max 5MB)</div>
                                            </div>

                                            <div class="pt-2 border-top">
                                                <label class="form-label fw-bold text-dark mb-1" style="font-size: 12px;"><i
                                                        class="fas fa-images text-success me-1"></i> Additional Farm Photos
                                                    (Optional)</label>
                                                <input type="file" name="farm_photos[]" id="wiz_farm_photos"
                                                    class="form-control form-control-sm" multiple accept="image/*">
                                                <div class="text-muted" style="font-size: 10px;">Upload extra gallery images of
                                                    crops, soil, and land progress.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                                        <h6 class="fw-bold text-dark mb-1">Farming Documents</h6>
                                        <p class="text-muted mb-3" style="font-size: 11px;">Legal and operational verification
                                            for
                                            investor peace of mind.</p>

                                        <div
                                            class="border border-2 border-dashed border-success rounded-4 p-4 text-center bg-white">
                                            <i class="fas fa-file-pdf text-danger fa-2x mb-2"></i>
                                            <div class="fw-bold text-dark" style="font-size: 12px;">Drag documents here or
                                                browse
                                            </div>
                                            <div class="text-muted" style="font-size: 10px;">Include Land Title Deeds, Soil
                                                Health
                                                Cards, or Certification PDFs</div>
                                            <input type="file" name="farm_documents[]" id="wiz_farm_documents"
                                                class="form-control form-control-sm mt-2" multiple accept=".pdf">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(2)"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2" style="font-size: 12px;">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </button>
                                        <button type="button" onclick="goToWizardStep(4)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 4: Yield & Farming Timeline (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-4" style="display: none;">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Total
                                                Yielding
                                                Period (Months) <span class="text-danger">*</span></label>
                                            <input type="number" name="yielding_period" id="wiz_yielding_period"
                                                class="form-control rounded-3 py-2" value="{{ old('yielding_period', '6') }}"
                                                required style="font-size: 12px;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Expected
                                                Start
                                                Date <span class="text-danger">*</span></label>
                                            <input type="date" name="expected_start_date" id="wiz_start_date"
                                                class="form-control rounded-3 py-2"
                                                value="{{ old('expected_start_date', date('Y-m-d')) }}" required
                                                style="font-size: 12px;">
                                        </div>
                                    </div>

                                    <div class="card border-0 rounded-4 overflow-hidden mb-4">
                                        <div class="bg-success p-3 text-white">
                                            <h6 class="fw-bold mb-0" style="font-size: 13px;">Farming Timeline</h6>
                                            <p class="mb-0 text-white-50" style="font-size: 10px;">Break the farming cycle into
                                                specific stages to help investors understand the process.</p>
                                        </div>
                                        <div class="card-body bg-light p-3">
                                            <div id="timeline_stages_container">
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text"
                                                            class="form-control form-control-sm stage-name"
                                                            value="Land Preparation"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-start" value="0"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-end" value="1"></div>
                                                    <div class="col-md-3"><input type="text"
                                                            class="form-control form-control-sm stage-dur" value="1 Month"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-1"><button type="button" class="btn btn-sm text-danger"
                                                            onclick="removeStageRow(this)"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text"
                                                            class="form-control form-control-sm stage-name"
                                                            value="Sowing & Germination"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-start" value="1"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-end" value="2"></div>
                                                    <div class="col-md-3"><input type="text"
                                                            class="form-control form-control-sm stage-dur" value="1 Month"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-1"><button type="button" class="btn btn-sm text-danger"
                                                            onclick="removeStageRow(this)"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text"
                                                            class="form-control form-control-sm stage-name"
                                                            value="Vegetative Growth"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-start" value="2"></div>
                                                    <div class="col-md-2"><input type="number"
                                                            class="form-control form-control-sm stage-end" value="5"></div>
                                                    <div class="col-md-3"><input type="text"
                                                            class="form-control form-control-sm stage-dur" value="3 Months"
                                                            readonly></div>
                                                    <div class="col-md-1"><button type="button" class="btn btn-sm text-danger"
                                                            onclick="removeStageRow(this)"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" onclick="addStageRow('Harvesting', 5, 6)"
                                                class="btn btn-sm btn-outline-success rounded-pill px-3 mt-2"
                                                style="font-size: 11px;">+ Add Another Stage</button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(3)"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2" style="font-size: 12px;">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </button>
                                        <button type="button" onclick="goToWizardStep(5)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 5: Terms & Investment Limits (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-5" style="display: none;">
                                    <div class="row g-4 mb-4">
                                        <div class="col-lg-7">
                                            <h5 class="fw-bold text-dark mb-1">Set investment limits</h5>
                                            <p class="text-muted mb-4" style="font-size: 12px;">Define the boundaries for
                                                individual
                                                investor contributions.</p>

                                            <div class="mb-3">
                                                <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Minimum
                                                    investment per investor (₹) <span class="text-danger">*</span></label>
                                                <input type="number" name="min_investment" id="wiz_min_inv"
                                                    class="form-control rounded-3 py-2"
                                                    value="{{ old('min_investment', '10000') }}" required
                                                    style="font-size: 12px;">
                                                <div class="text-muted mt-1" style="font-size: 10px;">Lower minimums attract a
                                                    wider
                                                    range of retail investors.</div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Maximum
                                                    investment per investor (₹) <span class="text-danger">*</span></label>
                                                <input type="number" name="max_investment" id="wiz_max_inv"
                                                    class="form-control rounded-3 py-2"
                                                    value="{{ old('max_investment', '350000') }}" required
                                                    style="font-size: 12px;">
                                                <div class="text-muted mt-1" style="font-size: 10px;">Higher maximums allow
                                                    institutional or angel investors to fill the funding gap quickly.</div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="wiz_terms" required checked>
                                                <label class="form-check-label text-dark fw-semibold" for="wiz_terms"
                                                    style="font-size: 11px;">
                                                    I agree to the terms and authorize admin physical verification.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="card border-0 bg-light rounded-4 p-3 mb-3">
                                                <h6 class="fw-bold text-dark mb-2" style="font-size: 12px;">Investment Context
                                                </h6>
                                                <div class="d-flex justify-content-between mb-1" style="font-size: 11px;">
                                                    <span class="text-muted">Ask Amount:</span>
                                                    <span class="fw-bold text-success" id="ctx_ask">₹5,00,000</span>
                                                </div>
                                            </div>
                                            <div class="card border-0 bg-warning bg-opacity-10 rounded-4 p-3">
                                                <div class="fw-bold text-dark mb-1" style="font-size: 11px;"><i
                                                        class="fas fa-balance-scale me-1"></i>Legal Notice</div>
                                                <p class="text-muted mb-0" style="font-size: 10px;">All terms are subject to
                                                    final
                                                    approval by the SoulSoil compliance team to ensure alignment with
                                                    agricultural
                                                    finance regulations.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(4)"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2" style="font-size: 12px;">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </button>
                                        <button type="button" onclick="goToWizardStep(6)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue to Review <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 6: Review & Final Submission (Figma Exact) -->
                                <div class="wizard-step-pane" id="wizard-step-6" style="display: none;">
                                    <h5 class="fw-bold text-dark mb-1">Final Application Review</h5>
                                    <p class="text-muted mb-4" style="font-size: 12px;">Review all farm parameters before
                                        submitting
                                        your plot for admin verification.</p>

                                    <!-- 1. Basic Details Card (Figma Green Header) -->
                                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
                                        style="background-color: #ffffff;">
                                        <div class="text-white px-4 py-2.5 d-flex justify-content-between align-items-center"
                                            style="background-color: #7ba017 !important;">
                                            <span class="fw-bold text-uppercase"
                                                style="font-size: 12px; letter-spacing: 0.5px;">Basic details</span>
                                            <button type="button" onclick="goToWizardStep(1)"
                                                class="btn btn-sm text-white p-0 text-decoration-none"
                                                style="font-size: 11px;"><i class="fas fa-edit me-1"></i>Edit</button>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3 text-dark">
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">FARM NAME</div>
                                                    <div class="fw-bold" id="rev_name" style="font-size: 13px;">Anantapur Paddy
                                                        Plot
                                                        #4</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">TOTAL ACRES</div>
                                                    <div class="fw-bold" id="rev_acres" style="font-size: 13px;">12.5 Acres
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">CATEGORY</div>
                                                    <div class="fw-bold" id="rev_category" style="font-size: 13px;">Paddy</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">PRIMARY CROP</div>
                                                    <div class="fw-bold" id="rev_crop" style="font-size: 13px;">Sona Masoori
                                                        Rice
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">SECONDARY CROP</div>
                                                    <div class="fw-bold" id="rev_secondary_crop" style="font-size: 13px;">Black
                                                        Gram
                                                        (Rotation)</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">LOCATION</div>
                                                    <div class="fw-bold" id="rev_location" style="font-size: 13px;">Anantapur,
                                                        Andhra Pradesh</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Investment Ask Card (Figma Green Header with Your Contribution / Farmer Stake) -->
                                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
                                        style="background-color: #ffffff;">
                                        <div class="text-white px-4 py-2.5 d-flex justify-content-between align-items-center"
                                            style="background-color: #7ba017 !important;">
                                            <span class="fw-bold text-uppercase"
                                                style="font-size: 12px; letter-spacing: 0.5px;">Investment ask</span>
                                            <button type="button" onclick="goToWizardStep(2)"
                                                class="btn btn-sm text-white p-0 text-decoration-none"
                                                style="font-size: 11px;"><i class="fas fa-edit me-1"></i>Edit</button>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3 mb-4 text-dark">
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">TOTAL INVESTMENT ASK
                                                    </div>
                                                    <div class="fw-bold text-dark fs-5" id="rev_target">₹ 4,50,000</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">YOUR CONTRIBUTION (FARMER
                                                        STAKE)</div>
                                                    <div class="fw-bold text-success fs-5" id="rev_contrib">₹ 50,000 (11%)</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">EXPECTED ROI</div>
                                                    <div class="fw-bold text-dark fs-5" id="rev_roi">12 - 15%</div>
                                                </div>
                                            </div>

                                            <div class="border rounded-3 p-3 bg-light">
                                                <table class="table table-borderless table-sm mb-0" style="font-size: 12px;">
                                                    <thead>
                                                        <tr class="border-bottom text-muted">
                                                            <th>Purpose</th>
                                                            <th class="text-end">Amount Requested</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="rev_budget_rows">
                                                        <tr>
                                                            <td>High-yield Seeds (IR-64)</td>
                                                            <td class="text-end fw-semibold">₹ 85,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Labor & Planting</td>
                                                            <td class="text-end fw-semibold">₹ 1,20,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fertilizer & Pesticides</td>
                                                            <td class="text-end fw-semibold">₹ 95,000</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="border-top fw-bold text-dark">
                                                            <td>Total Allocation</td>
                                                            <td class="text-end text-success" id="rev_budget_total">₹ 3,00,000
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Media and Documents Card (Figma Green Header) -->
                                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
                                        style="background-color: #ffffff;">
                                        <div class="text-white px-4 py-2.5 d-flex justify-content-between align-items-center"
                                            style="background-color: #7ba017 !important;">
                                            <span class="fw-bold text-uppercase"
                                                style="font-size: 12px; letter-spacing: 0.5px;">Media and documents</span>
                                            <button type="button" onclick="goToWizardStep(3)"
                                                class="btn btn-sm text-white p-0 text-decoration-none"
                                                style="font-size: 11px;"><i class="fas fa-edit me-1"></i>Edit</button>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="text-muted fw-bold text-uppercase mb-2"
                                                style="font-size: 10px; letter-spacing: 0.5px;">FARM PHOTOS (4)</div>
                                            <div class="row g-2" id="rev_photos_grid">
                                                <div class="col-3"><img
                                                        src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400"
                                                        class="img-fluid rounded-3"
                                                        style="height: 90px; width: 100%; object-fit: cover;"></div>
                                                <div class="col-3"><img
                                                        src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=400"
                                                        class="img-fluid rounded-3"
                                                        style="height: 90px; width: 100%; object-fit: cover;"></div>
                                                <div class="col-3"><img
                                                        src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400"
                                                        class="img-fluid rounded-3"
                                                        style="height: 90px; width: 100%; object-fit: cover;"></div>
                                                <div class="col-3"><img
                                                        src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400"
                                                        class="img-fluid rounded-3"
                                                        style="height: 90px; width: 100%; object-fit: cover;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(5)"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-2" style="font-size: 12px;">
                                            <i class="fas fa-arrow-left me-1"></i> Edit Details
                                        </button>
                                        <button type="submit" class="btn btn-success rounded-pill px-5 py-2.5 fw-bold shadow"
                                            style="font-size: 13px;">
                                            <i class="fas fa-paper-plane me-1.5"></i> Submit Farm Application for Admin Review
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function selectCategory(cat, el) {
                        document.getElementById('wiz_category').value = cat;
                        document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active', 'bg-success', 'text-white'));
                        el.classList.add('active', 'bg-success', 'text-white');
                    }

                    function addBudgetItem(purpose, amount) {
                        const tbody = document.getElementById('budget_table_body');
                        const row = document.createElement('tr');
                        row.innerHTML = `
                                                                                    <td><input type="text" class="form-control form-control-sm b-purpose" value="${purpose}"></td>
                                                                                    <td><input type="number" class="form-control form-control-sm b-amount" value="${amount}" oninput="calculateBudgetTotal()"></td>
                                                                                    <td><button type="button" class="btn btn-sm text-danger" onclick="removeBudgetRow(this)"><i class="fas fa-trash"></i></button></td>
                                                                                `;
                        tbody.appendChild(row);
                        calculateBudgetTotal();
                    }

                    function removeBudgetRow(btn) {
                        btn.closest('tr').remove();
                        calculateBudgetTotal();
                    }

                    function calculateBudgetTotal() {
                        let total = 0;
                        const items = [];
                        document.querySelectorAll('#budget_table_body tr').forEach(tr => {
                            const purpose = tr.querySelector('.b-purpose')?.value || '';
                            const amount = parseFloat(tr.querySelector('.b-amount')?.value || 0);
                            if (purpose && amount > 0) {
                                items.push({ purpose: purpose, amount: amount });
                                total += amount;
                            }
                        });
                        const displayEl = document.getElementById('budget_total_display');
                        if (displayEl) displayEl.textContent = '₹' + total.toLocaleString('en-IN');
                        const jsonEl = document.getElementById('budget_breakdown_json');
                        if (jsonEl) jsonEl.value = JSON.stringify(items);
                        const targetInput = document.getElementById('wiz_funding_target');
                        if (targetInput) targetInput.value = total;
                    }

                    function addStageRow(name, start, end) {
                        const container = document.getElementById('timeline_stages_container');
                        const div = document.createElement('div');
                        div.className = 'row g-2 mb-2 align-items-center stage-row';
                        div.innerHTML = `
                                                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="${name}"></div>
                                                                                    <div class="col-md-2"><input type="number" class="form-control form-control-sm stage-start" value="${start}"></div>
                                                                                    <div class="col-md-2"><input type="number" class="form-control form-control-sm stage-end" value="${end}"></div>
                                                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur" value="${end - start} Month(s)" readonly></div>
                                                                                    <div class="col-md-1"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                                                `;
                        container.appendChild(div);
                        syncTimelineJson();
                    }

                    function removeStageRow(btn) {
                        btn.closest('.stage-row').remove();
                        syncTimelineJson();
                    }

                    function syncTimelineJson() {
                        const stages = [];
                        document.querySelectorAll('.stage-row').forEach(row => {
                            const name = row.querySelector('.stage-name')?.value || '';
                            const start = row.querySelector('.stage-start')?.value || 0;
                            const end = row.querySelector('.stage-end')?.value || 0;
                            if (name) {
                                stages.push({ stage: name, start_month: start, end_month: end });
                            }
                        });
                        document.getElementById('farming_timeline_json').value = JSON.stringify(stages);
                    }

                    let currentWizardStep = 1;

                    function validateWizardStep(stepNum) {
                        const pane = document.getElementById('wizard-step-' + stepNum);
                        if (!pane) return true;

                        let isValid = true;
                        let firstInvalid = null;

                        // Validate Step 1
                        if (stepNum === 1) {
                            const name = document.getElementById('wiz_name');
                            const acres = document.getElementById('wiz_acres');
                            const crop = document.getElementById('wiz_primary_crop');
                            const loc = document.getElementById('wiz_location');

                            [name, acres, crop, loc].forEach(input => {
                                if (!input || !input.value.trim() || (input === acres && parseFloat(input.value) <= 0)) {
                                    isValid = false;
                                    input?.classList.add('is-invalid');
                                    if (!firstInvalid) firstInvalid = input;
                                } else {
                                    input?.classList.remove('is-invalid');
                                }
                            });
                        }

                        // Validate Step 2
                        if (stepNum === 2) {
                            const target = document.getElementById('wiz_funding_target');
                            const contrib = document.getElementById('wiz_your_contribution');
                            const roi = document.getElementById('wiz_roi');

                            [target, contrib, roi].forEach(input => {
                                if (!input || !input.value.trim() || parseFloat(input.value) < 0) {
                                    isValid = false;
                                    input?.classList.add('is-invalid');
                                    if (!firstInvalid) firstInvalid = input;
                                } else {
                                    input?.classList.remove('is-invalid');
                                }
                            });
                        }

                        if (!isValid) {
                            if (firstInvalid) firstInvalid.focus();
                            alert(`Please fill out all required fields in Step ${stepNum} before proceeding.`);
                        }

                        return isValid;
                    }

                    function goToWizardStep(step) {
                        // Enforce step validation when moving forward!
                        if (step > currentWizardStep) {
                            for (let s = currentWizardStep; s < step; s++) {
                                if (!validateWizardStep(s)) {
                                    return false;
                                }
                            }
                        }

                        currentWizardStep = step;

                        syncTimelineJson();
                        calculateBudgetTotal();

                        // Hide all panes
                        document.querySelectorAll('.wizard-step-pane').forEach(el => el.style.display = 'none');

                        // Show target pane
                        const target = document.getElementById('wizard-step-' + step);
                        if (target) target.style.display = 'block';

                        // Update badge indicators
                        for (let i = 1; i <= 6; i++) {
                            const badge = document.getElementById('step-badge-' + i);
                            if (badge) {
                                if (i === step) {
                                    badge.className = 'wizard-badge badge bg-success text-white px-3 py-2 rounded-pill fw-bold';
                                } else if (i < step) {
                                    badge.className = 'wizard-badge badge bg-success bg-opacity-20 text-success px-3 py-2 rounded-pill fw-bold';
                                } else {
                                    badge.className = 'wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold';
                                }
                            }
                        }

                        // Populate Step 5 Investment Context dynamically
                        if (step === 5) {
                            populateStep5Review();
                        }

                        // Populate Step 6 review cards 100% Dynamically from Input Fields!
                        if (step === 6) {
                            populateStep6Review();
                        }
                    }

                    function populateStep5Review() {
                        const targetVal = parseFloat(document.getElementById('wiz_funding_target')?.value || 0);
                        if (document.getElementById('ctx_ask')) {
                            document.getElementById('ctx_ask').textContent = '₹ ' + Number(targetVal).toLocaleString('en-IN');
                        }
                    }

                    function populateStep6Review() {
                        const name = document.getElementById('wiz_name')?.value || 'Not Specified';
                        const acres = document.getElementById('wiz_acres')?.value || '0';
                        const category = document.getElementById('wiz_category')?.value || 'General';
                        const crop = document.getElementById('wiz_primary_crop')?.value || 'Not Specified';
                        const secCrop = document.getElementById('wiz_secondary_crop')?.value || 'None (Single Crop)';
                        const location = document.getElementById('wiz_location')?.value || 'Not Specified';
                        const targetVal = parseFloat(document.getElementById('wiz_funding_target')?.value || 0);
                        const contribVal = parseFloat(document.getElementById('wiz_your_contribution')?.value || 0);
                        const roi = document.getElementById('wiz_roi')?.value || '0';

                        const pct = targetVal > 0 ? Math.round((contribVal / targetVal) * 100) : 0;

                        if (document.getElementById('rev_name')) document.getElementById('rev_name').textContent = name;
                        if (document.getElementById('rev_acres')) document.getElementById('rev_acres').textContent = acres + ' Acres';
                        if (document.getElementById('rev_category')) document.getElementById('rev_category').textContent = category;
                        if (document.getElementById('rev_crop')) document.getElementById('rev_crop').textContent = crop;
                        if (document.getElementById('rev_secondary_crop')) document.getElementById('rev_secondary_crop').textContent = secCrop;
                        if (document.getElementById('rev_location')) document.getElementById('rev_location').textContent = location;

                        if (document.getElementById('rev_target')) document.getElementById('rev_target').textContent = '₹ ' + Number(targetVal).toLocaleString('en-IN');
                        if (document.getElementById('rev_contrib')) document.getElementById('rev_contrib').textContent = '₹ ' + Number(contribVal).toLocaleString('en-IN') + ' (' + pct + '%)';
                        if (document.getElementById('rev_roi')) document.getElementById('rev_roi').textContent = roi + '%';

                        // Sync budget allocation rows
                        const budgetRows = [];
                        let budgetTotal = 0;
                        document.querySelectorAll('#budget_table_body tr').forEach(tr => {
                            const purpose = tr.querySelector('.b-purpose')?.value || '';
                            const amount = parseFloat(tr.querySelector('.b-amount')?.value || 0);
                            if (purpose && amount > 0) {
                                budgetRows.push(`<tr><td>${purpose}</td><td class="text-end fw-semibold">₹ ${Number(amount).toLocaleString('en-IN')}</td></tr>`);
                                budgetTotal += amount;
                            }
                        });
                        if (document.getElementById('rev_budget_rows')) {
                            document.getElementById('rev_budget_rows').innerHTML = budgetRows.length ? budgetRows.join('') : '<tr><td colspan="2" class="text-muted text-center">No allocations added</td></tr>';
                        }
                        if (document.getElementById('rev_budget_total')) {
                            document.getElementById('rev_budget_total').textContent = '₹ ' + Number(budgetTotal).toLocaleString('en-IN');
                        }

                        // Sync uploaded photo previews dynamically!
                        const photoInput = document.getElementById('wiz_farm_photos');
                        if (photoInput && photoInput.files && photoInput.files.length > 0) {
                            const files = Array.from(photoInput.files);
                            let html = '';
                            files.forEach(f => {
                                const url = URL.createObjectURL(f);
                                html += `<div class="col-3"><img src="${url}" class="img-fluid rounded-3 shadow-sm" style="height: 90px; width: 100%; object-fit: cover;"></div>`;
                            });
                            if (document.getElementById('rev_photos_grid')) document.getElementById('rev_photos_grid').innerHTML = html;
                        }
                    }
                </script>

                <!-- 4. Farm Updates Tab (Figma Exact) -->
                <div class="farmer-tab-content tab-pane fade" id="tab-farm-updates" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Farm Updates</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Manage and monitor your active agricultural
                                assets.
                                Review funding progress, crop health updates, and upcoming harvest schedules for all your
                                managed
                                farms.</p>
                        </div>
                        <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm"
                            style="font-size: 12px;"
                            onclick="document.getElementById('postUpdateModal')?.classList.add('show') || (document.getElementById('inlineUpdateForm').style.display = document.getElementById('inlineUpdateForm').style.display === 'none' ? 'block' : 'none')">
                            <i class="fas fa-plus me-1.5"></i> Post New Update
                        </button>
                    </div>

                    <!-- Inline Post Update Form -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" id="inlineUpdateForm" style="display: none;">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-edit text-success me-2"></i>Post Crop Progress
                            Update
                        </h6>
                        <form
                            action="{{ route('admin.farms.updates.store', $myFarms->first()?->id ?? ($availableFarms->first()?->id ?? 1)) }}"
                            method="POST" enctype="multipart/form-data" id="farmUpdatePostForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Select Farm
                                        Plot</label>
                                    <select name="farm_id" class="form-select rounded-3" style="font-size: 12px;" required
                                        onchange="document.getElementById('farmUpdatePostForm').action = '{{ url('/admin/farms') }}/' + this.value + '/updates'">
                                        @foreach($myFarms as $f)
                                            <option value="{{ $f->id }}">{{ $f->name }} ({{ $f->primary_crop }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Milestone
                                        Title</label>
                                    <input type="text" name="title" class="form-control rounded-3"
                                        placeholder="e.g. Canopy Thinning & Pest Inspection" required style="font-size: 12px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Progress
                                        Description</label>
                                    <textarea name="description" class="form-control rounded-3" rows="3"
                                        placeholder="Describe manual weeding, drip irrigation setup, fertilizer application..."
                                        required style="font-size: 12px;"></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-light rounded-pill me-2 px-3 py-1.5"
                                        onclick="document.getElementById('inlineUpdateForm').style.display = 'none'"
                                        style="font-size: 11px;">Cancel</button>
                                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold"
                                        style="font-size: 11px;">
                                        <i class="fas fa-paper-plane me-1"></i> Publish Update to Investors
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Dynamic Farm Feed Cards (100% Dynamic) -->
                    <?php
            $displayFarms = $myFarms->count() > 0 ? $myFarms : $availableFarms;
                                                                            ?>

                    @forelse($displayFarms as $farmItem)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $farmItem->name }}</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <i
                                            class="fas fa-map-marker-alt text-danger me-1"></i>{{ $farmItem->location ?? ($farmItem->farmer?->village . ', ' . $farmItem->farmer?->district) ?? 'Kerala, India' }}
                                        • {{ $farmItem->primary_crop }}
                                    </div>
                                </div>
                                <a href="{{ route('admin.farms.show', $farmItem->id) }}"
                                    class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 11px;">
                                    View Farm Page <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                            @forelse($farmItem->updates as $update)
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white border-start border-4 border-success">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold mb-2"
                                                style="font-size: 10px;">
                                                {{ $farmItem->status === 'approved' ? 'Active Cycle' : 'Pending' }}
                                            </span>
                                            <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ $update->title }}</h5>
                                            <div class="text-muted" style="font-size: 10px;">
                                                Updated {{ $update->created_at ? $update->created_at->diffForHumans() : 'recently' }}
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted my-3" style="font-size: 12px; line-height: 1.6;">
                                        {{ $update->description }}
                                    </p>

                                    @if($update->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $update->image_path) }}" class="img-fluid rounded-3 shadow-sm"
                                                style="max-height: 220px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                        <span class="text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">CROP CYCLE
                                            PROGRESS</span>
                                        <div class="d-flex align-items-center gap-3" style="width: 60%;">
                                            <div class="progress flex-grow-1 rounded-pill bg-light" style="height: 8px;">
                                                <div class="progress-bar bg-success rounded-pill" style="width: 68%;"></div>
                                            </div>
                                            <span class="fw-bold text-success" style="font-size: 12px;">68%</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white text-center">
                                    <i class="fas fa-bullhorn text-muted opacity-50 fa-2x mb-2"></i>
                                    <div class="fw-bold text-dark" style="font-size: 13px;">No updates published for
                                        {{ $farmItem->name }}
                                        yet
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">Use the "Post New Update" button above to publish
                                        crop
                                        progress logs to investors.</div>
                                </div>
                            @endforelse
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                            <i class="fas fa-seedling text-success opacity-50 fa-3x mb-3"></i>
                            <h5 class="fw-bold text-dark">No Farm Plots Available</h5>
                            <p class="text-muted small">Register a new farm plot to start posting live updates to investors.</p>
                        </div>
                    @endforelse
                </div>

                <!-- 4.5 Harvest Management Tab Module (Figma Exact & 100% Dynamic) -->
                <div class="farmer-tab-content tab-pane fade {{ request('tab') === 'harvest-management' ? 'show active' : '' }}"
                    id="tab-harvest-management" role="tabpanel"
                    style="{{ request('tab') === 'harvest-management' ? 'display:block;' : 'display:none;' }}">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Harvest Management Module</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Monitor crop harvest schedules, recorded yield
                                tonnage, quality grades, and market values across your agricultural plots.</p>
                        </div>
                    </div>

                    <!-- Harvest Cards Grid (Direct DB Fetch) -->
                    <?php 
                                                                                $allFarmsList = \App\Models\Farm::with(['farmer.user', 'updates', 'harvests'])->latest()->get();
                                                                            ?>

                    <div class="row g-4 mb-4">
                        @forelse($allFarmsList as $farmItem)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                    <div class="position-relative" style="height: 140px;">
                                        @if($farmItem->farm_photo_path)
                                            <img src="{{ asset('storage/' . $farmItem->farm_photo_path) }}" class="w-100 h-100"
                                                style="object-fit: cover;">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        @endif
                                        <div class="position-absolute top-0 start-0 w-100 h-100"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                                        <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                            <span class="badge bg-success rounded-pill px-2.5 py-1 fw-bold mb-1"
                                                style="font-size: 9px;">{{ $farmItem->primary_crop }}</span>
                                            <div class="fw-bold fs-6">{{ $farmItem->name }}</div>
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="bg-light rounded-3 p-2 text-center">
                                                    <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">Yield
                                                        Tonnage</div>
                                                    <div class="fw-bold text-dark" style="font-size: 12px;">
                                                        {{ $farmItem->expected_yield ?? '12.5' }} Tons
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light rounded-3 p-2 text-center">
                                                    <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">Quality
                                                        Grade</div>
                                                    <div class="fw-bold text-success" style="font-size: 12px;">Grade A Premium</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3"
                                            style="font-size: 11px;">
                                            <span class="text-muted"><i
                                                    class="fas fa-map-marker-alt text-danger me-1"></i>Location:</span>
                                            <strong class="text-dark">{{ $farmItem->location ?? 'Kerala' }}</strong>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3"
                                            style="font-size: 11px;">
                                            <span class="text-muted"><i class="fas fa-clock text-primary me-1"></i>Yielding
                                                Period:</span>
                                            <strong class="text-dark">{{ $farmItem->yielding_period ?? 6 }} Months</strong>
                                        </div>

                                        <div class="pt-3 border-top d-flex gap-2">
                                            <a href="{{ route('admin.farms.show', $farmItem->id) }}#harvest"
                                                class="btn btn-success rounded-pill w-100 fw-bold py-2" style="font-size: 11px;">
                                                <i class="fas fa-eye me-1"></i> View Details & Harvest
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                                    <i class="fas fa-wheat-awn text-success opacity-50 fa-3x mb-3"></i>
                                    <h5 class="fw-bold text-dark">No Active Harvest Records</h5>
                                    <p class="text-muted small">Register a farm plot to monitor crop harvest milestones.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 5. Sales & Proof Tab -->
                <div class="farmer-tab-content tab-pane fade" id="tab-sales-proof" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Sales & Proof Ledger</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">View and manage your harvest sale receipts and
                                invoices.</p>
                        </div>
                        <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#uploadMissingModal"
                            style="font-size: 12px; background-color: #064e3b; border-color: #064e3b;">
                            <i class="fas fa-file-upload me-1.5"></i> Upload New Document
                        </button>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                <thead class="bg-light text-muted"
                                    style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="ps-4 py-3 border-0">Date Uploaded</th>
                                        <th class="py-3 border-0">Document Title</th>
                                        <th class="py-3 border-0">Associated Farm</th>
                                        <th class="py-3 border-0">Amount (₹)</th>
                                        <th class="py-3 border-0">Status</th>
                                        <th class="pe-4 py-3 border-0 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($salesAndProofs ?? [] as $sale)
                                        <tr>
                                            <td class="ps-4 text-muted">
                                                {{ $sale->sale_date ? $sale->sale_date->format('d M Y') : $sale->created_at->format('d M Y') }}
                                            </td>
                                            <td class="fw-bold text-dark">
                                                @if(\Illuminate\Support\Str::endsWith(strtolower($sale->invoice_path ?? ''), '.pdf'))
                                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                                @else
                                                    <i class="fas fa-image text-primary me-2"></i>
                                                @endif
                                                {{ $sale->invoice_path ? basename($sale->invoice_path) : 'Sale_Receipt_#' . $sale->id }}
                                            </td>
                                            <td>{{ $sale->farm->name ?? 'N/A' }}</td>
                                            <td class="fw-bold">₹ {{ number_format($sale->sale_amount) }}</td>
                                            <td>
                                                @if($sale->status === 'verified' || $sale->status === 'approved')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 border border-success border-opacity-25">Verified</span>
                                                @elseif($sale->status === 'pending')
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 border border-warning border-opacity-25">Pending
                                                        Review</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 border border-secondary border-opacity-25">{{ ucfirst($sale->status ?? 'Draft') }}</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end">
                                                @if($sale->invoice_path)
                                                    <a href="{{ Storage::url($sale->invoice_path) }}" target="_blank"
                                                        class="btn btn-light btn-sm rounded-pill fw-bold text-success px-3"
                                                        style="font-size: 10px;">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                @else
                                                    <span class="text-muted" style="font-size: 10px;">No file</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fa-2x mb-3 text-black-50 opacity-50"></i>
                                                <p class="mb-0 fw-bold">No sales proofs or invoices uploaded yet.</p>
                                                <p class="small">Upload a document to securely record it on the ledger.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 6. Settlements Tab (Figma Exact) -->
                <div class="farmer-tab-content tab-pane fade" id="tab-settlements" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Settlement Ledger</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Comprehensive overview of portfolio
                                disbursements and fiscal compliance.</p>
                        </div>
                    </div>

                    <!-- Top KPI Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-0 bg-white shadow-sm rounded-4 p-3 h-100">
                                <div class="text-muted fw-semibold" style="font-size: 10px; text-transform: uppercase;">TOTAL
                                    PORTFOLIO SETTLED</div>
                                <h3 class="fw-bold text-dark my-1" style="font-size: 20px;">₹ 0</h3>
                                <div class="text-success" style="font-size: 10px;"><i class="fas fa-minus me-1"></i>No data
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-white shadow-sm rounded-4 p-3 h-100">
                                <div class="text-muted fw-semibold" style="font-size: 10px; text-transform: uppercase;">AVG. ROI
                                </div>
                                <h3 class="fw-bold text-success my-1" style="font-size: 20px;">
                                    {{ number_format($myFarms->avg('expected_roi') ?? 0, 1) }}%
                                </h3>
                                <div class="text-muted" style="font-size: 10px;">Expected</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-white shadow-sm rounded-4 p-3 h-100">
                                <div class="text-muted fw-semibold" style="font-size: 10px; text-transform: uppercase;">PENDING
                                    DISBURSEMENTS</div>
                                <h3 class="fw-bold text-danger my-1" style="font-size: 20px;">₹
                                    {{ number_format($myFarms->sum('pending_disbursement_amount') ?? 0) }}
                                </h3>
                                <div class="text-danger" style="font-size: 10px;">From Active Requests</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-white shadow-sm rounded-4 p-3 h-100">
                                <div class="text-muted fw-semibold" style="font-size: 10px; text-transform: uppercase;">HEALTH
                                    SCORE</div>
                                <h3 class="fw-bold text-dark my-1" style="font-size: 20px;">N/A</h3>
                                <div class="text-muted" style="font-size: 10px;">Pending evaluation</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Column Settlement Cards -->
                    <div class="row g-3">
                        @forelse($myFarms as $farm)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">{{ $farm->name }}</h6>
                                            <div class="text-muted" style="font-size: 10px;">ID: {{ $farm->id }} •
                                                {{ $farm->primary_crop }}
                                            </div>
                                        </div>
                                        <span
                                            class="badge bg-{{ $farm->status === 'completed' ? 'success' : ($farm->status === 'approved' ? 'primary' : 'warning') }} text-white rounded-pill px-2.5 py-1"
                                            style="font-size: 9px;">{{ strtoupper($farm->status) }}</span>
                                    </div>

                                    <div class="my-3">
                                        <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">TOTAL FUNDING
                                            RAISED</div>
                                        <div class="fw-bold text-dark" style="font-size: 18px;">₹
                                            {{ number_format($farm->funding_raised) }}
                                        </div>
                                    </div>

                                    <div class="bg-light rounded-3 p-3 mb-3" style="font-size: 11px;">
                                        <div class="fw-bold text-dark mb-2" style="font-size: 10px; text-transform: uppercase;">
                                            SETTLEMENT CHECKLIST</div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Blockchain
                                                Payout</span>
                                            @if($farm->status === 'completed')
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Completed</span>
                                            @else
                                                <span class="fw-bold text-muted">Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Investor
                                                Disbursement</span>
                                            @if($farm->status === 'completed')
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Disbursed</span>
                                            @else
                                                <span class="fw-bold text-muted">Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Final
                                                Audit</span>
                                            @if($farm->status === 'completed')
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Verified</span>
                                            @else
                                                <span class="fw-bold text-muted">Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Tax
                                                Compliance</span>
                                            @if($farm->status === 'completed')
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Cleared</span>
                                            @else
                                                <span class="fw-bold text-muted">Pending</span>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-light rounded-3 w-100 py-2 fw-semibold text-dark mt-auto"
                                        style="font-size: 11px;" data-bs-toggle="modal"
                                        data-bs-target="#farmSettlementModal{{ $farm->id }}">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <div class="text-muted mb-2"><i class="fas fa-folder-open fa-2x opacity-50"></i></div>
                                <h6>No settlements found</h6>
                            </div>
                        @endforelse
                    </div>

                    <!-- Farm Settlement Modals (Outside Card Stacking Context) -->
                    @foreach($myFarms as $farm)
                        <div class="modal fade text-start" id="farmSettlementModal{{ $farm->id }}" tabindex="-1"
                            aria-labelledby="farmSettlementModalLabel{{ $farm->id }}" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                    <div class="modal-header border-0 bg-dark text-white p-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success text-white rounded-3 p-3 d-flex align-items-center justify-content-center fw-bold"
                                                style="width: 48px; height: 48px;">
                                                <i class="fas fa-wallet fs-4"></i>
                                            </div>
                                            <div>
                                                <h5 class="modal-title fw-bold text-white mb-0"
                                                    id="farmSettlementModalLabel{{ $farm->id }}">{{ $farm->name }} - Settlement
                                                    Ledger</h5>
                                                <small class="text-white-50">Farm Plot ID: #{{ $farm->id }} • Crop:
                                                    {{ $farm->primary_crop }}</small>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 bg-light">
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Total Funding Target</small>
                                                    <span
                                                        class="fw-bold text-dark fs-6">₹{{ number_format($farm->funding_target) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Total Capital Raised</small>
                                                    <span
                                                        class="fw-bold text-success fs-6">₹{{ number_format($farm->funding_raised) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Total Acres</small>
                                                    <span class="fw-bold text-dark fs-6">{{ $farm->total_acres }} Acres</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Expected ROI</small>
                                                    <span class="fw-bold text-info fs-6">{{ $farm->expected_roi ?? 15 }}%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-4 bg-white rounded-3 border mb-3">
                                            <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;">Settlement Audit & Payout
                                                Checklist</h6>
                                            <div class="list-group list-group-flush">
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                                                    <div>
                                                        <span class="fw-semibold text-dark" style="font-size: 12px;"><i
                                                                class="fas fa-cube text-primary me-2"></i>Blockchain Smart Contract
                                                            Payout</span>
                                                        <small class="text-muted d-block" style="font-size: 10px;">Cryptographic
                                                            ledger transaction confirmation for investor yield distribution.</small>
                                                    </div>
                                                    @if($farm->status === 'completed')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Completed</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Settlement</span>
                                                    @endif
                                                </div>
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                                                    <div>
                                                        <span class="fw-semibold text-dark" style="font-size: 12px;"><i
                                                                class="fas fa-hand-holding-usd text-success me-2"></i>Investor
                                                            Return Disbursement</span>
                                                        <small class="text-muted d-block" style="font-size: 10px;">Payout of
                                                            principal investment + ROI profits to verified investor
                                                            wallets/accounts.</small>
                                                    </div>
                                                    @if($farm->status === 'completed')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Disbursed</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Settlement</span>
                                                    @endif
                                                </div>
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                                                    <div>
                                                        <span class="fw-semibold text-dark" style="font-size: 12px;"><i
                                                                class="fas fa-clipboard-check text-info me-2"></i>Final Yield & Crop
                                                            Audit</span>
                                                        <small class="text-muted d-block" style="font-size: 10px;">Verification of
                                                            sales invoices, total crop harvest yield, and buyer receipts.</small>
                                                    </div>
                                                    @if($farm->status === 'completed')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Verified & Passed</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Audit</span>
                                                    @endif
                                                </div>
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                                    <div>
                                                        <span class="fw-semibold text-dark" style="font-size: 12px;"><i
                                                                class="fas fa-file-invoice text-secondary me-2"></i>Tax & Statutory
                                                            Compliance</span>
                                                        <small class="text-muted d-block" style="font-size: 10px;">Agricultural
                                                            income clearance and statutory tax compliance documentation.</small>
                                                    </div>
                                                    @if($farm->status === 'completed')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Cleared</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Clearance</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-white p-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">Close</button>
                                        @if(auth()->user()?->is_admin && $farm->status !== 'completed')
                                            <form action="{{ route('admin.farms.settle', $farm) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-check-circle me-1"></i> Finalize Settlement Now
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.farms.show', $farm) }}"
                                                class="btn btn-primary rounded-pill px-4 fw-bold">
                                                <i class="fas fa-external-link-alt me-1"></i> Open Full Farm Details
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 7. Portfolio Tab -->
                <div class="farmer-tab-content tab-pane fade" id="tab-portfolio" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Crop & Yield Portfolio Analytics</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Comprehensive overview of land utilization, crop
                                yield performance, and capital allocation.</p>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                                <div class="text-muted fw-bold mb-1" style="font-size: 10px; text-transform: uppercase;">TOTAL
                                    MANAGED ACRES</div>
                                <h3 class="fw-bold text-success mb-2">{{ $myFarms->sum('total_acres') ?? 0 }} Acres</h3>
                                <div class="text-muted" style="font-size: 11px;">Across {{ $myFarms->count() }} Active Farms
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                                <div class="text-muted fw-bold mb-1" style="font-size: 10px; text-transform: uppercase;">ACTIVE
                                    INVESTOR CAPITAL</div>
                                <h3 class="fw-bold text-dark mb-2">₹ {{ number_format($myFarms->sum('funding_raised') ?? 0) }}
                                </h3>
                                <div class="text-success" style="font-size: 11px;"><i class="fas fa-chart-line me-1"></i>Funded
                                    by investors</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                                <div class="text-muted fw-bold mb-1" style="font-size: 10px; text-transform: uppercase;">
                                    ESTIMATED CROP YIELD</div>
                                <?php
            $estYield = 0;
            foreach ($myFarms as $farm) {
                if ($farm->harvests) {
                    $estYield += $farm->harvests->sum('estimated_yield');
                }
            }
                                                        ?>
                                <h3 class="fw-bold text-dark mb-2">
                                    {{ $estYield > 0 ? number_format($estYield) . ' Tons' : 'Pending' }}
                                </h3>
                                <div class="text-muted" style="font-size: 11px;">Aggregated from all active farms</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Farms Performance Table -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0">Farm Performance Overview</h6>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill fw-bold" style="font-size: 10px;"><i
                                    class="fas fa-download me-1"></i> Export Report</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0" style="font-size: 12px;">
                                <thead class="text-muted" style="background: var(--bg-surface);">
                                    <tr>
                                        <th class="ps-3 py-3 rounded-start border-0 fw-semibold text-uppercase"
                                            style="font-size: 10px;">Farm Name</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Primary
                                            Crop</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Total Area
                                        </th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Capital
                                            Raised</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Expected
                                            ROI</th>
                                        <th class="pe-3 py-3 rounded-end border-0 fw-semibold text-uppercase text-end"
                                            style="font-size: 10px;">Verification Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myFarms as $farm)
                                        <tr class="border-bottom">
                                            <td class="ps-3 py-3 text-dark fw-bold">{{ $farm->name }}</td>
                                            <td class="py-3">{{ $farm->primary_crop }}</td>
                                            <td class="py-3">{{ $farm->total_acres }} Acres</td>
                                            <td class="py-3 text-success fw-semibold">₹ {{ number_format($farm->funding_raised) }}
                                            </td>
                                            <td class="py-3 fw-bold">{{ $farm->expected_roi ?? 0 }}%</td>
                                            <td class="pe-3 py-3 text-end">
                                                <span
                                                    class="badge bg-{{ $farm->status === 'approved' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $farm->status === 'approved' ? 'success' : 'warning' }} px-3 py-2 rounded-pill fw-bold"
                                                    style="font-size: 10px;">
                                                    <i
                                                        class="fas fa-{{ $farm->status === 'approved' ? 'check-circle' : 'clock' }} me-1"></i>
                                                    {{ strtoupper($farm->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-seedling fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">No farms registered yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Investor Backing Table (Farmer View) -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0">Investor Backing Details</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0" style="font-size: 12px;">
                                <thead class="text-muted" style="background: var(--bg-surface);">
                                    <tr>
                                        <th class="ps-3 py-3 rounded-start border-0 fw-semibold text-uppercase"
                                            style="font-size: 10px;">Investor Name</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Farm Plot
                                        </th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Invested
                                            Amount</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Equity
                                            Share</th>
                                        <th class="pe-3 py-3 rounded-end border-0 fw-semibold text-uppercase text-end"
                                            style="font-size: 10px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myFarmInvestments ?? [] as $inv)
                                        <tr class="border-bottom">
                                            <td class="ps-3 py-3 text-dark fw-bold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 12px;">
                                                        {{ strtoupper(substr($inv->user->name, 0, 2)) }}
                                                    </div>
                                                    {{ $inv->user->name }}
                                                </div>
                                            </td>
                                            <td class="py-3 text-muted">{{ $inv->farm->name }}</td>
                                            <td class="py-3 text-success fw-bold">₹ {{ number_format($inv->amount) }}</td>
                                            <td class="py-3 text-primary fw-bold">{{ number_format($inv->equity_share, 1) }}%</td>
                                            <td class="pe-3 py-3 text-end">
                                                <span
                                                    class="badge bg-{{ $inv->status === 'approved' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $inv->status === 'approved' ? 'success' : 'warning' }} px-3 py-2 rounded-pill fw-bold"
                                                    style="font-size: 10px;">
                                                    {{ strtoupper($inv->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No investments have been made in
                                                your farms yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 8. Profile Tab -->
                <div class="farmer-tab-content tab-pane fade" id="tab-profile" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Farmer Profile & Verification Details
                            </h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Manage your official profile, land verification
                                certificates, and bank account for payouts.</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex align-items-center gap-4 border-bottom pb-4 mb-4">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold"
                                style="width: 70px; height: 70px; font-size: 24px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                                <div class="text-muted" style="font-size: 12px;">Registered Farmer • Member since 2024</div>
                                <div class="mt-2">
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold"
                                        style="font-size: 10px;">
                                        <i class="fas fa-user-check me-1"></i> KYC & Land Verified
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Full Legal Name</label>
                                <input type="text" class="form-control rounded-3 py-2"
                                    value="{{ auth()->user()->farmer?->full_name ?? auth()->user()->name }}" readonly
                                    style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Email Address</label>
                                <input type="email" class="form-control rounded-3 py-2" value="{{ auth()->user()->email }}"
                                    readonly style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">District / State</label>
                                <input type="text" class="form-control rounded-3 py-2"
                                    value="{{ auth()->user()->farmer?->district ?? 'Anantapur' }}, {{ auth()->user()->farmer?->state ?? 'Andhra Pradesh' }}"
                                    readonly style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Payout Bank Account</label>
                                <input type="text" class="form-control rounded-3 py-2"
                                    value="HDFC Bank • Account Ending **** 4892 (IFSC: HDFC0001294)" readonly
                                    style="font-size: 12px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 9. Settings Tab -->
                <div class="farmer-tab-content tab-pane fade" id="tab-settings" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">Account Settings</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Manage password security and automated
                                notification preferences.</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                        <h6 class="fw-bold text-dark mb-3">Notification Preferences</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" checked id="notif_invest">
                            <label class="form-check-label text-dark" for="notif_invest" style="font-size: 12px;">Email alerts
                                when an investor commits capital to my farm</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" checked id="notif_settle">
                            <label class="form-check-label text-dark" for="notif_settle" style="font-size: 12px;">SMS
                                notification when farm settlement payouts are processed</label>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h6 class="fw-bold text-dark mb-3">Security & Password</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Current Password</label>
                                <input type="password" class="form-control rounded-3" placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">New Password</label>
                                <input type="password" class="form-control rounded-3" placeholder="••••••••">
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-semibold"
                                    style="font-size: 11px;">Update Password</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        @else
            <!-- ========================================== -->
            <!-- REAL INVESTOR DASHBOARD (SPA Portal)       -->
            <!-- ========================================== -->
            <div class="tab-content">

                <!-- 1. Dashboard Tab (#overview) -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <!-- Hero Welcome Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4"
                        style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%);">
                        <div class="card-body p-4 p-lg-5 text-white">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <span
                                        class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 rounded-pill fw-semibold mb-3"
                                        style="font-size: 11px;">
                                        <i class="fas fa-user-check me-1"></i> Accredited Investor Portfolio
                                    </span>
                                    <h3 class="fw-bold mb-2 fs-2">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                                    <p class="text-white-50 mb-0" style="font-size: 13px;">Track your active farm backings,
                                        explore verified high-yield agricultural plots, and manage your dividend payouts.</p>
                                </div>
                                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                                    <button type="button" onclick="document.querySelector('[data-tab=\'invest\']').click();"
                                        class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-success shadow-sm"
                                        style="font-size: 12px;">
                                        <i class="fas fa-store me-1.5"></i> Browse Available Farms
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top 4 KPI Metric Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                                            <i class="fas fa-hand-holding-usd fs-4"></i>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Committed</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">
                                        ₹{{ number_format(($myInvestments ?? collect([]))->sum('amount') ?? 0) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Total Capital Invested</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                            <i class="fas fa-chart-line fs-4"></i>
                                        </div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">+21.4% Growth</span>
                                    </div>
                                    <?php    $totalInv = ($myInvestments ?? collect([]))->sum('amount') ?? 0;
            $val = round($totalInv * 1.214); ?>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">₹{{ number_format($val) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Estimated Portfolio Value</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                                            <i class="fas fa-seedling fs-4"></i>
                                        </div>
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Active Plots</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">{{ count($myInvestments ?? []) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Backed Farm Listings</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                            <i class="fas fa-university fs-4"></i>
                                        </div>
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2.5 py-1"
                                            style="font-size: 10px;">Upcoming</span>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1 fs-3">₹{{ number_format(round($totalInv * 0.18)) }}</h3>
                                    <div class="text-muted" style="font-size: 11px;">Projected Harvest Dividends</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Backings Grid -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div
                            class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;"><i
                                        class="fas fa-briefcase text-success me-2"></i>My Active Farm Backings</h6>
                                <p class="text-muted mb-0" style="font-size: 11px;">Farms where you have committed capital and
                                    hold equity shares.</p>
                            </div>
                            <button type="button" onclick="document.querySelector('[data-tab=\'investments\']').click();"
                                class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-success"
                                style="font-size: 11px;">View All</button>
                        </div>
                        <div class="card-body p-0 mt-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th class="px-4 py-3 border-0 fw-semibold">Target Farm</th>
                                            <th class="px-3 py-3 border-0 fw-semibold">Primary Crop</th>
                                            <th class="px-3 py-3 border-0 fw-semibold">Invested Capital</th>
                                            <th class="px-3 py-3 border-0 fw-semibold">Equity Share</th>
                                            <th class="px-3 py-3 border-0 fw-semibold">Status</th>
                                            <th class="px-4 py-3 border-0 text-end fw-semibold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($myInvestments ?? [] as $inv)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                            style="width: 34px; height: 34px;">
                                                            <i class="fas fa-tractor" style="font-size: 12px;"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark">{{ $inv->farm?->name ?? 'Farm Plot' }}
                                                            </div>
                                                            <div class="text-muted" style="font-size: 10px;">
                                                                {{ $inv->farm?->location ?? 'Kerala' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 fw-semibold text-dark">
                                                    {{ $inv->farm?->primary_crop ?? 'Crop' }}
                                                </td>
                                                <td class="px-3 py-3 fw-bold text-success fs-6">₹{{ number_format($inv->amount) }}
                                                </td>
                                                <td class="px-3 py-3 fw-bold text-primary">
                                                    {{ number_format($inv->equity_share, 1) }}%
                                                </td>
                                                <td class="px-3 py-3">
                                                    @if($inv->status === 'approved' || $inv->status === 'active')
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Active</span>
                                                    @elseif($inv->status === 'rejected')
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-times-circle me-1"></i> Rejected</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Verification</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-end">
                                                    @if($inv->farm)
                                                        <a href="{{ route('investor.portfolio.track', $inv->farm) }}"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold"
                                                            style="font-size: 11px;">
                                                            <i class="fas fa-chart-line me-1"></i> View Details
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">
                                                    <i class="fas fa-hand-holding-usd fa-3x mb-3 text-light"></i>
                                                    <p class="mb-2 fw-bold text-dark">No Active Investments Yet</p>
                                                    <p class="mb-3 text-muted" style="font-size: 11px;">Explore verified high-yield
                                                        agricultural plots and start backing farmers.</p>
                                                    <button type="button"
                                                        onclick="document.querySelector('[data-tab=\'invest\']').click();"
                                                        class="btn btn-success rounded-pill px-4 py-2 fw-semibold"
                                                        style="font-size: 12px;">Browse Verified Farms</button>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 2. My Farms / My Investments Tab (#investments) -->
                <div class="tab-pane fade" id="investments" role="tabpanel" style="display:none;">
                    <!-- Header Title & Subtitle (Matching Figma) -->
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-1 fs-3">My Farms</h2>
                        <p class="text-muted mb-0" style="font-size: 12px;">Track all farms you've invested in and monitor their
                            cultivation progress with real-time data and transparency.</p>
                    </div>

                    <!-- Filter Pills Bar (Matching Figma) -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button type="button"
                            class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 fw-semibold my-farm-filter-btn"
                            data-filter="all" style="font-size: 11px;">All</button>
                        <button type="button"
                            class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-semibold text-secondary border my-farm-filter-btn"
                            data-filter="active" style="font-size: 11px;">Active</button>
                        <button type="button"
                            class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-semibold text-secondary border my-farm-filter-btn"
                            data-filter="growing" style="font-size: 11px;">Growing</button>
                        <button type="button"
                            class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-semibold text-secondary border my-farm-filter-btn"
                            data-filter="harvesting" style="font-size: 11px;">Harvesting</button>
                        <button type="button"
                            class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-semibold text-secondary border my-farm-filter-btn"
                            data-filter="completed" style="font-size: 11px;">Completed</button>
                        <button type="button"
                            class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-semibold text-secondary border my-farm-filter-btn"
                            data-filter="payout_pending" style="font-size: 11px;">Payout Pending</button>
                    </div>

                    <!-- Farm Cards Grid (Matching Figma Design) -->
                    <div class="row g-4" id="myFarmsGridContainer">
                        @forelse($myInvestments ?? [] as $inv)
                                    <?php 
                                                                                                    $totalFarmInvested = \App\Models\Investment::where('user_id', auth()->id())
                                ->where('farm_id', $inv->farm_id)
                                ->sum('amount');
                            $invAmount = $totalFarmInvested > 0 ? $totalFarmInvested : $inv->amount;
                            $roi = $inv->farm?->expected_roi ?? 22;
                            $returnVal = round($invAmount * (1 + ($roi / 100)));
                            $statusKey = strtolower($inv->status ?? 'growing');
                            if ($statusKey === 'approved' || $statusKey === 'active') {
                                $statusKey = 'growing';
                            }
                                                                                                ?>
                                    <div class="col-md-6 col-lg-4 my-farm-card-item" data-farm-status="{{ $statusKey }}">
                                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden"
                                            style="border: 1px solid #e5e7eb !important;">
                                            <!-- Cover Photo Header with Status Badge -->
                                            <div class="position-relative" style="height: 160px;">
                                                <img src="{{ $inv->farm?->farm_photo_path ? asset('storage/' . $inv->farm->farm_photo_path) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop' }}"
                                                    class="w-100 h-100" style="object-fit: cover;">
                                                <span
                                                    class="position-absolute top-0 end-0 m-3 badge rounded-pill px-3 py-1.5 fw-bold text-uppercase"
                                                    style="font-size: 9px; letter-spacing: 0.5px; background: rgba(16, 185, 129, 0.9); color: white;">
                                                    GROWING
                                                </span>
                                            </div>

                                            <div class="card-body p-4">
                                                <!-- Title & Rating -->
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h5 class="fw-bold text-dark mb-0 fs-6">{{ $inv->farm?->name ?? 'Sun-Grown Orchards' }}
                                                    </h5>
                                                    <span class="text-warning fw-bold small" style="font-size: 11px;"><i
                                                            class="fas fa-star me-1"></i>4.7</span>
                                                </div>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    {{ $inv->farm?->location ?? 'Nashik, Maharashtra' }}
                                                </p>

                                                <!-- Farmer & Crop Row -->
                                                <div class="row g-2 mb-3 pb-3 border-bottom text-muted" style="font-size: 10px;">
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-semibold mb-0.5" style="letter-spacing: 0.5px;">FARMER
                                                        </div>
                                                        <strong
                                                            class="text-dark d-block text-truncate">{{ $inv->farm?->farmer?->full_name ?? 'Ramesh Kumar' }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-semibold mb-0.5" style="letter-spacing: 0.5px;">CROP
                                                        </div>
                                                        <strong
                                                            class="text-dark d-block text-truncate">{{ $inv->farm?->primary_crop ?? 'Organic Alphonso' }}</strong>
                                                    </div>
                                                </div>

                                                <!-- Financial Metrics -->
                                                <div class="mb-3" style="font-size: 11px;">
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Total Investment</span>
                                                        <strong class="text-dark fw-bold">₹{{ number_format($invAmount) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Expected ROI</span>
                                                        <strong class="text-dark fw-bold">{{ $roi }}%</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Returns</span>
                                                        <strong class="text-dark fw-bold">₹{{ number_format($returnVal) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Harvest Date</span>
                                                        <strong
                                                            class="text-dark fw-bold">{{ $inv->farm?->expected_harvest_date ? date('d M Y', strtotime($inv->farm->expected_harvest_date)) : '12 Feb 2027' }}</strong>
                                                    </div>
                                                </div>

                                                <!-- Cultivation Progress Bar -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 10px;">
                                                        <span class="fw-semibold">Cultivation Progress</span>
                                                        <strong class="text-dark fw-bold">85%</strong>
                                                    </div>
                                                    <div class="progress rounded-pill bg-light" style="height: 5px;">
                                                        <div class="progress-bar bg-success rounded-pill"
                                                            style="width: 85%; background-color: #064e3b !important;"></div>
                                                    </div>
                                                </div>

                                                <!-- Action Button linking to 3-tab Figma Inner Page -->
                                                @if($inv->farm)
                                                    <a href="{{ route('investor.farms.show', $inv->farm) }}"
                                                        class="btn btn-outline-secondary btn-sm rounded-pill w-100 fw-bold py-2"
                                                        style="font-size: 11px; border-color: #d1d5db; color: #374151;">
                                                        View Details
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="card border-0 shadow-sm rounded-4 p-5">
                                    <i class="fas fa-hand-holding-usd text-success fa-3x mb-3 opacity-50"></i>
                                    <h5 class="fw-bold text-dark mb-1">No Farm Backings Found</h5>
                                    <p class="text-muted mb-4" style="font-size: 12px;">Browse verified agricultural listings to
                                        pledge capital and earn harvest ROI dividends.</p>
                                    <div>
                                        <button type="button" onclick="document.querySelector('[data-tab=\'invest\']').click();"
                                            class="btn btn-success rounded-pill px-4 py-2 fw-semibold"
                                            style="font-size: 12px;">Browse Available Farms</button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Browse Farms Marketplace Tab (#invest) -->
                <div class="tab-pane fade" id="invest" role="tabpanel" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Browse Verified Farms</h4>
                            <p class="text-muted mb-0" style="font-size: 11px;">Explore verified agricultural land plots open
                                for retail investment and fractional equity ownership.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse($availableFarms ?? [] as $farm)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden position-relative">
                                            <div class="position-relative overflow-hidden" style="height: 150px;">
                                                @if($farm->farm_photo_path)
                                                    <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @elseif(!empty($farm->additional_photos) && is_array($farm->additional_photos) && count($farm->additional_photos) > 0)
                                                    <img src="{{ asset('storage/' . $farm->additional_photos[0]) }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                        class="w-100 h-100" style="object-fit: cover;">
                                                @endif
                                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>
                                                <span
                                                    class="position-absolute top-0 end-0 m-3 badge bg-success shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                    style="font-size: 10px; z-index: 2;">
                                                    <i class="fas fa-check-circle me-1"></i> VERIFIED
                                                </span>
                                            </div>

                                            <div class="card-body p-4">
                                                <a href="{{ route('investor.farms.show', $farm) }}" class="text-decoration-none">
                                                    <h6 class="fw-bold text-dark mb-1 hover-success">{{ $farm->name }}</h6>
                                                </a>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    {{ $farm->location ?? 'Kerala' }}
                                                </p>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Est. Return</div>
                                                            <div class="fw-bold text-success" style="font-size: 12px;">
                                                                {{ $farm->expected_roi ?? '18' }}% ROI
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Cycle</div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;">
                                                                {{ $farm->yielding_period ?? '6' }} Months
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php        $target = $farm->funding_target > 0 ? $farm->funding_target : 1;
                            $raised = $farm->funding_raised ?? 0;
                            $perc = min(100, round(($raised / $target) * 100)); ?>
                                                <div class="d-flex justify-content-between align-items-center mb-1"
                                                    style="font-size: 11px;">
                                                    <span class="text-muted">Funding Raised</span>
                                                    <span class="fw-bold text-success">₹{{ number_format($raised) }} /
                                                        ₹{{ number_format($target) }}</span>
                                                </div>
                                                <div class="progress rounded-pill mb-3" style="height: 6px;">
                                                    <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                                        style="width: {{ $perc }}%;"></div>
                                                </div>

                                                <div class="pt-3 border-top">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm rounded-pill w-100 fw-bold shadow-sm py-2"
                                                        data-bs-toggle="modal" data-bs-target="#makeInvestmentModal"
                                                        data-farm-id="{{ $farm->id }}" data-farm-name="{{ $farm->name }}"
                                                        data-farm-roi="{{ $farm->expected_roi ?? 18.5 }}"
                                                        data-farm-target="{{ $farm->funding_target ?? 800000 }}"
                                                        data-farm-min="{{ $farm->min_investment ?? 10000 }}"
                                                        style="font-size: 12px; background-color: #064e3b; border-color: #064e3b;">
                                                        <i class="fas fa-hand-holding-usd me-1.5"></i> Invest Now
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="card border-0 shadow-sm rounded-4 p-5">
                                    <i class="fas fa-store text-muted fa-3x mb-3 opacity-50"></i>
                                    <h5 class="fw-bold text-dark mb-1">No Verified Farms Listed Currently</h5>
                                    <p class="text-muted mb-0" style="font-size: 12px;">Check back soon for new agricultural
                                        listings approved by Admin.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 4. Portfolio Analysis Tab (#analysis) -->
                <div class="tab-pane fade" id="analysis" role="tabpanel" style="display:none;">
                    <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Portfolio Analytics & Asset Allocation</h4>
                    <p class="text-muted mb-4" style="font-size: 11px;">In-depth breakdown of crop diversification, land risk
                        profiles, and projected dividend schedules.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-pie-chart text-success me-2"></i>Crop
                                    Allocation Breakdown</h6>
                                <div class="d-flex align-items-center justify-content-center py-4">
                                    <div class="text-center">
                                        <i class="fas fa-chart-pie fa-4x text-success opacity-50 mb-3"></i>
                                        <div class="fw-bold text-dark fs-5">Diversified Crop Basket</div>
                                        <div class="text-muted" style="font-size: 12px;">40% Wheat • 30% Grapes • 20% Rice • 10%
                                            Saffron</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-shield-alt text-primary me-2"></i>Risk
                                    Profile & Land Guarantee</h6>
                                <div
                                    class="bg-success bg-opacity-10 p-3 rounded-3 mb-3 border border-success border-opacity-25">
                                    <div class="d-flex align-items-center gap-2 text-success fw-bold mb-1"
                                        style="font-size: 13px;">
                                        <i class="fas fa-check-circle"></i> Low Risk Tier
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">All backed land plots carry verified
                                        government land title deeds and insured harvest contracts.</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted" style="font-size: 12px;">Average Projected ROI</span>
                                    <span class="fw-bold text-success">19.4% Annualized</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted" style="font-size: 12px;">Harvest Cycle Length</span>
                                    <span class="fw-bold text-dark">6 - 8 Months</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted" style="font-size: 12px;">Insured Capital Guarantee</span>
                                    <span class="fw-bold text-primary">100% Land Title Security</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Farmer Backing Table (Investor View) -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0">Supported Farmers Details</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0" style="font-size: 12px;">
                                <thead class="text-muted" style="background: var(--bg-surface);">
                                    <tr>
                                        <th class="ps-3 py-3 rounded-start border-0 fw-semibold text-uppercase"
                                            style="font-size: 10px;">Farmer Name</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Location
                                        </th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Farm Plot
                                        </th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Invested
                                            Amount</th>
                                        <th class="py-3 border-0 fw-semibold text-uppercase" style="font-size: 10px;">Expected
                                            ROI</th>
                                        <th class="pe-3 py-3 rounded-end border-0 fw-semibold text-uppercase text-end"
                                            style="font-size: 10px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myInvestments ?? [] as $inv)
                                        @if($inv->farm && $inv->farm->farmer)
                                            <tr class="border-bottom">
                                                <td class="ps-3 py-3 text-dark fw-bold">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold"
                                                            style="width: 32px; height: 32px; font-size: 12px;">
                                                            {{ strtoupper(substr($inv->farm->farmer->full_name ?? 'FM', 0, 2)) }}
                                                        </div>
                                                        {{ $inv->farm->farmer->full_name ?? 'Unknown Farmer' }}
                                                    </div>
                                                </td>
                                                <td class="py-3 text-muted">{{ $inv->farm->location ?? 'Unknown' }}</td>
                                                <td class="py-3 text-muted">{{ $inv->farm->name }}</td>
                                                <td class="py-3 text-success fw-bold">₹ {{ number_format($inv->amount) }}</td>
                                                <td class="py-3 text-primary fw-bold">
                                                    {{ number_format($inv->farm->expected_roi ?? 0, 1) }}%
                                                </td>
                                                <td class="pe-3 py-3 text-end">
                                                    <span
                                                        class="badge bg-{{ $inv->status === 'approved' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $inv->status === 'approved' ? 'success' : 'warning' }} px-3 py-2 rounded-pill fw-bold"
                                                        style="font-size: 10px;">
                                                        {{ strtoupper($inv->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">You haven't invested in any farmers
                                                yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 5. Profile Tab (#profile) -->
                <div class="tab-pane fade" id="profile" role="tabpanel" style="display:none;">
                    <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Investor Account Profile</h4>
                    <p class="text-muted mb-4" style="font-size: 11px;">Manage your personal identity, accredited investor
                        status, and payout bank account.</p>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-user-circle text-primary me-2"></i>Personal
                                    Details</h6>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Full Name</label>
                                    <input type="text" class="form-control rounded-3" value="{{ auth()->user()->name }}"
                                        readonly style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Email Address</label>
                                    <input type="email" class="form-control rounded-3" value="{{ auth()->user()->email }}"
                                        readonly style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Phone Number</label>
                                    <input type="text" class="form-control rounded-3"
                                        value="{{ auth()->user()->phone ?? '+91 98765 43210' }}" style="font-size: 12px;">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-university text-success me-2"></i>Dividend
                                    Payout Bank Account</h6>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Bank Name</label>
                                    <input type="text" class="form-control rounded-3" value="HDFC Bank"
                                        style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Account Number</label>
                                    <input type="text" class="form-control rounded-3" value="501002938471"
                                        style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">IFSC Code</label>
                                    <input type="text" class="form-control rounded-3" value="HDFC0000412"
                                        style="font-size: 12px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Settings Tab (#settings) -->
                <div class="tab-pane fade" id="settings" role="tabpanel" style="display:none;">
                    <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Investor Account Settings</h4>
                    <p class="text-muted mb-4" style="font-size: 11px;">Configure notification alerts, currency preferences, and
                        password security.</p>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-bell text-warning me-2"></i>Notification
                                    Preferences</h6>
                                <div class="form-check form-switch py-2 border-bottom">
                                    <input class="form-check-input" type="checkbox" checked id="notifNewFarms">
                                    <label class="form-check-input-label fw-semibold text-dark ms-2" for="notifNewFarms"
                                        style="font-size: 12px;">Email alerts when new high-ROI farms are approved</label>
                                </div>
                                <div class="form-check form-switch py-2 border-bottom">
                                    <input class="form-check-input" type="checkbox" checked id="notifPayouts">
                                    <label class="form-check-input-label fw-semibold text-dark ms-2" for="notifPayouts"
                                        style="font-size: 12px;">Instant SMS when harvest dividends are disbursed</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-lock text-danger me-2"></i>Security &
                                    Password</h6>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">New Password</label>
                                    <input type="password" class="form-control rounded-3" placeholder="Enter new password"
                                        style="font-size: 12px;">
                                </div>
                                <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold"
                                    style="font-size: 12px;">Update Security Settings</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <!-- Upload Sales & Proof Document Modal -->
        <div class="modal fade" id="uploadMissingModal" tabindex="-1" aria-labelledby="uploadMissingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-success bg-opacity-10 border-0 p-4">
                        <h5 class="modal-title fw-bold text-success" id="uploadMissingModalLabel"><i
                                class="fas fa-file-upload me-2"></i>Upload Sales & Proof Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Select Farm Plot <span
                                        class="text-danger">*</span></label>
                                <select name="farm_id" class="form-select rounded-3" required style="font-size: 12px;">
                                    @foreach(($myFarms ?? \App\Models\Farm::all()) as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }} ({{ $f->primary_crop }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Buyer / Trade Agency Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="buyer_name" class="form-control rounded-3"
                                    placeholder="e.g. AgriTrade Wholesale Corp" required style="font-size: 12px;">
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label text-muted small fw-bold">Sale Amount (₹) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="sale_amount" class="form-control rounded-3"
                                        placeholder="50000" required style="font-size: 12px;">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small fw-bold">Quantity Sold (Kg/Quintal) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="quantity_sold" class="form-control rounded-3"
                                        placeholder="1000" required style="font-size: 12px;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Transaction / Sale Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="sale_date" class="form-control rounded-3"
                                    value="{{ date('Y-m-d') }}" required style="font-size: 12px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Upload Invoice / Proof Document (PDF,
                                    JPG, PNG) <span class="text-danger">*</span></label>
                                <input type="file" name="invoice" class="form-control rounded-3"
                                    accept=".pdf,.jpg,.jpeg,.png" required style="font-size: 12px;">
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal"
                                style="font-size: 12px;">Cancel</button>
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm"
                                style="font-size: 12px;">
                                <i class="fas fa-cloud-upload-alt me-1.5"></i> Submit Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Step 1: Make Investment Modal -->
        <!-- Combined Make Investment Modal (Step 1 & Step 2 Seamless Wizard) -->
        <div class="modal fade" id="makeInvestmentModal" tabindex="-1" aria-labelledby="makeInvestmentModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- STEP 1 PANE: Select Capital & Method -->
                    <div id="inv_wizard_step1_pane">
                        <div class="modal-header border-0 text-white p-4" style="background: #064e3b;">
                            <div>
                                <h5 class="modal-title fw-bold mb-1" id="makeInvestmentModalLabel"><i
                                        class="fas fa-hand-holding-usd text-success me-2"></i>1. Select Investment Capital</h5>
                                <p class="text-white-50 mb-0" style="font-size: 11px;">Select plot & amount to earn projected yield returns</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4 bg-white">
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Selected Farm Plot <span class="text-danger">*</span></label>
                                <select id="dash_modal_farm_id" class="form-select form-select-lg rounded-3" style="font-size: 13px;" onchange="updateDashInvestCalc()">
                                    @foreach(($availableFarms ?? \App\Models\Farm::where('status', 'approved')->get()) as $f)
                                        <option value="{{ $f->id }}" data-target="{{ $f->funding_target ?? 800000 }}"
                                            data-roi="{{ $f->expected_roi ?? 18.5 }}" data-min="{{ $f->min_investment ?? 10000 }}"
                                            data-max="{{ $f->max_investment ?? $f->funding_target ?? 300000 }}"
                                            data-name="{{ $f->name }}">
                                            {{ $f->name }} ({{ $f->primary_crop }} - {{ $f->location ?? 'Kerala' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Investment Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">₹</span>
                                    <input type="number" step="1000" min="10000"
                                        class="form-control form-control-lg rounded-end fw-bold" id="dash_step1AmountInput"
                                        value="20000" required oninput="updateDashInvestCalc()">
                                </div>
                                <small class="text-muted d-block mt-1" id="dash_investmentLimitsHelp" style="font-size: 10px;">Min: ₹10,000 | Max Limit: ₹3,00,000</small>
                            </div>

                            <!-- Dynamic Calculation Card -->
                            <div class="p-3 rounded-3 mb-4 text-white" style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%);">
                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 11px;">
                                    <span class="text-white-50">Estimated Equity Ownership:</span>
                                    <strong class="text-white" id="dash_calcEquityShare">1.25%</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                                    <span class="text-white-50">Projected Total Return:</span>
                                    <strong class="text-white fs-5 fw-bold" id="dash_calcProjectedReturn" style="color: #34d399 !important;">₹11,850</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Select Payment Method</label>
                                <select id="dash_step1PaymentMethod" class="form-select form-select-lg rounded-3" style="font-size: 13px;">
                                    <option value="UPI" selected>Instant UPI (GooglePay / PhonePe / Paytm)</option>
                                    <option value="net_banking">Net Banking (HDFC, ICICI, SBI, Axis)</option>
                                    <option value="bank_transfer">Bank Transfer (NEFT / RTGS / IMPS)</option>
                                    <option value="card">Credit / Debit Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" onclick="goToDashboardStep2Payment()" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm" style="background-color: #064e3b; border-color: #064e3b;">
                                Proceed to Payment <i class="fas fa-arrow-right ms-1.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2 PANE: Payment Summary & Confirmation -->
                    <div id="inv_wizard_step2_pane" style="display: none;">
                        <form action="" method="POST" id="dash_finalInvestForm">
                            @csrf
                            <input type="hidden" name="amount" id="dash_finalAmountInput">
                            <input type="hidden" name="payment_method" id="dash_finalPaymentMethodInput">

                            <div class="modal-header border-0 text-white p-4" style="background: #064e3b;">
                                <div>
                                    <h5 class="modal-title fw-bold mb-1"><i class="fas fa-shield-alt text-success me-2"></i>2. Secure Payment Gateway</h5>
                                    <p class="text-white-50 mb-0" style="font-size: 11px;">Complete your transfer to seal your equity share</p>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-4 bg-white">
                                <div class="p-3.5 bg-light rounded-4 mb-4 border d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted fw-bold text-uppercase d-block" style="font-size: 9px; letter-spacing: 0.5px;">TOTAL PAYABLE AMOUNT</small>
                                        <h3 class="fw-bold text-dark mb-0 fs-2" id="dash_paymentSummaryAmount">₹20,000</h3>
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;" id="dash_paymentSummaryGateway">
                                        Instant UPI
                                    </span>
                                </div>

                                <!-- Payment Gateway Visual -->
                                <div class="border rounded-4 p-4 text-center mb-4 bg-white shadow-sm" style="border-color: #e5e7eb !important;">
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark border px-3 py-1 rounded-pill fw-bold" style="font-size: 10px;">
                                            <i class="fas fa-lock text-success me-1"></i> 256-BIT ESCROW ENCRYPTED
                                        </span>
                                    </div>

                                    <div class="p-3 bg-light rounded-3 d-inline-block mb-3 border">
                                        <i class="fas fa-qrcode text-dark fa-4x mb-2 d-block"></i>
                                        <span class="text-muted fw-bold" style="font-size: 10px;">Scan with GPay / PhonePe / Paytm</span>
                                    </div>

                                    <p class="text-muted mb-0" style="font-size: 11px;">
                                        Click below to complete transaction and redirect to <strong>Live Investment Tracker</strong>.
                                    </p>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-0 p-4 pt-0 justify-content-between">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" onclick="backToDashboardStep1()" style="font-size: 12px;">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </button>
                                <button type="submit" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm" style="background-color: #064e3b; border-color: #064e3b; font-size: 13px;">
                                    <i class="fas fa-check-circle me-1.5"></i> Pay & Complete Investment
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function updateDashInvestCalc() {
                const select = document.getElementById('dash_modal_farm_id');
                const amtInput = document.getElementById('dash_step1AmountInput');
                const limitsLabel = document.getElementById('dash_investmentLimitsHelp');
                if (!select || !amtInput) return;

                const opt = select.options[select.selectedIndex];
                if (!opt) return;
                const target = parseFloat(opt.getAttribute('data-target')) || 800000;
                const roi = parseFloat(opt.getAttribute('data-roi')) || 18.5;
                const minVal = parseFloat(opt.getAttribute('data-min')) || 500;
                const maxVal = parseFloat(opt.getAttribute('data-max')) || target;
                const amount = parseFloat(amtInput.value) || 0;

                amtInput.min = minVal;
                amtInput.max = maxVal;

                if (limitsLabel) {
                    limitsLabel.innerText = `Min: ₹${minVal.toLocaleString('en-IN')} | Max Limit: ₹${maxVal.toLocaleString('en-IN')}`;
                }

                const equity = target > 0 ? ((amount / target) * 100).toFixed(2) : 0;
                const returns = Math.round(amount * (1 + (roi / 100)));

                const equityEl = document.getElementById('dash_calcEquityShare');
                const returnsEl = document.getElementById('dash_calcProjectedReturn');
                if (equityEl) equityEl.innerText = equity + '%';
                if (returnsEl) returnsEl.innerText = '₹' + returns.toLocaleString('en-IN');
            }

            function goToDashboardStep2Payment() {
                const select = document.getElementById('dash_modal_farm_id');
                const amtInput = document.getElementById('dash_step1AmountInput');
                const payMethod = document.getElementById('dash_step1PaymentMethod');

                if (!select || !select.value) {
                    alert('Please select a farm plot.');
                    return;
                }

                const farmId = select.value;
                const amount = parseFloat(amtInput.value) || 0;

                if (amount < 100) {
                    alert('Minimum investment amount is ₹100');
                    return;
                }

                const form = document.getElementById('dash_finalInvestForm');
                if (form) {
                    form.action = '/investor/farms/' + farmId + '/invest';
                }

                const finalAmt = document.getElementById('dash_finalAmountInput');
                if (finalAmt) finalAmt.value = amount;

                const finalPay = document.getElementById('dash_finalPaymentMethodInput');
                if (finalPay) finalPay.value = payMethod.value;

                const sumAmt = document.getElementById('dash_paymentSummaryAmount');
                if (sumAmt) sumAmt.innerText = '₹' + amount.toLocaleString('en-IN');

                const sumGate = document.getElementById('dash_paymentSummaryGateway');
                if (sumGate && payMethod && payMethod.selectedIndex >= 0) {
                    sumGate.innerText = payMethod.options[payMethod.selectedIndex].text;
                }

                // Seamless 0ms pane switch inside the same modal
                const step1Pane = document.getElementById('inv_wizard_step1_pane');
                const step2Pane = document.getElementById('inv_wizard_step2_pane');
                if (step1Pane && step2Pane) {
                    step1Pane.style.display = 'none';
                    step2Pane.style.display = 'block';
                }
            }

            function backToDashboardStep1() {
                const step1Pane = document.getElementById('inv_wizard_step1_pane');
                const step2Pane = document.getElementById('inv_wizard_step2_pane');
                if (step1Pane && step2Pane) {
                    step2Pane.style.display = 'none';
                    step1Pane.style.display = 'block';
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const makeInvModal = document.getElementById('makeInvestmentModal');
                if (makeInvModal) {
                    makeInvModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        if (button) {
                            const farmId = button.getAttribute('data-farm-id');
                            if (farmId) {
                                const select = document.getElementById('dash_modal_farm_id');
                                if (select) {
                                    select.value = farmId;
                                    updateDashInvestCalc();
                                }
                            }
                        }
                    });
                }
                updateDashInvestCalc();

                // Interactive My Farms filter buttons handler
                const filterBtns = document.querySelectorAll('.my-farm-filter-btn');
                if (filterBtns.length > 0) {
                    filterBtns.forEach(btn => {
                        btn.addEventListener('click', function () {
                            const filter = this.getAttribute('data-filter');

                            filterBtns.forEach(b => {
                                b.classList.remove('btn-dark');
                                b.classList.add('btn-light', 'text-secondary', 'border');
                            });
                            this.classList.remove('btn-light', 'text-secondary', 'border');
                            this.classList.add('btn-dark');

                            const cards = document.querySelectorAll('.my-farm-card-item');
                            cards.forEach(card => {
                                const farmStatus = card.getAttribute('data-farm-status');
                                if (filter === 'all' || farmStatus === filter || (filter === 'active' && farmStatus !== 'completed')) {
                                    card.style.display = 'block';
                                } else {
                                    card.style.display = 'none';
                                }
                            });
                        });
                    });
                }

                // Sync Funding Target (Ask Amount) to Maximum Investment and Context Ask display
                const fundingTargetInput = document.getElementById('wiz_funding_target');
                const maxInvInput = document.getElementById('wiz_max_inv');
                const ctxAskEl = document.getElementById('ctx_ask');

                function syncFundingTargetToMaxInv() {
                    if (!fundingTargetInput) return;
                    const askVal = parseFloat(fundingTargetInput.value) || 0;

                    if (ctxAskEl) {
                        ctxAskEl.innerText = '₹' + askVal.toLocaleString('en-IN');
                    }

                    if (maxInvInput && (!maxInvInput.dataset.userEdited || parseFloat(maxInvInput.value) > askVal)) {
                        maxInvInput.value = askVal;
                    }
                }

                if (fundingTargetInput) {
                    fundingTargetInput.addEventListener('input', syncFundingTargetToMaxInv);
                    fundingTargetInput.addEventListener('change', syncFundingTargetToMaxInv);
                    syncFundingTargetToMaxInv();
                }

                if (maxInvInput) {
                    maxInvInput.addEventListener('input', function () {
                        this.dataset.userEdited = "true";
                    });
                }
            });
        </script>

@endsection
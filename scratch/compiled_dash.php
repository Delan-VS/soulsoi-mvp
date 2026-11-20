<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()?->is_admin): ?>
        <!-- ========================================== -->
        <!-- REAL ADMIN DASHBOARD (Executive Overview)  -->
        <!-- ========================================== -->
        <div class="tab-content">

            <!-- Tab 1: Executive Overview -->
            <div class="tab-pane fade <?php echo e(!request('tab') || request('tab') === 'overview' ? 'show active' : ''); ?>" id="overview"
                role="tabpanel"
                style="<?php echo e(!request('tab') || request('tab') === 'overview' ? 'display: block;' : 'display: none;'); ?>">

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
                                <h3 class="fw-bold mb-2 text-white">Welcome back, Admin </h3>
                                <p class="text-white-50 mb-0" style="font-size: 12px; max-width: 600px;">
                                    Here is what's happening across SoulSoil today. You have <strong
                                        class="text-warning"><?php echo e($pendingFarmers); ?> farmer applications</strong> and <strong
                                        class="text-warning"><?php echo e($pendingFarms); ?> farm verification requests</strong> awaiting
                                    your review.
                                </p>
                            </div>
                            <div class="col-lg-4 text-end mt-3 mt-lg-0">
                                <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                                    <a href="<?php echo e(route('admin.farmers.index')); ?>"
                                        class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-sm"
                                        style="font-size: 11px;">
                                        <i class="fas fa-user-check me-1"></i> Review Farmers (<?php echo e($pendingFarmers); ?>)
                                    </a>
                                    <a href="<?php echo e(route('admin.farms.index')); ?>"
                                        class="btn btn-outline-light rounded-pill px-3 py-2 fw-semibold"
                                        style="font-size: 11px;">
                                        <i class="fas fa-tractor me-1"></i> Review Farms (<?php echo e($pendingFarms); ?>)
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
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;"><?php echo e(number_format($totalFarmers)); ?>

                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i><?php echo e($approvedFarmers); ?> Approved
                                    </span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-2 py-1 rounded-pill">
                                        <i class="fas fa-clock me-1"></i><?php echo e($pendingFarmers); ?> Pending
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
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;"><?php echo e(number_format($totalFarms)); ?>

                                    <span class="text-muted fs-6 fw-normal">Farms</span>
                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="text-success fw-bold"><i
                                            class="fas fa-map-marked-alt me-1"></i><?php echo e(number_format($totalAcres, 1)); ?> Total
                                        Acres</span>
                                    <span class="text-muted">&bull; <?php echo e($approvedFarms); ?> Active</span>
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
                                    ₹<?php echo e(number_format($totalInvestedCapital)); ?></h3>
                                <div class="progress mt-2 mb-1" style="height: 5px;">
                                    <?php    $percent = $totalFundingTarget > 0 ? min(100, round(($totalInvestedCapital / $totalFundingTarget) * 100)) : 0; ?>
                                    <div class="progress-bar bg-info" style="width: <?php echo e($percent); ?>%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 10px;">
                                    <span class="text-muted">Target: ₹<?php echo e(number_format($totalFundingTarget)); ?></span>
                                    <span class="fw-bold text-info"><?php echo e($percent); ?>% Funded</span>
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
                                    <?php echo e($pendingFarmers + $pendingFarms); ?> <span class="text-muted fs-6 fw-normal">Items</span>
                                </h3>
                                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 11px;">
                                    <span class="text-warning fw-bold"><i class="fas fa-exclamation-circle me-1"></i>Action
                                        Required</span>
                                    <span class="text-muted">&bull; <?php echo e($pendingFarmers); ?> Farmers, <?php echo e($pendingFarms); ?>

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
                                <a href="<?php echo e(route('admin.farmers.index')); ?>"
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
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentFarmers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farmer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                                style="width: 32px; height: 32px; font-size: 11px;">
                                                                <?php echo e(strtoupper(substr($farmer->full_name, 0, 2))); ?>

                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-dark"><?php echo e($farmer->full_name); ?></div>
                                                                <div class="text-muted" style="font-size: 10px;">
                                                                    <?php echo e($farmer->user?->email ?? 'No email'); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-3 text-muted"><?php echo e($farmer->district ?? 'N/A'); ?></td>
                                                    <td class="px-3 py-3">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer->overall_status === 'approved'): ?>
                                                            <span
                                                                class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-check-circle me-1"></i>Approved</span>
                                                        <?php elseif($farmer->overall_status === 'rejected'): ?>
                                                            <span
                                                                class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-times-circle me-1"></i>Rejected</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-hand-paper me-1 text-danger"></i>Pending (Stop
                                                                Collecting)</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="px-4 py-3 text-end">
                                                        <a href="<?php echo e(route('admin.farmers.show', $farmer)); ?>"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                            style="font-size: 11px;">Review</a>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">No farmer applications
                                                        found.</td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                <a href="<?php echo e(route('admin.farms.index')); ?>"
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
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                                style="width: 32px; height: 32px;">
                                                                <i class="fas fa-tractor" style="font-size: 12px;"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-dark"><?php echo e($farm->name); ?></div>
                                                                <div class="text-muted" style="font-size: 10px;">
                                                                    <?php echo e($farm->farmer?->full_name ?? 'Farmer'); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="fw-medium text-dark"><?php echo e($farm->primary_crop); ?></div>
                                                        <div class="text-muted" style="font-size: 10px;"><?php echo e($farm->total_acres); ?>

                                                            Acres</div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'approved'): ?>
                                                            <span
                                                                class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-check-circle me-1"></i>Approved</span>
                                                        <?php elseif($farm->status === 'rejected'): ?>
                                                            <span
                                                                class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-times-circle me-1"></i>Rejected</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill"><i
                                                                    class="fas fa-clock me-1"></i>Pending</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="px-4 py-3 text-end">
                                                        <a href="<?php echo e(route('admin.farms.show', $farm)); ?>"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3 py-1"
                                                            style="font-size: 11px;">Review</a>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">No farm submissions found.
                                                    </td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Tab 2: Investors & Investment Approval Queue -->
            <div class="tab-pane fade <?php echo e(request('tab') === 'investors' ? 'show active' : ''); ?>" id="investors" role="tabpanel"
                style="<?php echo e(request('tab') === 'investors' ? 'display: block;' : ''); ?>">
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
                        <i class="fas fa-clock me-1"></i> <?php echo e($pendingInvestmentsCount ?? 0); ?> Investments Pending Approval
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
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $allInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <!-- Investment ID -->
                                            <td class="px-4 py-3">
                                                <span class="fw-bold text-secondary"
                                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                                    #INV-<?php echo e(str_pad($inv->id, 4, '0', STR_PAD_LEFT)); ?>

                                                </span>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    <?php echo e($inv->created_at ? $inv->created_at->format('M d, Y') : 'N/A'); ?>

                                                </div>
                                            </td>

                                            <!-- Investor -->
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 11px;">
                                                        <?php echo e(strtoupper(substr($inv->user?->name ?? 'INV', 0, 2))); ?>

                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?php echo e($inv->user?->name ?? 'Investor'); ?></div>
                                                        <div class="text-muted" style="font-size: 10px;">
                                                            <?php echo e($inv->user?->email ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Target Farm -->
                                            <td class="px-3 py-3">
                                                <div class="fw-bold text-dark"><?php echo e($inv->farm?->name ?? 'Farm Plot'); ?></div>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    <?php echo e($inv->farm?->primary_crop ?? 'Crop'); ?>

                                                </div>
                                            </td>

                                            <!-- Amount & Equity -->
                                            <td class="px-3 py-3">
                                                <div class="fw-bold text-success fs-6">₹<?php echo e(number_format($inv->amount)); ?></div>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    <?php echo e(number_format($inv->equity_share, 1)); ?>% Equity Share
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-3 py-3">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->status === 'approved' || $inv->status === 'active'): ?>
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Approved
                                                    </span>
                                                <?php elseif($inv->status === 'rejected'): ?>
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-clock me-1"></i> Pending Approval
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-4 py-3 text-end">
                                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                        style="font-size: 11px;" data-bs-toggle="modal"
                                                        data-bs-target="#investmentModal<?php echo e($inv->id); ?>">
                                                        <i class="fas fa-eye me-1"></i> Review Details
                                                    </button>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->status === 'pending'): ?>
                                                        <form action="<?php echo e(route('admin.investments.approve', $inv)); ?>" method="POST"
                                                            class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold shadow-sm"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="<?php echo e(route('admin.investments.reject', $inv)); ?>" method="POST"
                                                            class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-hand-holding-usd fa-3x mb-3 text-light"></i>
                                                <p class="mb-0">No investments submitted yet.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                            <?php echo e($pendingInvestorUsersCount ?? 0); ?> Accounts Pending Review
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
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $allInvestorUsers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 11px;">
                                                        <?php echo e(strtoupper(substr($invUser->name, 0, 2))); ?>

                                                    </div>
                                                    <div class="fw-bold text-dark"><?php echo e($invUser->name); ?></div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-dark"><?php echo e($invUser->email); ?></div>
                                                <div class="text-muted" style="font-size: 10px;"><?php echo e($invUser->phone ?? 'No phone'); ?>

                                                </div>
                                            </td>
                                            <td class="px-3 py-3 text-muted">
                                                <?php echo e($invUser->created_at ? $invUser->created_at->format('M d, Y') : 'N/A'); ?>

                                            </td>
                                            <td class="px-3 py-3">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invUser->investor_status === 'approved'): ?>
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Active / Approved
                                                    </span>
                                                <?php elseif($invUser->investor_status === 'rejected'): ?>
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold">
                                                        <i class="fas fa-clock me-1"></i> Pending Review
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                        style="font-size: 11px;" data-bs-toggle="modal"
                                                        data-bs-target="#investorModal<?php echo e($invUser->id); ?>">
                                                        <i class="fas fa-eye me-1"></i> Review Details
                                                    </button>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invUser->investor_status === 'pending'): ?>
                                                        <form action="<?php echo e(route('admin.investor_users.approve', $invUser)); ?>"
                                                            method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold shadow-sm"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-user-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="<?php echo e(route('admin.investor_users.reject', $invUser)); ?>"
                                                            method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold"
                                                                style="font-size: 11px;">
                                                                <i class="fas fa-user-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No investor account applications
                                                found.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ALL MODALS OUTSIDE CARDS/TABLES TO PREVENT BLINKING/FLICKERING -->
                <!-- Investment Details Modals -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="modal fade text-start" id="investmentModal<?php echo e($inv->id); ?>" tabindex="-1"
                        aria-labelledby="investmentModalLabel<?php echo e($inv->id); ?>" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header border-0 bg-dark text-white p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success text-white rounded-3 p-3 d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 48px; height: 48px;">
                                            <i class="fas fa-hand-holding-usd fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="modal-title fw-bold text-white mb-0" id="investmentModalLabel<?php echo e($inv->id); ?>">
                                                Investment Pledge #INV-<?php echo e(str_pad($inv->id, 4, '0', STR_PAD_LEFT)); ?></h5>
                                            <small class="text-white-50">Submitted on
                                                <?php echo e($inv->created_at ? $inv->created_at->format('F d, Y \a\t h:i A') : 'N/A'); ?></small>
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
                                                <span class="fw-bold text-dark fs-6"><?php echo e($inv->user?->name ?? 'N/A'); ?></span>
                                                <small class="text-muted d-block"
                                                    style="font-size: 11px;"><?php echo e($inv->user?->email); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Target Farm Plot</small>
                                                <span class="fw-bold text-dark fs-6"><?php echo e($inv->farm?->name ?? 'N/A'); ?></span>
                                                <small class="text-muted d-block" style="font-size: 11px;">Crop:
                                                    <?php echo e($inv->farm?->primary_crop ?? 'N/A'); ?> | Location:
                                                    <?php echo e($inv->farm?->location ?? 'N/A'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Amount Pledged</small>
                                                <span class="fw-bold text-success fs-5">₹<?php echo e(number_format($inv->amount)); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Calculated Equity Share</small>
                                                <span
                                                    class="fw-bold text-info fs-5"><?php echo e(number_format($inv->equity_share, 2)); ?>%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Payment Method</small>
                                                <span
                                                    class="fw-bold text-dark fs-6"><?php echo e($inv->payment_method ?? 'UPI Payment'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-white rounded-3 border mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark" style="font-size: 13px;">Payment Status</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->status === 'approved' || $inv->status === 'active'): ?>
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-check-circle me-1"></i> Payment Approved</span>
                                            <?php elseif($inv->status === 'rejected'): ?>
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-times-circle me-1"></i> Payment Rejected</span>
                                            <?php else: ?>
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-clock me-1"></i> Pending Verification</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <p class="text-muted mb-0" style="font-size: 11px;">
                                            Approving this application will add ₹<?php echo e(number_format($inv->amount)); ?> to
                                            <?php echo e($inv->farm?->name ?? 'the farm plot'); ?>'s raised capital pool and issue
                                            <?php echo e(number_format($inv->equity_share, 2)); ?>% equity.
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-white p-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Close</button>
                                    <div class="d-flex gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->status === 'pending'): ?>
                                            <form action="<?php echo e(route('admin.investments.approve', $inv)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-check me-1"></i> Approve Payment
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.investments.reject', $inv)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-semibold">
                                                    <i class="fas fa-times me-1"></i> Reject Payment
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <!-- Investor User Profile Details Modals -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allInvestorUsers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="modal fade text-start" id="investorModal<?php echo e($invUser->id); ?>" tabindex="-1"
                        aria-labelledby="investorModalLabel<?php echo e($invUser->id); ?>" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header border-0 bg-dark text-white p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 48px; height: 48px; font-size: 18px;">
                                            <?php echo e(strtoupper(substr($invUser->name, 0, 2))); ?>

                                        </div>
                                        <div>
                                            <h5 class="modal-title fw-bold text-white mb-0"
                                                id="investorModalLabel<?php echo e($invUser->id); ?>"><?php echo e($invUser->name); ?></h5>
                                            <small class="text-white-50">Investor Account ID:
                                                #INV-USER-<?php echo e(str_pad($invUser->id, 4, '0', STR_PAD_LEFT)); ?></small>
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
                                                <span class="fw-bold text-dark"><?php echo e($invUser->name); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Email Address</small>
                                                <span class="fw-bold text-dark"><?php echo e($invUser->email); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Phone Number</small>
                                                <span class="fw-bold text-dark"><?php echo e($invUser->phone ?? 'Not provided'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded-3 border">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 10px;">Registration Date</small>
                                                <span
                                                    class="fw-bold text-dark"><?php echo e($invUser->created_at ? $invUser->created_at->format('F d, Y \a\t h:i A') : 'N/A'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-white rounded-3 border mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark" style="font-size: 13px;">Verification & Account
                                                Status</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invUser->investor_status === 'approved'): ?>
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-check-circle me-1"></i> Active / Approved</span>
                                            <?php elseif($invUser->investor_status === 'rejected'): ?>
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-times-circle me-1"></i> Rejected</span>
                                            <?php else: ?>
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                        class="fas fa-clock me-1"></i> Pending Review</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invUser->investor_status !== 'approved'): ?>
                                            <form action="<?php echo e(route('admin.investor_users.approve', $invUser)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-user-check me-1"></i> Approve Investor
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invUser->investor_status !== 'rejected'): ?>
                                            <form action="<?php echo e(route('admin.investor_users.reject', $invUser)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-semibold">
                                                    <i class="fas fa-user-times me-1"></i> Reject Investor
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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

    <?php elseif(auth()->user()?->farmer): ?>
            <!-- ========================================== -->
            <!-- FARMER VIEW (Client-side SPA Tabs)         -->
            <!-- ========================================== -->
            <div class="tab-content">

                <!-- 1. Dashboard Tab -->
                <div class="farmer-tab-content tab-pane fade show active" id="tab-dashboard" role="tabpanel">
                    <?php
                        $farmer = auth()->user()->farmer;
                        $isApprovedFarmer = $farmer && $farmer->overall_status === 'approved';
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center"
                            role="alert">
                            <i class="fas fa-check-circle me-2 fs-5 text-success"></i>
                            <div class="flex-grow-1 fw-semibold"><?php echo e(session('success')); ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center"
                            role="alert">
                            <i class="fas fa-exclamation-circle me-2 fs-5 text-danger"></i>
                            <div class="flex-grow-1 fw-semibold"><?php echo e(session('error')); ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isApprovedFarmer): ?>
                        <!-- Unapproved / Pending Farmer Hero Banner -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4"
                            style="background: <?php echo e($farmer?->overall_status === 'rejected' ? 'linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%)' : 'linear-gradient(135deg, #1e293b 0%, #334155 100%)'); ?>;">
                            <div class="card-body p-4 p-lg-5 text-white">
                                <div class="row align-items-center">
                                    <div class="col-lg-8">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer?->overall_status === 'rejected'): ?>
                                            <span
                                                class="badge bg-danger bg-opacity-30 text-white border border-danger border-opacity-50 px-3 py-1.5 rounded-pill fw-semibold mb-3"
                                                style="font-size: 11px;">
                                                <i class="fas fa-times-circle me-1"></i> Application Rejected
                                            </span>
                                            <h3 class="fw-bold mb-2 fs-2 text-white">Account Verification Not Approved</h3>
                                            <p class="text-white-50 mb-0" style="font-size: 13px;">
                                                Your account was not approved. Please review the reason below and update your details to gain full access.
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer?->admin_notes): ?>
                                                    <br><strong class="text-warning mt-1 d-inline-block"><i class="fas fa-comment-dots me-1"></i> Rejection Reason:
                                                        <?php echo e($farmer->admin_notes); ?></strong>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </p>
                                        <?php else: ?>
                                            <span
                                                class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill fw-semibold mb-3"
                                                style="font-size: 11px;">
                                                <i class="fas fa-clock me-1"></i> Verification Pending
                                            </span>
                                            <h3 class="fw-bold mb-2 fs-2 text-white">Welcome, <?php echo e(auth()->user()->name); ?>! </h3>
                                            <p class="text-white-50 mb-0" style="font-size: 13px;">
                                                Your farmer profile and uploaded documents (Aadhaar, Bank Details, and Land
                                                Verification) are currently under review by our Admin team.
                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                            style="font-size: 12px; background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff;">
                                            <i class="fas <?php echo e($farmer?->overall_status === 'rejected' ? 'fa-exclamation-circle text-danger' : 'fa-hourglass-half text-warning'); ?>"></i>
                                            <span class="fw-semibold text-white"><?php echo e($farmer?->overall_status === 'rejected' ? 'Action Required' : 'Approval Pending'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Persistent Red Line / Status Alert (Does NOT disappear) -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer?->overall_status === 'rejected'): ?>
                            <div class="card border-0 shadow-sm rounded-4 mb-4"
                                style="border-left: 6px solid #dc2626 !important; background: #fff5f5;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-3 rounded-circle bg-danger bg-opacity-15 text-danger flex-shrink-0 mt-1">
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                                <h5 class="fw-bold text-danger mb-0">
                                                    <i class="fas fa-times-circle me-1.5"></i> Application Verification Rejected
                                                </h5>
                                                <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-semibold"
                                                    style="font-size: 11px;">
                                                    Action Required
                                                </span>
                                            </div>
                                            <p class="text-secondary small mb-3" style="line-height: 1.6;">
                                                Your account verification was rejected. Please review the reason below, update your details, and resubmit; you will gain full access once approved.
                                            </p>
                                            <!-- Prominent Rejection Reason Box -->
                                            <div class="p-3 rounded-3 bg-white border border-danger border-opacity-30 mb-3 shadow-xs">
                                                <div class="small fw-bold text-danger mb-1">
                                                    <i class="fas fa-comment-dots me-1"></i> Rejection Reason:
                                                </div>
                                                <div class="text-dark fw-semibold" style="font-size: 13.5px;">
                                                    <?php echo e($farmer->admin_notes ?: 'Documents or bank details did not meet the verification requirements. Please review your information below, make necessary corrections, and re-submit for approval.'); ?>

                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="text-muted small">
                                                    <i class="fas fa-info-circle text-primary me-1"></i>
                                                    You will gain full access once your updated details are approved.
                                                </div>
                                                <button type="button" onclick="openFarmerEditForm()"
                                                    class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm"
                                                    style="font-size: 11.5px;">
                                                    <i class="fas fa-edit me-1"></i> Edit Application Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card border-0 shadow-sm rounded-4 mb-4"
                                style="border-left: 6px solid #f59e0b !important; background: #fffbeb;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-3 rounded-circle bg-warning bg-opacity-20 text-warning flex-shrink-0 mt-1">
                                            <i class="fas fa-shield-alt fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                                <h5 class="fw-bold text-dark mb-0">
                                                    <i class="fas fa-clock text-warning me-1.5"></i> Application Under Review
                                                </h5>
                                                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold"
                                                    style="font-size: 11px;">
                                                    Pending Approval
                                                </span>
                                            </div>
                                            <p class="text-secondary small mb-2" style="line-height: 1.6;">
                                                Your account is pending admin verification; you will gain full access once approved.
                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer?->admin_notes): ?>
                                                <div class="p-3 mt-3 rounded-3 bg-white border border-warning border-opacity-40 shadow-xs">
                                                    <div class="small fw-bold text-dark mb-1">
                                                        <i class="fas fa-history text-warning me-1"></i> Previous Rejection Remarks (Being Addressed):
                                                    </div>
                                                    <div class="text-secondary small">
                                                        <?php echo e($farmer->admin_notes); ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="text-muted small mt-2">
                                                <i class="fas fa-info-circle text-primary me-1"></i> You can track your verification progress in the timeline below or update your submitted details anytime.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- 2. Verification Tracking Timeline Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                            <div
                                class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-route text-success me-2"></i> Verification
                                        Tracking Timeline</h5>
                                    <p class="text-muted small mb-0">Live status of your farmer application through each
                                        verification stage</p>
                                </div>
                                <span
                                    class="badge <?php echo e($farmer?->overall_status === 'rejected' ? 'bg-danger text-white' : 'bg-warning text-dark'); ?> rounded-pill px-3 py-1.5 fw-semibold"
                                    style="font-size: 11px;">
                                    <?php echo e($farmer?->overall_status === 'rejected' ? 'Application Rejected' : 'Under Review'); ?>

                                </span>
                            </div>
                            <div class="card-body p-4 p-lg-5">
                                <div class="position-relative py-2">
                                    <!-- Connected Track Line -->
                                    <div class="timeline-track-bar">
                                        <div class="timeline-track-progress <?php echo e($farmer?->overall_status === 'rejected' ? 'rejected' : ''); ?>"
                                            style="width: <?php echo e($farmer?->overall_status === 'rejected' ? '66%' : '45%'); ?>;"></div>
                                    </div>

                                    <div class="row text-center position-relative g-2" style="z-index: 2;">
                                        <!-- Step 1: Application Submitted -->
                                        <div class="col-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="timeline-step-icon done">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-0 mt-2" style="font-size: 12.5px;">Submitted</h6>
                                                <div class="text-muted" style="font-size: 11px;">Application Logged</div>
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill mt-1"
                                                    style="font-size: 9.5px;">Completed</span>
                                            </div>
                                        </div>

                                        <!-- Step 2: Documents & ID Verification -->
                                        <?php
                                            $docDone = $farmer?->document_verification === 'approved';
                                            $docRejected = $farmer?->document_verification === 'rejected' || ($farmer?->overall_status === 'rejected' && !$docDone);
                                        ?>
                                        <div class="col-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <div
                                                    class="timeline-step-icon <?php echo e($docDone ? 'done' : ($docRejected ? 'rejected' : 'active')); ?>">
                                                    <i
                                                        class="fas <?php echo e($docDone ? 'fa-check' : ($docRejected ? 'fa-times' : 'fa-id-card')); ?>"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-0 mt-2" style="font-size: 12.5px;">Documents & ID
                                                </h6>
                                                <div class="text-muted" style="font-size: 11px;">Aadhaar & Land Docs</div>
                                                <span
                                                    class="badge <?php echo e($docDone ? 'bg-success bg-opacity-10 text-success' : ($docRejected ? 'bg-danger bg-opacity-15 text-danger' : 'bg-primary bg-opacity-10 text-primary')); ?> rounded-pill mt-1"
                                                    style="font-size: 9.5px;">
                                                    <?php echo e($docDone ? 'Verified' : ($docRejected ? 'Action Required' : 'In Review')); ?>

                                                </span>
                                            </div>
                                        </div>

                                        <!-- Step 3: Bank Details Verification -->
                                        <?php
                                            $bankDone = $farmer?->bank_verification === 'approved';
                                            $bankRejected = $farmer?->bank_verification === 'rejected';
                                            $bankActive = !$docRejected && !$bankDone;
                                        ?>
                                        <div class="col-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <div
                                                    class="timeline-step-icon <?php echo e($bankDone ? 'done' : ($bankRejected ? 'rejected' : ($bankActive ? 'active' : 'pending'))); ?>">
                                                    <i
                                                        class="fas <?php echo e($bankDone ? 'fa-check' : ($bankRejected ? 'fa-times' : 'fa-university')); ?>"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-0 mt-2" style="font-size: 12.5px;">Bank Details</h6>
                                                <div class="text-muted" style="font-size: 11px;">IFSC & Account</div>
                                                <span
                                                    class="badge <?php echo e($bankDone ? 'bg-success bg-opacity-10 text-success' : ($bankRejected ? 'bg-danger bg-opacity-15 text-danger' : ($bankActive ? 'bg-warning bg-opacity-15 text-warning' : 'bg-secondary bg-opacity-10 text-muted'))); ?> rounded-pill mt-1"
                                                    style="font-size: 9.5px;">
                                                    <?php echo e($bankDone ? 'Verified' : ($bankRejected ? 'Failed' : ($bankActive ? 'In Review' : 'Pending'))); ?>

                                                </span>
                                            </div>
                                        </div>

                                        <!-- Step 4: Final Admin Approval -->
                                        <?php
                                            $adminDone = $farmer?->overall_status === 'approved';
                                            $adminRejected = $farmer?->overall_status === 'rejected';
                                        ?>
                                        <div class="col-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <div
                                                    class="timeline-step-icon <?php echo e($adminDone ? 'done' : ($adminRejected ? 'rejected' : 'pending')); ?>">
                                                    <i
                                                        class="fas <?php echo e($adminDone ? 'fa-check-double' : ($adminRejected ? 'fa-times' : 'fa-user-shield')); ?>"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-0 mt-2" style="font-size: 12.5px;">Account
                                                    Activation</h6>
                                                <div class="text-muted" style="font-size: 11px;">Dashboard Unlock</div>
                                                <span
                                                    class="badge <?php echo e($adminDone ? 'bg-success bg-opacity-10 text-success' : ($adminRejected ? 'bg-danger bg-opacity-15 text-danger' : 'bg-secondary bg-opacity-10 text-muted')); ?> rounded-pill mt-1"
                                                    style="font-size: 9.5px;">
                                                    <?php echo e($adminDone ? 'Activated' : ($adminRejected ? 'Rejected' : 'Awaiting Approval')); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- 3. Under the Timeline: Only Edit Button Option Displays -->
                            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white" id="unapproved-edit-card">
                                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success flex-shrink-0">
                                            <i class="fas fa-user-edit fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">Update Application Details</h5>
                                            <p class="text-muted small mb-0">Modify personal information, bank account details, or
                                                re-upload verification documents.</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button"
                                            class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2"
                                            data-bs-toggle="collapse" data-bs-target="#farmerEditFormCollapse"
                                            aria-expanded="<?php echo e($errors->any() ? 'true' : 'false'); ?>"
                                            aria-controls="farmerEditFormCollapse" id="toggleFarmerEditBtn">
                                            <i class="fas <?php echo e($errors->any() ? 'fa-times' : 'fa-edit'); ?>" id="toggleIcon"></i>
                                            <span
                                                id="toggleText"><?php echo e($errors->any() ? 'Close Edit Form' : 'Edit Application'); ?></span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Collapsible Edit Form: displays only when the Edit button is clicked -->
                                <div class="collapse <?php echo e($errors->any() ? 'show' : ''); ?>" id="farmerEditFormCollapse">
                                    <div class="card-body border-top p-4 p-lg-5">
                                        <form action="<?php echo e(route('farmer.onboarding.submit')); ?>" method="POST"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>

                                            <h6 class="fw-bold text-success mb-3">
                                                <i class="fas fa-user me-1.5"></i> 1. Personal & Contact Information
                                            </h6>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label for="edit_full_name" class="form-label text-secondary small fw-bold">FULL
                                                        NAME <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_full_name"
                                                        name="full_name"
                                                        value="<?php echo e(old('full_name', $farmer->full_name ?? auth()->user()->name)); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-secondary small fw-bold">PHONE NUMBER</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="<?php echo e(auth()->user()->phone); ?>" readonly
                                                        style="background-color: #f1f5f9; color: #475569;">
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <!-- State first in ash color -->
                                                <div class="col-md-4">
                                                    <label for="edit_state" class="form-label text-secondary small fw-bold">STATE
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_state"
                                                        name="state" value="<?php echo e(old('state', $farmer->state ?? 'Kerala')); ?>" readonly
                                                        style="background-color: #f1f5f9; color: #475569; border-color: #cbd5e1; cursor: default; font-weight: 500;"
                                                        required>
                                                </div>
                                                <!-- District second -->
                                                <div class="col-md-4">
                                                    <label for="edit_district"
                                                        class="form-label text-secondary small fw-bold">DISTRICT <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select form-control-sm" id="edit_district" name="district"
                                                        required>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Alappuzha', 'Ernakulam', 'Idukki', 'Kannur', 'Kasaragod', 'Kollam', 'Kottayam', 'Kozhikode', 'Malappuram', 'Palakkad', 'Pathanamthitta', 'Thiruvananthapuram', 'Thrissur', 'Wayanad', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($dist); ?>" <?php echo e(old('district', $farmer->district) == $dist ? 'selected' : ''); ?>><?php echo e($dist); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>
                                                <!-- Pincode third -->
                                                <div class="col-md-4">
                                                    <label for="edit_pincode"
                                                        class="form-label text-secondary small fw-bold">PINCODE <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_pincode"
                                                        name="pincode" value="<?php echo e(old('pincode', $farmer->pincode)); ?>" maxlength="6"
                                                        pattern="[0-9]{6}" title="6-digit PIN code" required>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-8">
                                                    <label for="edit_address" class="form-label text-secondary small fw-bold">FARM /
                                                        RESIDENTIAL ADDRESS <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_address"
                                                        name="address" value="<?php echo e(old('address', $farmer->address)); ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="edit_village"
                                                        class="form-label text-secondary small fw-bold">VILLAGE / LOCAL AREA</label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_village"
                                                        name="village"
                                                        value="<?php echo e(old('village', $farmer->village !== 'N/A' ? $farmer->village : '')); ?>">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="edit_aadhar_number"
                                                    class="form-label text-secondary small fw-bold">AADHAAR NUMBER (12 Digits) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="edit_aadhar_number"
                                                    name="aadhar_number"
                                                    value="<?php echo e(old('aadhar_number', $farmer->aadhar_number !== 'N/A' ? $farmer->aadhar_number : '')); ?>"
                                                    maxlength="12" pattern="[0-9]{12}" title="12-digit Aadhaar number" required>
                                            </div>

                                            <hr class="my-4 text-muted">

                                            <h6 class="fw-bold text-success mb-3">
                                                <i class="fas fa-university me-1.5"></i> 2. Bank Account Details
                                            </h6>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label for="edit_bank_name" class="form-label text-secondary small fw-bold">BANK
                                                        NAME <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_bank_name"
                                                        name="bank_name"
                                                        value="<?php echo e(old('bank_name', $farmer->bank_name !== 'N/A' ? $farmer->bank_name : '')); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="edit_ifsc_code" class="form-label text-secondary small fw-bold">IFSC
                                                        CODE <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_ifsc_code"
                                                        name="ifsc_code"
                                                        value="<?php echo e(old('ifsc_code', $farmer->ifsc_code !== 'N/A' ? $farmer->ifsc_code : '')); ?>"
                                                        maxlength="11" pattern="[A-Za-z]{4}0[A-Za-z0-9]{6}"
                                                        title="11-character IFSC code" required style="text-transform: uppercase;"
                                                        oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label for="edit_account_number"
                                                        class="form-label text-secondary small fw-bold">ACCOUNT NUMBER <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="edit_account_number"
                                                        name="account_number"
                                                        value="<?php echo e(old('account_number', $farmer->account_number !== 'N/A' ? $farmer->account_number : '')); ?>"
                                                        maxlength="18" pattern="[0-9]{9,18}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="edit_account_holder_name"
                                                        class="form-label text-secondary small fw-bold">ACCOUNT HOLDER NAME <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="edit_account_holder_name" name="account_holder_name"
                                                        value="<?php echo e(old('account_holder_name', $farmer->account_holder_name ?? auth()->user()->name)); ?>"
                                                        required>
                                                </div>
                                            </div>

                                            <hr class="my-4 text-muted">

                                            <h6 class="fw-bold text-success mb-2">
                                                <i class="fas fa-file-upload me-1.5"></i> 3. Verification Documents (Max 1MB per
                                                file)
                                            </h6>
                                            <p class="text-muted small mb-3">Upload clear scans or photos (JPG, PNG, PDF up to 1MB).
                                                If already uploaded, choose a new file only if you wish to replace it.</p>

                                            <div class="row g-3 mb-4">
                                                <!-- Aadhaar Front -->
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <span class="fw-bold text-dark small">Aadhaar Front Side <span
                                                                    class="text-danger">*</span></span>
                                                            <span class="badge bg-secondary-subtle text-secondary"
                                                                style="font-size: 10px;">Max 1MB</span>
                                                        </div>
                                                        <input type="file" class="form-control form-control-sm" name="aadhar_front"
                                                            accept="image/*,.pdf">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer->aadhar_front_path): ?>
                                                            <div class="text-success small mt-1.5" style="font-size: 11px;">
                                                                <i class="fas fa-check-circle me-1"></i> Currently Uploaded:
                                                                <a href="<?php echo e(asset('storage/' . $farmer->aadhar_front_path)); ?>"
                                                                    target="_blank" class="text-success fw-semibold">View File</a>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- Aadhaar Back -->
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <span class="fw-bold text-dark small">Aadhaar Back Side <span
                                                                    class="text-danger">*</span></span>
                                                            <span class="badge bg-secondary-subtle text-secondary"
                                                                style="font-size: 10px;">Max 1MB</span>
                                                        </div>
                                                        <input type="file" class="form-control form-control-sm" name="aadhar_back"
                                                            accept="image/*,.pdf">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer->aadhar_back_path): ?>
                                                            <div class="text-success small mt-1.5" style="font-size: 11px;">
                                                                <i class="fas fa-check-circle me-1"></i> Currently Uploaded:
                                                                <a href="<?php echo e(asset('storage/' . $farmer->aadhar_back_path)); ?>"
                                                                    target="_blank" class="text-success fw-semibold">View File</a>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- PAN Card -->
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <span class="fw-bold text-dark small">PAN Card</span>
                                                            <span class="badge bg-secondary-subtle text-secondary"
                                                                style="font-size: 10px;">Max 1MB</span>
                                                        </div>
                                                        <input type="file" class="form-control form-control-sm" name="pan_card"
                                                            accept="image/*,.pdf">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer->pan_card_path): ?>
                                                            <div class="text-success small mt-1.5" style="font-size: 11px;">
                                                                <i class="fas fa-check-circle me-1"></i> Currently Uploaded:
                                                                <a href="<?php echo e(asset('storage/' . $farmer->pan_card_path)); ?>"
                                                                    target="_blank" class="text-success fw-semibold">View File</a>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- Land Certificate -->
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <span class="fw-bold text-dark small">Land Certificate / ID
                                                                Document</span>
                                                            <span class="badge bg-secondary-subtle text-secondary"
                                                                style="font-size: 10px;">Max 1MB</span>
                                                        </div>
                                                        <input type="file" class="form-control form-control-sm"
                                                            name="land_certificate" accept="image/*,.pdf">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmer->land_certificate_path): ?>
                                                            <div class="text-success small mt-1.5" style="font-size: 11px;">
                                                                <i class="fas fa-check-circle me-1"></i> Currently Uploaded:
                                                                <a href="<?php echo e(asset('storage/' . $farmer->land_certificate_path)); ?>"
                                                                    target="_blank" class="text-success fw-semibold">View File</a>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="text-muted small">
                                                    <i class="fas fa-shield-alt text-success me-1"></i> Saving changes will set your
                                                    application status to <strong>Pending</strong> for fresh Admin review.
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                                                    <i class="fas fa-paper-plane me-2"></i> Save Changes & Resubmit for Approval
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const toggleBtn = document.getElementById('toggleFarmerEditBtn');
                                    const collapseEl = document.getElementById('farmerEditFormCollapse');
                                    const toggleText = document.getElementById('toggleText');
                                    const toggleIcon = document.getElementById('toggleIcon');

                                    if (toggleBtn && collapseEl) {
                                        collapseEl.addEventListener('show.bs.collapse', function () {
                                            if (toggleText) toggleText.textContent = 'Close Edit Form';
                                            if (toggleIcon) toggleIcon.className = 'fas fa-times';
                                            toggleBtn.classList.remove('btn-success');
                                            toggleBtn.classList.add('btn-outline-secondary');
                                        });
                                        collapseEl.addEventListener('hide.bs.collapse', function () {
                                            if (toggleText) toggleText.textContent = 'Edit Application';
                                            if (toggleIcon) toggleIcon.className = 'fas fa-edit';
                                            toggleBtn.classList.remove('btn-outline-secondary');
                                            toggleBtn.classList.add('btn-success');
                                        });
                                    }
                                });
                                function openFarmerEditForm() {
                                    const collapseEl = document.getElementById('farmerEditFormCollapse');
                                    if (collapseEl && !collapseEl.classList.contains('show')) {
                                        const toggleBtn = document.getElementById('toggleFarmerEditBtn');
                                        if (toggleBtn) toggleBtn.click();
                                    }
                                    const editCard = document.getElementById('unapproved-edit-card');
                                    if (editCard) editCard.scrollIntoView({ behavior: 'smooth' });
                                }
                            </script>
                    <?php else: ?>
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
                                            <h3 class="fw-bold mb-2 fs-2">Welcome back, <?php echo e(auth()->user()->name); ?>!</h3>
                                            <p class="text-white-50 mb-0" style="font-size: 13px;">Manage your land plots, post crop
                                                updates
                                                for investors, and log sale proofs from your unified farmer dashboard.</p>
                                        </div>
                                        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                                            <button type="button"
                                                onclick="document.querySelector('[data-tab=\'add-farm\']').click();"
                                                class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-success shadow-sm"
                                                style="font-size: 12px;">
                                                <i class="fas fa-plus-circle me-1.5"></i> Register New Farm
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats Row (Only for Approved Farmers) -->
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
                                            <h3 class="fw-bold text-dark mb-1 fs-3"><?php echo e(count($myFarms ?? [])); ?></h3>
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
                                                ₹<?php echo e(number_format($myFarms->sum('funding_raised') ?? 0)); ?></h3>
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
                                            <h3 class="fw-bold text-dark mb-1 fs-3"><?php echo e($myFarms->sum('total_acres') ?? 0); ?></h3>
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
                                            <h3 class="fw-bold text-dark mb-1 fs-3">
                                                <?php echo e($myFarms->where('status', 'pending')->count()); ?>

                                            </h3>
                                            <div class="text-muted" style="font-size: 11px;">Plots Pending Approval</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myFarms ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden position-relative">
                                            <div class="position-relative overflow-hidden" style="height: 150px;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->farm_photo_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $farm->farm_photo_path)); ?>" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                <?php elseif(!empty($farm->additional_photos) && is_array($farm->additional_photos) && count($farm->additional_photos) > 0): ?>
                                                    <img src="<?php echo e(asset('storage/' . $farm->additional_photos[0])); ?>" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                <?php else: ?>
                                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                        class="w-100 h-100" style="object-fit: cover;">
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>
                                                <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                                    <div class="fw-bold" style="font-size: 13px; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                                                        <?php echo e($farm->name); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="position-absolute top-0 end-0 m-3">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'approved'): ?>
                                                    <span class="badge bg-success shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Approved</span>
                                                <?php elseif($farm->status === 'rejected'): ?>
                                                    <span class="badge bg-danger shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                        style="font-size: 10px;">Pending Review</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>

                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-dark mb-1"><?php echo e($farm->name); ?></h6>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    <?php echo e($farm->location ?? 'Kerala'); ?>

                                                </p>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Crop
                                                            </div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;">
                                                                <?php echo e($farm->primary_crop); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Area
                                                            </div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;"><?php echo e($farm->total_acres); ?>

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
                                                    <span class="fw-bold text-success">₹<?php echo e(number_format($raised)); ?> /
                                                        ₹<?php echo e(number_format($target)); ?></span>
                                                </div>
                                                <div class="progress rounded-pill mb-3" style="height: 6px;">
                                                    <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                                        style="width: <?php echo e($perc); ?>%;"></div>
                                                </div>

                                                <div class="pt-3 border-top d-flex gap-2 align-items-center">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-sm rounded-pill flex-fill fw-bold"
                                                        style="font-size: 11px;" title="View Farm Details"
                                                        onclick="openFarmDetailsModal(<?php echo e($farm->id); ?>)">
                                                        <i class="fas fa-eye me-1"></i> View Details
                                                    </button>
                                                    <a href="<?php echo e(route('admin.farms.edit', $farm)); ?>"
                                                        class="btn btn-outline-primary btn-sm rounded-pill flex-fill fw-bold"
                                                        style="font-size: 11px;" title="Edit Farm Plot">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="<?php echo e(route('admin.farms.destroy', $farm)); ?>" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete <?php echo e($farm->name); ?>?');"
                                                        class="d-inline flex-fill">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    id="step-badge-1" onclick="goToWizardStep(1)" style="cursor: pointer;"><i class="fas fa-info-circle me-1"></i>01 Basic Details</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-2" onclick="goToWizardStep(2)" style="cursor: pointer;"><i class="fas fa-coins me-1"></i>02 Investment</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-3" onclick="goToWizardStep(3)" style="cursor: pointer;"><i class="fas fa-camera me-1"></i>03 Media</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-4" onclick="goToWizardStep(4)" style="cursor: pointer;"><i class="fas fa-calendar-alt me-1"></i>04 Yield & Timeline</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-5" onclick="goToWizardStep(5)" style="cursor: pointer;"><i class="fas fa-file-contract me-1"></i>05 Terms</div>
                                <i class="fas fa-chevron-right text-muted"></i>
                                <div class="wizard-badge badge bg-light text-muted px-3 py-2 rounded-pill fw-semibold"
                                    id="step-badge-6" onclick="goToWizardStep(6)" style="cursor: pointer;"><i class="fas fa-check-circle me-1"></i>06 Review</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <form action="<?php echo e(route('admin.farms.store')); ?>" method="POST" enctype="multipart/form-data"
                                id="addFarmWizardForm" novalidate>
                                <?php echo csrf_field(); ?>

                                <!-- Hidden JSON Fields & Financial Calculation State for Controller -->
                                <input type="hidden" name="budget_breakdown" id="budget_breakdown_json"
                                    value="<?php echo e(old('budget_breakdown', '[]')); ?>">
                                <input type="hidden" name="farming_timeline" id="farming_timeline_json"
                                    value="<?php echo e(old('farming_timeline', '[]')); ?>">
                                <input type="hidden" name="total_budget" id="wiz_total_budget"
                                    value="<?php echo e(old('total_budget', '350000')); ?>">
                                <input type="hidden" name="calculated_roi" id="wiz_calculated_roi"
                                    value="<?php echo e(old('calculated_roi', '28.6')); ?>">
                                <input type="hidden" name="annualized_roi" id="wiz_annualized_roi"
                                    value="<?php echo e(old('annualized_roi', '87.0')); ?>">
                                <input type="hidden" name="crop_cycle_days" id="wiz_crop_cycle_days"
                                    value="<?php echo e(old('crop_cycle_days', '120')); ?>">

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('benchmark_warnings')): ?>
                                    <div class="alert alert-warning border-0 rounded-4 p-3 mb-4 bg-warning bg-opacity-15 text-dark" style="font-size: 12px;">
                                        <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle text-warning me-1"></i>Agricultural Benchmark Advisory:</div>
                                        <ul class="mb-0 ps-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = session('benchmark_warnings'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <li><?php echo e($w); ?></li>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                                    <div class="alert alert-danger no-auto-dismiss bg-danger bg-opacity-10 text-danger border-0 rounded-3 mb-4 p-3"
                                        style="font-size: 12px;">
                                        <div class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i> Please fix the
                                            following errors to submit your farm application:</div>
                                        <ul class="mb-0 ps-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </ul>
                                    </div>
                                    <script>
                                        window.addEventListener('load', () => {
                                            // Auto-open Add Farm tab if there are validation errors
                                            const addFarmBtn = document.querySelector('[data-tab="add-farm"]');
                                            if (addFarmBtn) addFarmBtn.click();
                                        });
                                    </script>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                                            value="<?php echo e(old('name')); ?>">
                                        <div class="text-muted mt-1" style="font-size: 10px;">Use a descriptive name that helps
                                            investors identify the location or project.</div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Total Area
                                                (Acres) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="total_acres" id="wiz_acres"
                                                class="form-control rounded-3 py-2" placeholder="0.00 acres" required
                                                style="font-size: 12px;" value="<?php echo e(old('total_acres')); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Primary
                                                Crop
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="primary_crop" id="wiz_primary_crop"
                                                class="form-control rounded-3 py-2" placeholder="e.g. Basmati Rice" required
                                                style="font-size: 12px;" value="<?php echo e(old('primary_crop')); ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Secondary Crop
                                            (Optional)</label>
                                        <input type="text" name="secondary_crop" id="wiz_secondary_crop"
                                            class="form-control rounded-3 py-2" placeholder="e.g. Turmeric, Vegetables"
                                            style="font-size: 12px;" value="<?php echo e(old('secondary_crop')); ?>">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Location /
                                            Region
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="location" id="wiz_location" class="form-control rounded-3 py-2"
                                            placeholder="e.g. Anantapur, Andhra Pradesh" required style="font-size: 12px;"
                                            value="<?php echo e(old('location')); ?>">
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
                                            value="<?php echo e(old('listing_category', 'Vegetables')); ?>">
                                    </div>

                                    <div class="d-flex justify-content-end pt-3 border-top">
                                        <button type="button" onclick="goToWizardStep(2)"
                                            class="btn btn-success rounded-pill px-5 py-2 fw-bold" style="font-size: 12px;">
                                            Continue <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 2: Investment & Budget Breakdown (Spacious Modern Layout) -->
                                <div class="wizard-step-pane" id="wizard-step-2" style="display: none;">
                                    
                                    <!-- 1. Full-Width Budget Breakdown Table -->
                                    <div class="mb-5">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                            <div>
                                                <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Itemized Budget Breakdown</h5>
                                                <p class="text-muted mb-0" style="font-size: 12px;">Specify individual expenses, quantities in kg / units, and unit rates. Line item amounts and total budget are automatically calculated.</p>
                                            </div>
                                            <button type="button" onclick="addBudgetItem('Custom Expense', 10, 'kg', 0)"
                                                class="btn btn-sm btn-outline-success rounded-pill px-3 py-1.5 fw-semibold"
                                                style="font-size: 12px;">
                                                <i class="fas fa-plus me-1"></i> Add Custom Row
                                            </button>
                                        </div>

                                        <!-- Quick Expense Chips -->
                                        <div class="p-3 bg-light rounded-4 border mb-4">
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <span class="text-muted fw-semibold me-1" style="font-size: 11px;"><i class="fas fa-bolt text-warning me-1"></i>Quick Add:</span>
                                                <button type="button" onclick="addBudgetItem('Seeds', 50, 'kg', 900)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Seeds (50 kg @ ₹900)</button>
                                                <button type="button" onclick="addBudgetItem('Fertilizer', 300, 'kg', 100)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Fertilizer (300 kg @ ₹100)</button>
                                                <button type="button" onclick="addBudgetItem('Organic Manure', 500, 'kg', 40)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Manure (500 kg @ ₹40)</button>
                                                <button type="button" onclick="addBudgetItem('Pesticides / Bio', 20, 'kg', 1500)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Pesticides (20 kg @ ₹1,500)</button>
                                                <button type="button" onclick="addBudgetItem('Labor', 60, 'days', 2000)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Labor (60 days @ ₹2,000)</button>
                                                <button type="button" onclick="addBudgetItem('Irrigation', 1, 'plot', 85000)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Irrigation</button>
                                                <button type="button" onclick="addBudgetItem('Equipment Rental', 1, 'plot', 50000)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Equipment</button>
                                                <button type="button" onclick="addBudgetItem('Land preparation', 1, 'plot', 20000)"
                                                    class="btn btn-sm btn-white bg-white border rounded-pill px-3 py-1 text-secondary shadow-sm"
                                                    style="font-size: 11px;">+ Land Prep</button>
                                            </div>
                                        </div>

                                        <!-- Budget Breakdown Table with Spacious Columns & Generous Cell Padding -->
                                        <div class="table-responsive rounded-4 border shadow-sm mb-2">
                                            <table class="table table-hover mb-0 align-middle" style="font-size: 12.5px;">
                                                <thead class="bg-success text-white">
                                                    <tr>
                                                        <th class="py-3 ps-3" style="min-width: 240px;">Item / Purpose</th>
                                                        <th class="py-3" style="width: 115px;">Qty</th>
                                                        <th class="py-3" style="width: 120px;">Unit</th>
                                                        <th class="py-3" style="width: 140px;">Rate (₹ / unit)</th>
                                                        <th class="py-3" style="width: 160px;">Amount (₹)</th>
                                                        <th class="py-3 text-center" style="width: 50px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="budget_table_body">
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Seeds" placeholder="e.g. Basmati Certified Seeds"></td>
                                                        <td class="py-2.5"><input type="number" step="0.1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="50" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg" selected>kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days">days</option>
                                                                <option value="plot">plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="900" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="45000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Labor" placeholder="e.g. Field Labor"></td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="60" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg">kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days" selected>days</option>
                                                                <option value="plot">plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="2000" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="120000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Irrigation" placeholder="e.g. Drip Irrigation"></td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="1" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg">kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days">days</option>
                                                                <option value="plot" selected>plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="85000" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="85000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Equipment" placeholder="e.g. Machinery Rental"></td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="1" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg">kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days">days</option>
                                                                <option value="plot" selected>plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="50000" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="50000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Fertilizer" placeholder="e.g. NPK Fertilizer"></td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="300" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg" selected>kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days">days</option>
                                                                <option value="plot">plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="100" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="30000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="Land preparation" placeholder="e.g. Tractor Tilling"></td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="1" oninput="recalcRowBudget(this)"></td>
                                                        <td class="py-2.5">
                                                            <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                                                <option value="kg">kg</option>
                                                                <option value="quintal">quintal</option>
                                                                <option value="bags">bags</option>
                                                                <option value="days">days</option>
                                                                <option value="plot" selected>plot</option>
                                                                <option value="units">units</option>
                                                            </select>
                                                        </td>
                                                        <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="20000" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                                                        <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="20000" oninput="calculateBudgetTotal()"></td>
                                                        <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="border-top-2">
                                                    <tr class="fw-bold bg-light">
                                                        <td colspan="4" class="text-end py-3 pe-3 text-muted" style="font-size: 13px;">Total Budget Requested (Sum of all items):</td>
                                                        <td class="py-3">
                                                            <div id="budget_total_display" class="text-success fw-bold fs-5">₹3,50,000</div>
                                                        </td>
                                                        <td class="py-3"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 2. Spacious 2-Column Cards: Yield Forecast & Capital Structure / ROI Engine -->
                                    <div class="row g-4 mb-5">
                                        <!-- Left Card: Projected Harvest & Market Revenue -->
                                        <div class="col-lg-6">
                                            <div class="card border shadow-sm rounded-4 p-4 h-100 bg-white">
                                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                                        <i class="fas fa-wheat-awn text-success me-2"></i>1. Projected Harvest & Market Revenue
                                                    </h6>
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 11px;">Yield Forecast</span>
                                                </div>
                                                <p class="text-muted mb-3" style="font-size: 12px;">Estimate expected yield and wholesale market selling price. Used to calculate gross crop revenue automatically.</p>

                                                <!-- Crop Benchmark Advisory & Non-blocking Warnings (Fix #5) -->
                                                <div id="crop_benchmark_hint" class="alert alert-info py-2 px-3 rounded-3 mb-3 border-0 bg-info bg-opacity-10 text-dark" style="font-size: 11px; display: none;"></div>
                                                <div id="crop_benchmark_warnings_box" class="alert alert-warning py-2.5 px-3 rounded-3 mb-3 border-0 bg-warning bg-opacity-15 text-dark" style="font-size: 11.5px; display: none;">
                                                    <div class="fw-bold text-dark mb-1"><i class="fas fa-exclamation-triangle text-warning me-1"></i>Benchmark Variance Advisory (Non-blocking):</div>
                                                    <ul id="crop_benchmark_warning_text" class="mb-0 ps-3"></ul>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-6">
                                                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Expected Harvest Yield (kg) <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number" step="100" name="expected_yield_kg" id="wiz_expected_yield_kg" class="form-control rounded-start py-2" value="<?php echo e(old('expected_yield_kg', '18000')); ?>" placeholder="e.g. 18000" style="font-size: 13px;" required>
                                                            <span class="input-group-text bg-light text-muted fw-semibold">kg</span>
                                                        </div>
                                                        <div class="text-muted mt-1 fw-semibold" style="font-size: 11px;" id="wiz_yield_tons_display">≈ 18.00 Tons</div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Selling Price (₹ / kg) <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light text-muted fw-semibold">₹</span>
                                                            <input type="number" step="0.5" name="selling_price_kg" id="wiz_expected_price_kg" class="form-control rounded-end py-2" value="<?php echo e(old('selling_price_kg', '25')); ?>" placeholder="e.g. 25" style="font-size: 13px;" required>
                                                        </div>
                                                        <div class="text-muted mt-1 fw-semibold" style="font-size: 11px;" id="wiz_price_ton_display">₹25,000 / Ton</div>
                                                    </div>
                                                </div>

                                                <!-- Financial Outcome Projection Box -->
                                                <div class="p-3 rounded-4 bg-light border mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-muted" style="font-size: 12px;">Projected Gross Crop Revenue:</span>
                                                        <strong class="text-dark fs-6" id="calc_projected_revenue">₹4,50,000</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-muted" style="font-size: 12px;">Less Total Production Budget:</span>
                                                        <strong class="text-danger" id="calc_budget_deduct">- ₹3,50,000</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                        <span class="fw-bold text-dark" style="font-size: 13px;">Net Cycle Profit:</span>
                                                        <strong class="text-success fs-5" id="calc_projected_profit">₹1,00,000</strong>
                                                    </div>
                                                </div>

                                                <!-- Fix #5: Optional Yield Shortfall Stress Test Scenario -->
                                                <div class="p-3 rounded-4 bg-white border">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="form-check form-switch mb-0">
                                                            <input class="form-check-input" type="checkbox" name="apply_shortfall" id="wiz_toggle_shortfall" value="1">
                                                            <label class="form-check-label fw-bold text-dark" for="wiz_toggle_shortfall" style="font-size: 12px;">
                                                                Simulate -15% Yield Shortfall Scenario
                                                            </label>
                                                        </div>
                                                        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 10px;">Downside Stress Test</span>
                                                    </div>
                                                    <div id="shortfall_simulation_card" style="display: none;" class="pt-2 border-top">
                                                        <div class="d-flex justify-content-between align-items-center mb-1 text-muted" style="font-size: 11.5px;">
                                                            <span>Stressed Yield (-15%):</span>
                                                            <strong class="text-dark" id="stress_yield_display">15,300 kg</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-1 text-muted" style="font-size: 11.5px;">
                                                            <span>Stressed Revenue:</span>
                                                            <strong class="text-dark" id="stress_rev_display">₹3,82,500</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-1 text-muted" style="font-size: 11.5px;">
                                                            <span>Stressed Net Profit:</span>
                                                            <strong class="text-success" id="stress_profit_display">₹32,500</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center pt-1 border-top" style="font-size: 12px;">
                                                            <span class="fw-bold text-dark">Stressed Investor Return:</span>
                                                            <span class="badge bg-warning text-dark px-2 py-1 fw-bold" id="stress_roi_badge">7.6% Cycle ROI</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Card: Capital Structure & Automatic Investor ROI -->
                                        <div class="col-lg-6">
                                            <div class="card border shadow-sm rounded-4 p-4 h-100 bg-white">
                                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                                        <i class="fas fa-coins text-warning me-2"></i>2. Capital Structure & Automatic Investor ROI
                                                    </h6>
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 11px;" id="calc_override_status_badge">Calculated (Pure Engine)</span>
                                                </div>
                                                <p class="text-muted mb-3" style="font-size: 12px;">Net profit is allocated <strong>70% to investors</strong> and <strong>30% retained by the farmer</strong> (configurable in system settings).</p>

                                                <!-- Capital Parameters Grid -->
                                                <div class="row g-2 mb-3">
                                                    <div class="col-sm-4">
                                                        <div class="p-2.5 rounded-3 bg-light border text-center">
                                                            <div class="text-muted text-uppercase" style="font-size: 9px; font-weight: 700;">TOTAL BUDGET</div>
                                                            <div class="fw-bold text-dark fs-6 mt-1" id="wiz_total_budget_display">₹3,50,000</div>
                                                            <div class="text-muted" style="font-size: 9px;">Sum of items</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="p-2.5 rounded-3 bg-light border text-center">
                                                            <div class="text-muted text-uppercase" style="font-size: 9px; font-weight: 700;">FARMER STAKE</div>
                                                            <div class="input-group input-group-sm mt-1">
                                                                <span class="input-group-text bg-white text-muted">₹</span>
                                                                <input type="number" name="your_contribution" id="wiz_your_contribution"
                                                                    class="form-control text-center fw-bold text-success"
                                                                    value="<?php echo e(old('your_contribution', '50000')); ?>" min="0" required>
                                                            </div>
                                                            <div class="text-muted" style="font-size: 9px;">Committed stake</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="p-2.5 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25 text-center">
                                                            <div class="text-success text-uppercase" style="font-size: 9px; font-weight: 700;">INVESTOR TARGET</div>
                                                            <div class="fw-bold text-success fs-6 mt-1" id="wiz_funding_target_display">₹3,00,000</div>
                                                            <div class="text-muted" style="font-size: 9px;">Capital ask</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hidden Input bound to Investor Funding Target (Fix #2) -->
                                                <input type="hidden" name="funding_target" id="wiz_funding_target" value="<?php echo e(old('funding_target', '300000')); ?>">

                                                <!-- Fix #2 Real-time Validation Error Container -->
                                                <div id="wiz_stake_validation_error" class="alert alert-danger py-2 px-3 rounded-3 mb-3 border-0 bg-danger bg-opacity-10 text-danger fw-semibold" style="font-size: 11px; display: none;"></div>

                                                <!-- Returns Box with Cycle ROI & Annualized ROI (Fix #3) -->
                                                <div class="p-3 rounded-4 bg-light border mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="form-label text-dark fw-bold mb-0" style="font-size: 13px;">Expected Investor Returns</label>
                                                        <div class="d-flex gap-1.5 flex-wrap">
                                                            <span class="badge bg-success text-white px-2.5 py-1 fw-bold" id="calc_cycle_roi_badge">23.3% Cycle ROI</span>
                                                            <span class="badge bg-primary bg-opacity-15 text-primary px-2.5 py-1 fw-bold" id="calc_annualized_roi_badge">71.0% Annualized (120d)</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" name="expected_roi" id="wiz_roi"
                                                            class="form-control rounded-start py-2 fw-bold text-success fs-5 bg-light"
                                                            value="<?php echo e(old('expected_roi', '23.3')); ?>" readonly required>
                                                        <span class="input-group-text bg-white text-muted fw-bold">%</span>
                                                    </div>

                                                    <!-- Fix #1: Live Dynamic Formula Note (Never Static) -->
                                                    <div class="p-2.5 rounded-3 bg-white border mt-2.5" id="formula_note_live" style="font-size: 11px; line-height: 1.5;">
                                                        <i class="fas fa-calculator text-success me-1"></i><strong>Formula:</strong> Live formula note computing...
                                                    </div>
                                                </div>

                                                <!-- Fix #4: Admin ROI Override with Audit Log Requirement -->
                                                <div class="p-3 rounded-4 bg-white border">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" name="is_roi_overridden" id="wiz_is_roi_overridden" value="1" <?php echo e(old('is_roi_overridden') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label fw-bold text-dark" for="wiz_is_roi_overridden" style="font-size: 12px;">
                                                            Override Calculated ROI (Admin Special Terms)
                                                        </label>
                                                    </div>
                                                    <div id="override_reason_container" style="<?php echo e(old('is_roi_overridden') ? 'display: block;' : 'display: none;'); ?>" class="pt-2 border-top">
                                                        <label class="form-label text-muted mb-1 fw-semibold" style="font-size: 11px;">Override Justification / Audit Reason <span class="text-danger">*</span></label>
                                                        <textarea name="roi_override_reason" id="wiz_override_reason" class="form-control form-control-sm rounded-3 mb-1.5" rows="2" placeholder="e.g. Secured pre-contract wholesale purchase agreement with certified organic distributor..."><?php echo e(old('roi_override_reason')); ?></textarea>
                                                        <div class="text-muted" style="font-size: 10px;">
                                                            <i class="fas fa-shield-alt text-warning me-1"></i>This override and justification will be recorded in the system audit log. Both the calculated and overridden ROI remain visible to administrators.
                                                        </div>
                                                    </div>
                                                </div>
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
                                 ..       <h6 class="fw-bold text-dark mb-1">Farm Photos</h6>
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

                                <!-- STEP 4: Yield & Farming Timeline (Figma Exact & Fully Interactive) -->
                                <div class="wizard-step-pane" id="wizard-step-4" style="display: none;">
                                    <!-- Live Yield Forecast Summary Card from Step 2 -->
                                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #bbf7d0 !important;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                                                        <i class="fas fa-seedling me-1"></i> Harvest Yield & Revenue Forecast
                                                    </span>
                                                    <small class="text-muted" style="font-size: 11px;">Live harvest projections calculated in Step 2</small>
                                                </div>
                                                <button type="button" onclick="goToWizardStep(2)" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold" style="font-size: 11px;">
                                                    <i class="fas fa-edit me-1"></i> Edit Yield in Step 2
                                                </button>
                                            </div>
                                            <div class="row g-3 text-dark">
                                                <div class="col-md-4">
                                                    <div class="p-3 rounded-3 bg-white border border-success border-opacity-25 h-100 shadow-sm">
                                                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Expected Harvest Yield</div>
                                                        <div class="fw-bold text-success fs-5" id="wiz_step4_yield_tons">≈ 18.00 Tons</div>
                                                        <div class="text-muted" style="font-size: 11px;" id="wiz_step4_yield_kg">18,000 kg total</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 rounded-3 bg-white border border-success border-opacity-25 h-100 shadow-sm">
                                                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Projected Selling Price</div>
                                                        <div class="fw-bold text-dark fs-5" id="wiz_step4_price_display">₹25.00 / kg</div>
                                                        <div class="text-muted" style="font-size: 11px;" id="wiz_step4_price_ton_display">₹25,000 / Ton</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 rounded-3 bg-white border border-success border-opacity-25 h-100 shadow-sm">
                                                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Gross Crop Revenue</div>
                                                        <div class="fw-bold text-primary fs-5" id="wiz_step4_revenue_display">₹4,50,000</div>
                                                        <div class="text-muted" style="font-size: 11px;">Total anticipated harvest realization</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cycle Duration & Expected Dates -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold d-flex justify-content-between align-items-center" style="font-size: 12px;">
                                                <span>Total Yielding Period (Months) <span class="text-danger">*</span></span>
                                                <span class="badge bg-success bg-opacity-10 text-success fw-semibold" id="wiz_auto_period_badge" style="font-size: 10px;">
                                                    <i class="fas fa-magic me-1"></i>Auto-syncs with crop & timeline
                                                </span>
                                            </label>
                                            <input type="number" step="0.5" name="yielding_period" id="wiz_yielding_period"
                                                class="form-control rounded-3 py-2" value="<?php echo e(old('yielding_period', '3')); ?>"
                                                min="1" max="60" required style="font-size: 13px;" oninput="onYieldingPeriodInput()">
                                            <div class="text-muted mt-1" style="font-size: 11px;">Automatically changes with crop category (Vegetables: 3m, Paddy: 4m, Fruits: 6m) and timeline stages.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Expected Cultivation Start Date <span class="text-danger">*</span></label>
                                            <input type="date" name="expected_start_date" id="wiz_start_date"
                                                class="form-control rounded-3 py-2"
                                                value="<?php echo e(old('expected_start_date', date('Y-m-d'))); ?>" required
                                                style="font-size: 13px;" oninput="updateYieldTabSchedule()">
                                            <div class="text-muted mt-1" style="font-size: 11px;">Planned field preparation and sowing kick-off date.</div>
                                        </div>
                                    </div>

                                    <!-- Live Projected Harvest Date Banner -->
                                    <div class="p-3 rounded-4 mb-4 bg-light border d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-calendar-check" style="font-size: 14px;"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">Estimated Harvest Completion</div>
                                                <div class="fw-bold text-success fs-6" id="wiz_projected_harvest_display">—</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-white text-secondary border px-3 py-1.5 rounded-pill fw-semibold" id="wiz_timeline_comparison_badge" style="font-size: 11px;">
                                                Timeline: 6 / 6 Months
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Farming Timeline Stages Card -->
                                    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-sm">
                                        <div class="bg-success p-3 text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <div>
                                                <h6 class="fw-bold mb-0" style="font-size: 13px;"><i class="fas fa-tasks me-1.5"></i> Farming Timeline Stages</h6>
                                                <p class="mb-0 text-white-50" style="font-size: 10px;">Break the farming cycle into specific milestones so investors track field progress.</p>
                                            </div>
                                            <button type="button" onclick="addStageRow()"
                                                class="btn btn-sm btn-light text-success fw-bold rounded-pill px-3 py-1"
                                                style="font-size: 11px;"><i class="fas fa-plus-circle me-1"></i> Add Stage</button>
                                        </div>
                                        <div class="card-body bg-light p-3">
                                            <div class="row g-2 mb-2 px-1 text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px; text-transform: uppercase;">
                                                <div class="col-md-4">Stage Name</div>
                                                <div class="col-md-2">Start Month</div>
                                                <div class="col-md-2">End Month</div>
                                                <div class="col-md-3">Duration</div>
                                                <div class="col-md-1 text-center">Remove</div>
                                            </div>
                                            <div id="timeline_stages_container">
                                                <!-- Row 1 -->
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="Land Preparation & Soil Tillage" oninput="syncTimelineJson()"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="0" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="1" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="1 Month" readonly></div>
                                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                </div>
                                                <!-- Row 2 -->
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="Sowing, Nursery & Germination" oninput="syncTimelineJson()"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="1" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="2" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="1 Month" readonly></div>
                                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                </div>
                                                <!-- Row 3 -->
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="Vegetative Growth & Fertilization" oninput="syncTimelineJson()"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="2" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="4" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="2 Months" readonly></div>
                                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                </div>
                                                <!-- Row 4 -->
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="Flowering & Maturation" oninput="syncTimelineJson()"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="4" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="5" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="1 Month" readonly></div>
                                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                </div>
                                                <!-- Row 5 -->
                                                <div class="row g-2 mb-2 align-items-center stage-row">
                                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="Harvesting, Curing & Off-take" oninput="syncTimelineJson()"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="5" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="6" oninput="updateStageRowDuration(this)"></div>
                                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="1 Month" readonly></div>
                                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pt-2">
                                                <button type="button" onclick="addStageRow()"
                                                    class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                    style="font-size: 11px;"><i class="fas fa-plus me-1"></i> Add Another Stage</button>
                                                <button type="button" onclick="resetDefaultStages()"
                                                    class="btn btn-sm btn-link text-muted text-decoration-none"
                                                    style="font-size: 11px;"><i class="fas fa-undo me-1"></i> Reset to Default Stages</button>
                                            </div>
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
                                                    value="<?php echo e(old('min_investment', '10000')); ?>" required
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
                                                    value="<?php echo e(old('max_investment', '350000')); ?>" required
                                                    style="font-size: 12px;">
                                                <div class="text-muted mt-1" style="font-size: 10px;">Higher maximums allow
                                                    institutional or angel investors to fill the funding gap quickly.</div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="wiz_terms" required>
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
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">TOTAL PROJECT BUDGET</div>
                                                    <div class="fw-bold text-dark fs-5" id="rev_total_budget">₹ 3,50,000</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">FARMER STAKE (CONTRIBUTION)</div>
                                                    <div class="fw-bold text-success fs-5" id="rev_contrib">₹ 50,000 (14%)</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">INVESTOR FUNDING TARGET</div>
                                                    <div class="fw-bold text-primary fs-5" id="rev_target">₹ 3,00,000</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">INVESTOR RETURN (ROI)</div>
                                                    <div class="fw-bold text-dark fs-6" id="rev_roi">23.3% Cycle ROI</div>
                                                    <div class="text-muted" style="font-size: 11px;" id="rev_annualized_roi">71.0% Annualized</div>
                                                    <div id="rev_override_badge" style="display: none;" class="mt-1"></div>
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

                                    <!-- 3. Yield & Farming Timeline Review Card (Figma Green Header) -->
                                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
                                        style="background-color: #ffffff;">
                                        <div class="text-white px-4 py-2.5 d-flex justify-content-between align-items-center"
                                            style="background-color: #7ba017 !important;">
                                            <span class="fw-bold text-uppercase"
                                                style="font-size: 12px; letter-spacing: 0.5px;">Yield & Farming Timeline</span>
                                            <button type="button" onclick="goToWizardStep(4)"
                                                class="btn btn-sm text-white p-0 text-decoration-none"
                                                style="font-size: 11px;"><i class="fas fa-edit me-1"></i>Edit</button>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3 mb-4 text-dark">
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">EXPECTED HARVEST YIELD</div>
                                                    <div class="fw-bold text-success fs-5" id="rev_yield_tons">18.00 Tons</div>
                                                    <div class="text-muted" style="font-size: 11px;" id="rev_yield_kg">18,000 kg</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">YIELDING CYCLE</div>
                                                    <div class="fw-bold text-dark fs-5" id="rev_period">6 Months</div>
                                                    <div class="text-muted" style="font-size: 11px;" id="rev_cycle_days">≈ 180 Days</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">CULTIVATION START</div>
                                                    <div class="fw-bold text-dark fs-6" id="rev_start_date">Nov 20, 2026</div>
                                                    <div class="text-muted" style="font-size: 11px;">Field kick-off</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-muted text-uppercase"
                                                        style="font-size: 9px; letter-spacing: 0.5px;">PROJECTED HARVEST</div>
                                                    <div class="fw-bold text-primary fs-6" id="rev_harvest_date">May 20, 2027</div>
                                                    <div class="text-muted" style="font-size: 11px;">Estimated completion</div>
                                                </div>
                                            </div>

                                            <div class="border rounded-3 p-3 bg-light">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">TIMELINE STAGES BREAKDOWN</span>
                                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold" id="rev_stages_badge" style="font-size: 10px;">5 Stages</span>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-sm mb-0" style="font-size: 12px;">
                                                        <thead>
                                                            <tr class="border-bottom text-muted">
                                                                <th>Stage Name</th>
                                                                <th>Schedule Window</th>
                                                                <th class="text-end">Duration</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="rev_timeline_rows">
                                                            <tr>
                                                                <td colspan="3" class="text-muted text-center">Loading stages...</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4. Media and Documents Card (Figma Green Header) -->
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

                <!-- Farm Financials Client Engine -->
                <script src="<?php echo e(asset('js/farm-financials.js')); ?>"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        if (window.SoulSoilFinancials) {
                            window.SoulSoilFinancials.init(
                                <?php echo json_encode(config('soulsoil.financials'), 15, 512) ?>,
                                <?php echo json_encode(\App\Models\Crop::all(), 15, 512) ?>
                            );
                        }
                    });

                    const CROP_CATEGORY_DURATIONS = {
                        'Vegetables': 3,
                        'Pulses': 3,
                        'Paddy': 4,
                        'Wheat': 5,
                        'Fruits': 6,
                        'Spices': 7,
                        'Other': 6
                    };

                    function selectCategory(cat, el) {
                        document.getElementById('wiz_category').value = cat;
                        document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active', 'bg-success', 'text-white'));
                        if (el) el.classList.add('active', 'bg-success', 'text-white');

                        // Automatically update yielding period in months based on selected crop category!
                        const months = CROP_CATEGORY_DURATIONS[cat] || 4;
                        setYieldingPeriodAndRebuildStages(months);
                    }

                    function detectCropCategory(cropName) {
                        if (!cropName) return null;
                        const lower = cropName.trim().toLowerCase();
                        if (lower.includes('paddy') || lower.includes('rice') || lower.includes('basmati')) return 'Paddy';
                        if (lower.includes('wheat')) return 'Wheat';
                        if (lower.includes('tomato') || lower.includes('chilli') || lower.includes('onion') || lower.includes('potato') || lower.includes('vegetable') || lower.includes('brinjal') || lower.includes('okra') || lower.includes('cabbage')) return 'Vegetables';
                        if (lower.includes('pulse') || lower.includes('gram') || lower.includes('dal') || lower.includes('moong') || lower.includes('urad') || lower.includes('lentil')) return 'Pulses';
                        if (lower.includes('fruit') || lower.includes('banana') || lower.includes('mango') || lower.includes('papaya') || lower.includes('melon') || lower.includes('berry')) return 'Fruits';
                        if (lower.includes('spice') || lower.includes('turmeric') || lower.includes('ginger') || lower.includes('cardamom') || lower.includes('pepper')) return 'Spices';
                        return null;
                    }

                    function addBudgetItem(purpose, qty = 1, unit = 'kg', rate = 0, amount = 0) {
                        const tbody = document.getElementById('budget_table_body');
                        const row = document.createElement('tr');
                        const initialAmount = amount > 0 ? amount : Math.round(qty * rate);
                        row.innerHTML = `
                            <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="${purpose}" placeholder="Item purpose"></td>
                            <td class="py-2.5"><input type="number" step="0.1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="${qty}" oninput="recalcRowBudget(this)" placeholder="Qty"></td>
                            <td class="py-2.5">
                                <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                                    <option value="kg" ${unit === 'kg' ? 'selected' : ''}>kg</option>
                                    <option value="quintal" ${unit === 'quintal' ? 'selected' : ''}>quintal</option>
                                    <option value="bags" ${unit === 'bags' ? 'selected' : ''}>bags</option>
                                    <option value="days" ${unit === 'days' ? 'selected' : ''}>days</option>
                                    <option value="plot" ${unit === 'plot' ? 'selected' : ''}>plot</option>
                                    <option value="units" ${unit === 'units' ? 'selected' : ''}>units</option>
                                </select>
                            </td>
                            <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="${rate}" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
                            <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="${initialAmount}" oninput="calculateBudgetTotal()"></td>
                            <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                        `;
                        tbody.appendChild(row);
                        calculateBudgetTotal();
                    }

                    function recalcRowBudget(input) {
                        const tr = input.closest('tr');
                        const qty = parseFloat(tr.querySelector('.b-qty')?.value) || 0;
                        const rate = parseFloat(tr.querySelector('.b-rate')?.value) || 0;
                        const amtInput = tr.querySelector('.b-amount');
                        if (qty > 0 && rate > 0 && amtInput) {
                            amtInput.value = Math.round(qty * rate);
                        }
                        calculateBudgetTotal();
                    }

                    function removeBudgetRow(btn) {
                        btn.closest('tr').remove();
                        calculateBudgetTotal();
                    }

                    function calculateBudgetTotal(updateTarget = true) {
                        let total = 0;
                        const items = [];
                        document.querySelectorAll('#budget_table_body tr').forEach(tr => {
                            const purpose = tr.querySelector('.b-purpose')?.value || '';
                            const qty = parseFloat(tr.querySelector('.b-qty')?.value) || 0;
                            const unit = tr.querySelector('.b-unit')?.value || 'kg';
                            const rate = parseFloat(tr.querySelector('.b-rate')?.value) || 0;
                            let amount = parseFloat(tr.querySelector('.b-amount')?.value) || 0;

                            if (qty > 0 && rate > 0 && amount <= 0) {
                                amount = Math.round(qty * rate);
                                const amtInput = tr.querySelector('.b-amount');
                                if (amtInput) amtInput.value = amount;
                            }

                            if (purpose && amount > 0) {
                                items.push({
                                    purpose: purpose,
                                    item: purpose,
                                    quantity: qty,
                                    qty: qty,
                                    unit: unit,
                                    rate: rate,
                                    cost: amount,
                                    amount: amount
                                });
                                total += amount;
                            }
                        });

                        const displayEl = document.getElementById('budget_total_display');
                        if (displayEl) displayEl.textContent = '₹' + total.toLocaleString('en-IN');
                        const jsonEl = document.getElementById('budget_breakdown_json');
                        if (jsonEl) jsonEl.value = JSON.stringify(items);
                        const targetInput = document.getElementById('wiz_funding_target');
                        if (updateTarget && targetInput && total > 0) {
                            targetInput.value = total;
                            targetInput.dispatchEvent(new Event('input', { bubbles: true }));
                        }

                        updateAutoRoi();
                    }

                    function updateAutoRoi() {
                        const targetInput = document.getElementById('wiz_funding_target');
                        const totalBudget = parseFloat(targetInput?.value) || 0;
                        const yieldInput = document.getElementById('wiz_expected_yield_kg');
                        const priceInput = document.getElementById('wiz_expected_price_kg');

                        const yieldKg = parseFloat(yieldInput?.value) || 0;
                        const priceKg = parseFloat(priceInput?.value) || 0;

                        // Unit display helpers
                        const yieldTonsEl = document.getElementById('wiz_yield_tons_display');
                        if (yieldTonsEl) {
                            yieldTonsEl.textContent = `≈ ${(yieldKg / 1000).toFixed(2)} Tons`;
                        }
                        const priceTonEl = document.getElementById('wiz_price_ton_display');
                        if (priceTonEl) {
                            priceTonEl.textContent = `₹${Math.round(priceKg * 1000).toLocaleString('en-IN')} / Ton`;
                        }

                        const projectedRev = Math.round(yieldKg * priceKg);
                        const netProfit = projectedRev - totalBudget;

                        let autoRoi = 0;
                        if (totalBudget > 0 && netProfit > 0) {
                            autoRoi = parseFloat(((netProfit / totalBudget) * 100).toFixed(1));
                        }

                        const revEl = document.getElementById('calc_projected_revenue');
                        if (revEl) revEl.textContent = '₹' + projectedRev.toLocaleString('en-IN');

                        const deductEl = document.getElementById('calc_budget_deduct');
                        if (deductEl) deductEl.textContent = '- ₹' + totalBudget.toLocaleString('en-IN');

                        const profitEl = document.getElementById('calc_projected_profit');
                        if (profitEl) {
                            profitEl.textContent = (netProfit >= 0 ? '₹' : '-₹') + Math.abs(netProfit).toLocaleString('en-IN');
                            profitEl.className = netProfit >= 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
                        }

                        const badgeEl = document.getElementById('calc_auto_roi_badge');
                        if (badgeEl) {
                            badgeEl.textContent = (autoRoi > 0 ? autoRoi : 15) + '% ROI';
                            badgeEl.className = autoRoi > 0 ? 'badge bg-success text-white px-2 py-1 fw-bold' : 'badge bg-secondary text-white px-2 py-1 fw-bold';
                        }

                        const roiInput = document.getElementById('wiz_roi');
                        if (roiInput && (!roiInput.dataset.userEdited || parseFloat(roiInput.value) <= 0)) {
                            roiInput.value = autoRoi > 0 ? autoRoi : 15;
                        }
                    }

                    function setYieldingPeriodAndRebuildStages(months) {
                        months = Math.max(1, Math.round(months * 10) / 10);
                        const periodInput = document.getElementById('wiz_yielding_period');
                        if (periodInput) {
                            periodInput.value = months;
                        }

                        const cycleDaysHidden = document.getElementById('wiz_crop_cycle_days');
                        if (cycleDaysHidden) {
                            cycleDaysHidden.value = Math.round(months * 30);
                        }

                        buildDefaultStagesForPeriod(months);
                        updateYieldTabSchedule();

                        if (window.SoulSoilFinancials && typeof window.SoulSoilFinancials.recalculateAll === 'function') {
                            window.SoulSoilFinancials.recalculateAll();
                        }
                    }

                    function onYieldingPeriodInput() {
                        const periodInput = document.getElementById('wiz_yielding_period');
                        const newMonths = parseFloat(periodInput?.value) || 0;
                        if (newMonths > 0) {
                            const cycleDaysHidden = document.getElementById('wiz_crop_cycle_days');
                            if (cycleDaysHidden) {
                                cycleDaysHidden.value = Math.round(newMonths * 30);
                            }

                            // Adjust the final stage end month to match the new period!
                            const rows = document.querySelectorAll('.stage-row');
                            if (rows.length > 0) {
                                const lastRow = rows[rows.length - 1];
                                const endInput = lastRow.querySelector('.stage-end');
                                const startInput = lastRow.querySelector('.stage-start');
                                const durInput = lastRow.querySelector('.stage-dur');
                                const start = parseFloat(startInput?.value) || 0;

                                if (endInput && newMonths >= start) {
                                    endInput.value = newMonths;
                                    const dur = Math.round((newMonths - start) * 10) / 10;
                                    if (durInput) durInput.value = dur === 1 ? '1 Month' : `${dur} Months`;
                                }
                            }

                            recalcTotalStagesDuration(false);
                            syncTimelineJson();

                            if (window.SoulSoilFinancials && typeof window.SoulSoilFinancials.recalculateAll === 'function') {
                                window.SoulSoilFinancials.recalculateAll();
                            }
                        }
                    }

                    function updateYieldTabSummary() {
                        const yieldKg = parseFloat(document.getElementById('wiz_expected_yield_kg')?.value || 0);
                        const priceKg = parseFloat(document.getElementById('wiz_expected_price_kg')?.value || 0);
                        const revenue = Math.round(yieldKg * priceKg);
                        const yieldTons = (yieldKg / 1000).toFixed(2);

                        const tonsEl = document.getElementById('wiz_step4_yield_tons');
                        if (tonsEl) tonsEl.textContent = `≈ ${yieldTons} Tons`;

                        const kgEl = document.getElementById('wiz_step4_yield_kg');
                        if (kgEl) kgEl.textContent = `${yieldKg.toLocaleString('en-IN')} kg total`;

                        const priceEl = document.getElementById('wiz_step4_price_display');
                        if (priceEl) priceEl.textContent = `₹${priceKg.toFixed(2)} / kg`;

                        const priceTonEl = document.getElementById('wiz_step4_price_ton_display');
                        if (priceTonEl) priceTonEl.textContent = `₹${Math.round(priceKg * 1000).toLocaleString('en-IN')} / Ton`;

                        const revEl = document.getElementById('wiz_step4_revenue_display');
                        if (revEl) revEl.textContent = `₹${revenue.toLocaleString('en-IN')}`;

                        updateYieldTabSchedule();
                    }

                    function updateYieldTabSchedule() {
                        const periodInput = document.getElementById('wiz_yielding_period');
                        const periodMonths = parseFloat(periodInput?.value) || 0;
                        const startDateInput = document.getElementById('wiz_start_date');
                        const startVal = startDateInput?.value;
                        const harvestDisplay = document.getElementById('wiz_projected_harvest_display');

                        if (harvestDisplay) {
                            if (startVal && periodMonths > 0) {
                                const startDate = new Date(startVal + 'T00:00:00');
                                if (!isNaN(startDate.getTime())) {
                                    const harvestDate = new Date(startDate.getTime());
                                    const wholeMonths = Math.floor(periodMonths);
                                    const extraDays = Math.round((periodMonths - wholeMonths) * 30);
                                    harvestDate.setMonth(harvestDate.getMonth() + wholeMonths);
                                    if (extraDays > 0) harvestDate.setDate(harvestDate.getDate() + extraDays);
                                    const options = { year: 'numeric', month: 'short', day: 'numeric' };
                                    harvestDisplay.textContent = `${harvestDate.toLocaleDateString('en-US', options)} (in ${periodMonths} Months)`;
                                } else {
                                    harvestDisplay.textContent = '—';
                                }
                            } else {
                                harvestDisplay.textContent = '—';
                            }
                        }

                        recalcTotalStagesDuration(false);
                        syncTimelineJson();
                    }

                    function updateStageRowDuration(input) {
                        const row = input.closest('.stage-row');
                        if (!row) return;

                        const startInput = row.querySelector('.stage-start');
                        const endInput = row.querySelector('.stage-end');
                        const durInput = row.querySelector('.stage-dur');

                        let start = parseFloat(startInput?.value) || 0;
                        let end = parseFloat(endInput?.value) || 0;

                        if (end < start) {
                            end = start;
                            if (endInput) endInput.value = end;
                        }

                        const dur = Math.round((end - start) * 10) / 10;
                        if (durInput) {
                            durInput.value = dur === 1 ? '1 Month' : `${dur} Months`;
                        }

                        // Automatically update Yielding Period when stages change!
                        recalcTotalStagesDuration(true);
                        syncTimelineJson();
                    }

                    function recalcTotalStagesDuration(syncPeriod = true) {
                        let maxEnd = 0;
                        let totalDur = 0;
                        document.querySelectorAll('.stage-row').forEach(row => {
                            const start = parseFloat(row.querySelector('.stage-start')?.value) || 0;
                            const end = parseFloat(row.querySelector('.stage-end')?.value) || 0;
                            if (end > maxEnd) maxEnd = end;
                            if (end > start) {
                                totalDur += (end - start);
                            }
                        });

                        maxEnd = Math.round(maxEnd * 10) / 10;
                        totalDur = Math.round(totalDur * 10) / 10;
                        const effectiveMonths = maxEnd > 0 ? maxEnd : totalDur;

                        // AUTOMATIC SYNC: Update yielding_period automatically!
                        if (syncPeriod && effectiveMonths > 0) {
                            const periodInput = document.getElementById('wiz_yielding_period');
                            if (periodInput && parseFloat(periodInput.value) !== effectiveMonths) {
                                periodInput.value = effectiveMonths;
                                const cycleDaysHidden = document.getElementById('wiz_crop_cycle_days');
                                if (cycleDaysHidden) {
                                    cycleDaysHidden.value = Math.round(effectiveMonths * 30);
                                }
                                if (window.SoulSoilFinancials && typeof window.SoulSoilFinancials.recalculateAll === 'function') {
                                    window.SoulSoilFinancials.recalculateAll();
                                }
                            }
                        }

                        const targetMonths = parseFloat(document.getElementById('wiz_yielding_period')?.value) || effectiveMonths;
                        const badge = document.getElementById('wiz_timeline_comparison_badge');
                        if (badge) {
                            badge.textContent = `Timeline: ${effectiveMonths} / ${targetMonths} Months`;
                            if (Math.abs(effectiveMonths - targetMonths) < 0.1 && targetMonths > 0) {
                                badge.className = 'badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold';
                            } else if (effectiveMonths > targetMonths) {
                                badge.className = 'badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold';
                            } else {
                                badge.className = 'badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold';
                            }
                        }

                        // Update harvest date display
                        const periodInput = document.getElementById('wiz_yielding_period');
                        const periodMonths = parseFloat(periodInput?.value) || 0;
                        const startDateInput = document.getElementById('wiz_start_date');
                        const startVal = startDateInput?.value;
                        const harvestDisplay = document.getElementById('wiz_projected_harvest_display');

                        if (harvestDisplay && startVal && periodMonths > 0) {
                            const startDate = new Date(startVal + 'T00:00:00');
                            if (!isNaN(startDate.getTime())) {
                                const harvestDate = new Date(startDate.getTime());
                                const wholeMonths = Math.floor(periodMonths);
                                const extraDays = Math.round((periodMonths - wholeMonths) * 30);
                                harvestDate.setMonth(harvestDate.getMonth() + wholeMonths);
                                if (extraDays > 0) harvestDate.setDate(harvestDate.getDate() + extraDays);
                                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                                harvestDisplay.textContent = `${harvestDate.toLocaleDateString('en-US', options)} (in ${periodMonths} Months)`;
                            }
                        }
                    }

                    function addStageRow(name, start, end) {
                        const container = document.getElementById('timeline_stages_container');
                        if (!container) return;

                        if (start === undefined || end === undefined) {
                            let lastEnd = 0;
                            const rows = container.querySelectorAll('.stage-row');
                            if (rows.length > 0) {
                                const lastRow = rows[rows.length - 1];
                                lastEnd = parseFloat(lastRow.querySelector('.stage-end')?.value) || 0;
                            }
                            start = lastEnd;
                            end = Math.round((lastEnd + 1) * 10) / 10;
                        }

                        if (!name) {
                            name = `Cultivation Stage ${container.querySelectorAll('.stage-row').length + 1}`;
                        }

                        const dur = Math.round((end - start) * 10) / 10;
                        const div = document.createElement('div');
                        div.className = 'row g-2 mb-2 align-items-center stage-row';
                        div.innerHTML = `
                            <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="${name}" oninput="syncTimelineJson()"></div>
                            <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="${start}" oninput="updateStageRowDuration(this)"></div>
                            <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="${end}" oninput="updateStageRowDuration(this)"></div>
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="${dur === 1 ? '1 Month' : dur + ' Months'}" readonly></div>
                            <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                        `;
                        container.appendChild(div);

                        // Automatically update yielding period when new stage is added!
                        recalcTotalStagesDuration(true);
                        syncTimelineJson();
                    }

                    function removeStageRow(btn) {
                        const row = btn.closest('.stage-row');
                        if (row) {
                            row.remove();
                            // Automatically recalculate yielding period
                            recalcTotalStagesDuration(true);
                            syncTimelineJson();
                        }
                    }

                    function resetDefaultStages() {
                        const cat = document.getElementById('wiz_category')?.value || 'Vegetables';
                        const months = CROP_CATEGORY_DURATIONS[cat] || 4;
                        setYieldingPeriodAndRebuildStages(months);
                    }

                    function buildDefaultStagesForPeriod(period) {
                        const container = document.getElementById('timeline_stages_container');
                        if (!container) return;

                        period = Math.max(1, period);

                        let s1_end, s2_end, s3_end, s4_end, s5_end;
                        if (period <= 3) {
                            s1_end = 0.5;
                            s2_end = 1.0;
                            s3_end = 2.0;
                            s4_end = 2.5;
                            s5_end = period;
                        } else if (period <= 4) {
                            s1_end = 0.5;
                            s2_end = 1.0;
                            s3_end = 2.5;
                            s4_end = 3.5;
                            s5_end = period;
                        } else if (period <= 5) {
                            s1_end = 1.0;
                            s2_end = 1.5;
                            s3_end = 3.0;
                            s4_end = 4.0;
                            s5_end = period;
                        } else if (period <= 6) {
                            s1_end = 1.0;
                            s2_end = 2.0;
                            s3_end = 4.0;
                            s4_end = 5.0;
                            s5_end = period;
                        } else {
                            s1_end = Math.round(period * 0.15 * 10) / 10;
                            s2_end = Math.round(period * 0.30 * 10) / 10;
                            s3_end = Math.round(period * 0.65 * 10) / 10;
                            s4_end = Math.round(period * 0.85 * 10) / 10;
                            s5_end = period;
                        }

                        const stages = [
                            { name: 'Land Preparation & Soil Tillage', start: 0, end: s1_end },
                            { name: 'Sowing, Nursery & Germination', start: s1_end, end: s2_end },
                            { name: 'Vegetative Growth & Fertilization', start: s2_end, end: s3_end },
                            { name: 'Flowering & Maturation', start: s3_end, end: s4_end },
                            { name: 'Harvesting, Curing & Produce Off-take', start: s4_end, end: s5_end }
                        ];

                        let html = '';
                        stages.forEach(st => {
                            const dur = Math.round((st.end - st.start) * 10) / 10;
                            const durText = dur === 1 ? '1 Month' : `${dur} Months`;
                            html += `
                                <div class="row g-2 mb-2 align-items-center stage-row">
                                    <div class="col-md-4"><input type="text" class="form-control form-control-sm stage-name" value="${st.name}" oninput="syncTimelineJson()"></div>
                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-start" value="${st.start}" oninput="updateStageRowDuration(this)"></div>
                                    <div class="col-md-2"><input type="number" step="0.5" min="0" class="form-control form-control-sm stage-end" value="${st.end}" oninput="updateStageRowDuration(this)"></div>
                                    <div class="col-md-3"><input type="text" class="form-control form-control-sm stage-dur bg-white" value="${durText}" readonly></div>
                                    <div class="col-md-1 text-center"><button type="button" class="btn btn-sm text-danger" onclick="removeStageRow(this)"><i class="fas fa-times"></i></button></div>
                                </div>
                            `;
                        });

                        container.innerHTML = html;
                        recalcTotalStagesDuration(false);
                        syncTimelineJson();
                    }

                    function syncTimelineJson() {
                        const stages = [];
                        document.querySelectorAll('.stage-row').forEach(row => {
                            const name = row.querySelector('.stage-name')?.value?.trim() || '';
                            const start = parseFloat(row.querySelector('.stage-start')?.value) || 0;
                            const end = parseFloat(row.querySelector('.stage-end')?.value) || 0;
                            const dur = Math.max(0, end - start);
                            if (name) {
                                stages.push({
                                    stage: name,
                                    start_month: start,
                                    end_month: end,
                                    duration_months: dur
                                });
                            }
                        });
                        const hidden = document.getElementById('farming_timeline_json');
                        if (hidden) {
                            hidden.value = JSON.stringify(stages);
                        }
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
                                const val = parseFloat(input?.value);
                                const invalidVal = input === target ? (isNaN(val) || val <= 0) : (isNaN(val) || val < 0);
                                if (!input || !input.value.trim() || invalidVal) {
                                    isValid = false;
                                    input?.classList.add('is-invalid');
                                    if (!firstInvalid) firstInvalid = input;
                                } else {
                                    input?.classList.remove('is-invalid');
                                }
                            });
                        }

                        // Validate Step 4: Yield & Timeline
                        if (stepNum === 4) {
                            const period = document.getElementById('wiz_yielding_period');
                            const startDate = document.getElementById('wiz_start_date');

                            if (!period || !period.value.trim() || parseInt(period.value, 10) <= 0) {
                                isValid = false;
                                period?.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = period;
                            } else {
                                period?.classList.remove('is-invalid');
                            }

                            if (!startDate || !startDate.value.trim()) {
                                isValid = false;
                                startDate?.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = startDate;
                            } else {
                                startDate?.classList.remove('is-invalid');
                            }
                        }

                        // Validate Step 5: Investment Limits
                        if (stepNum === 5) {
                            const minInvInput = document.getElementById('wiz_min_inv');
                            const maxInvInput = document.getElementById('wiz_max_inv');
                            const targetInput = document.getElementById('wiz_funding_target');
                            const termsCheck = document.getElementById('wiz_terms');

                            // Reset error highlights before checking
                            minInvInput?.classList.remove('is-invalid');
                            maxInvInput?.classList.remove('is-invalid');

                            const minInv = parseFloat(minInvInput?.value) || 0;
                            const maxInv = parseFloat(maxInvInput?.value) || 0;
                            const askAmt = parseFloat(targetInput?.value) || 0;

                            if (minInv <= 0 || minInvInput?.value === '') {
                                isValid = false;
                                minInvInput?.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = minInvInput;
                            }

                            if (maxInv <= 0 || maxInvInput?.value === '') {
                                isValid = false;
                                maxInvInput?.classList.add('is-invalid');
                                if (!firstInvalid) firstInvalid = maxInvInput;
                            }

                            if (minInv > maxInv) {
                                isValid = false;
                                minInvInput?.classList.add('is-invalid');
                                maxInvInput?.classList.add('is-invalid');
                                alert(`Invalid Limits: Minimum investment (₹${minInv.toLocaleString('en-IN')}) cannot be greater than Maximum investment (₹${maxInv.toLocaleString('en-IN')}).`);
                                return false;
                            }

                            if (askAmt > 0 && minInv > askAmt) {
                                isValid = false;
                                minInvInput?.classList.add('is-invalid');
                                alert(`Invalid Limits: Minimum investment (₹${minInv.toLocaleString('en-IN')}) cannot be greater than total Ask Amount (₹${askAmt.toLocaleString('en-IN')}).`);
                                return false;
                            }

                            if (askAmt > 0 && maxInv > askAmt) {
                                isValid = false;
                                maxInvInput?.classList.add('is-invalid');
                                alert(`Invalid Limits: Maximum investment (₹${maxInv.toLocaleString('en-IN')}) cannot be greater than total Ask Amount (₹${askAmt.toLocaleString('en-IN')}).`);
                                return false;
                            }

                            if (termsCheck && !termsCheck.checked) {
                                isValid = false;
                                alert("You must agree to the terms before proceeding.");
                                return false;
                            }
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
                        calculateBudgetTotal(false);

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
                        if (step === 4) {
                            updateYieldTabSummary();
                        }

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
                        
                        const totalBudget = parseFloat(document.getElementById('wiz_total_budget')?.value || 0);
                        const targetVal = parseFloat(document.getElementById('wiz_funding_target')?.value || 0);
                        const contribVal = parseFloat(document.getElementById('wiz_your_contribution')?.value || 0);
                        const calculatedRoi = parseFloat(document.getElementById('wiz_calculated_roi')?.value || 0);
                        const annualizedRoi = parseFloat(document.getElementById('wiz_annualized_roi')?.value || 0);
                        const activeRoi = document.getElementById('wiz_roi')?.value || '0';
                        const isOverridden = document.getElementById('wiz_is_roi_overridden')?.checked;
                        const overrideReason = document.getElementById('wiz_override_reason')?.value || '';

                        const pct = totalBudget > 0 ? Math.round((contribVal / totalBudget) * 100) : 0;

                        if (document.getElementById('rev_name')) document.getElementById('rev_name').textContent = name;
                        if (document.getElementById('rev_acres')) document.getElementById('rev_acres').textContent = acres + ' Acres';
                        if (document.getElementById('rev_category')) document.getElementById('rev_category').textContent = category;
                        if (document.getElementById('rev_crop')) document.getElementById('rev_crop').textContent = crop;
                        if (document.getElementById('rev_secondary_crop')) document.getElementById('rev_secondary_crop').textContent = secCrop;
                        if (document.getElementById('rev_location')) document.getElementById('rev_location').textContent = location;

                        if (document.getElementById('rev_total_budget')) document.getElementById('rev_total_budget').textContent = '₹ ' + Number(totalBudget).toLocaleString('en-IN');
                        if (document.getElementById('rev_target')) document.getElementById('rev_target').textContent = '₹ ' + Number(targetVal).toLocaleString('en-IN');
                        if (document.getElementById('rev_contrib')) document.getElementById('rev_contrib').textContent = '₹ ' + Number(contribVal).toLocaleString('en-IN') + ' (' + pct + '%)';
                        if (document.getElementById('rev_roi')) {
                            document.getElementById('rev_roi').textContent = activeRoi + '% (Cycle ROI)';
                        }
                        if (document.getElementById('rev_annualized_roi')) {
                            document.getElementById('rev_annualized_roi').textContent = annualizedRoi + '% Annualized';
                        }
                        const overrideBadgeEl = document.getElementById('rev_override_badge');
                        if (overrideBadgeEl) {
                            if (isOverridden) {
                                overrideBadgeEl.innerHTML = `<span class="badge bg-warning text-dark"><i class="fas fa-user-shield me-1"></i>Overridden from ${calculatedRoi}% (Reason: ${overrideReason || 'Admin specified'})</span>`;
                                overrideBadgeEl.style.display = 'block';
                            } else {
                                overrideBadgeEl.style.display = 'none';
                            }
                        }

                        // Sync budget allocation rows
                        const budgetRows = [];
                        let budgetTotal = 0;
                        document.querySelectorAll('#budget_table_body tr').forEach(tr => {
                            const purpose = tr.querySelector('.b-purpose')?.value || '';
                            const qty = tr.querySelector('.b-qty')?.value || '';
                            const unit = tr.querySelector('.b-unit')?.value || 'kg';
                            const rate = tr.querySelector('.b-rate')?.value || '';
                            const amount = parseFloat(tr.querySelector('.b-amount')?.value || 0);
                            if (purpose && amount > 0) {
                                const unitBadge = (qty && rate) ? `<span class="badge bg-light text-secondary border ms-1" style="font-size: 10px;">${qty} ${unit} @ ₹${rate}</span>` : '';
                                budgetRows.push(`<tr><td>${purpose} ${unitBadge}</td><td class="text-end fw-semibold">₹ ${Number(amount).toLocaleString('en-IN')}</td></tr>`);
                                budgetTotal += amount;
                            }
                        });
                        if (document.getElementById('rev_budget_rows')) {
                            document.getElementById('rev_budget_rows').innerHTML = budgetRows.length ? budgetRows.join('') : '<tr><td colspan="2" class="text-muted text-center">No allocations added</td></tr>';
                        }
                        if (document.getElementById('rev_budget_total')) {
                            document.getElementById('rev_budget_total').textContent = '₹ ' + Number(budgetTotal).toLocaleString('en-IN');
                        }

                        // Sync Step 4 Yield & Timeline Review
                        const revYieldTons = document.getElementById('rev_yield_tons');
                        const revYieldKg = document.getElementById('rev_yield_kg');
                        const revPeriod = document.getElementById('rev_period');
                        const revCycleDays = document.getElementById('rev_cycle_days');
                        const revStartDate = document.getElementById('rev_start_date');
                        const revHarvestDate = document.getElementById('rev_harvest_date');

                        const yieldKgVal = parseFloat(document.getElementById('wiz_expected_yield_kg')?.value || 0);
                        const periodMonthsVal = parseInt(document.getElementById('wiz_yielding_period')?.value, 10) || 6;
                        const startVal = document.getElementById('wiz_start_date')?.value || '';

                        if (revYieldTons) revYieldTons.textContent = (yieldKgVal / 1000).toFixed(2) + ' Tons';
                        if (revYieldKg) revYieldKg.textContent = Number(yieldKgVal).toLocaleString('en-IN') + ' kg';
                        if (revPeriod) revPeriod.textContent = periodMonthsVal + ' Months';
                        if (revCycleDays) revCycleDays.textContent = '≈ ' + (periodMonthsVal * 30) + ' Days';

                        if (revStartDate && startVal) {
                            const sDate = new Date(startVal + 'T00:00:00');
                            if (!isNaN(sDate.getTime())) {
                                revStartDate.textContent = sDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            } else {
                                revStartDate.textContent = startVal;
                            }
                        }

                        const projectedDateEl = document.getElementById('wiz_projected_harvest_display');
                        if (revHarvestDate) {
                            revHarvestDate.textContent = projectedDateEl ? projectedDateEl.textContent : '—';
                        }

                        const timelineRows = [];
                        let stageCount = 0;
                        document.querySelectorAll('.stage-row').forEach(row => {
                            const name = row.querySelector('.stage-name')?.value?.trim();
                            const start = row.querySelector('.stage-start')?.value;
                            const end = row.querySelector('.stage-end')?.value;
                            const dur = row.querySelector('.stage-dur')?.value;
                            if (name) {
                                stageCount++;
                                timelineRows.push(`<tr><td><span class="badge bg-light text-dark border me-1">${stageCount}</span> ${name}</td><td>Month ${start} → Month ${end}</td><td class="text-end fw-semibold text-success">${dur}</td></tr>`);
                            }
                        });
                        if (document.getElementById('rev_timeline_rows')) {
                            document.getElementById('rev_timeline_rows').innerHTML = timelineRows.length ? timelineRows.join('') : '<tr><td colspan="3" class="text-muted text-center">No stages added</td></tr>';
                        }
                        if (document.getElementById('rev_stages_badge')) {
                            document.getElementById('rev_stages_badge').textContent = `${stageCount} Stages (${periodMonthsVal} Months)`;
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

                    document.addEventListener('DOMContentLoaded', function() {
                        // Listen for crop name typing to auto-detect category and yielding months
                        const primaryCropInput = document.getElementById('wiz_primary_crop');
                        if (primaryCropInput) {
                            primaryCropInput.addEventListener('input', function() {
                                const detectedCat = detectCropCategory(this.value);
                                if (detectedCat) {
                                    const catBtn = Array.from(document.querySelectorAll('.cat-pill')).find(b => b.textContent.trim().toLowerCase() === detectedCat.toLowerCase());
                                    if (catBtn) selectCategory(detectedCat, catBtn);
                                }
                            });
                        }

                        // Initialize yielding period from current category if empty or default
                        const activeCatBtn = document.querySelector('.cat-pill.active');
                        const cat = activeCatBtn ? activeCatBtn.textContent.trim() : (document.getElementById('wiz_category')?.value || 'Vegetables');
                        const defaultMonths = CROP_CATEGORY_DURATIONS[cat] || 3;
                        const periodInput = document.getElementById('wiz_yielding_period');
                        if (periodInput && (!periodInput.value || periodInput.value === '6')) {
                            periodInput.value = defaultMonths;
                            buildDefaultStagesForPeriod(defaultMonths);
                        }

                        updateYieldTabSummary();
                        recalcTotalStagesDuration(false);
                        syncTimelineJson();
                    });
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
                            action="<?php echo e(route('admin.farms.updates.store', $myFarms->first()?->id ?? ($availableFarms->first()?->id ?? 1))); ?>"
                            method="POST" enctype="multipart/form-data" id="farmUpdatePostForm">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold" style="font-size: 12px;">Select Farm
                                        Plot</label>
                                    <select name="farm_id" class="form-select rounded-3" style="font-size: 12px;" required
                                        onchange="document.getElementById('farmUpdatePostForm').action = '<?php echo e(url('/admin/farms')); ?>/' + this.value + '/updates'">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $myFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($f->id); ?>"><?php echo e($f->name); ?> (<?php echo e($f->primary_crop); ?>)</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $displayFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farmItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <div class="fw-bold text-dark fs-6"><?php echo e($farmItem->name); ?></div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <i
                                            class="fas fa-map-marker-alt text-danger me-1"></i><?php echo e($farmItem->location ?? ($farmItem->farmer?->village . ', ' . $farmItem->farmer?->district) ?? 'Kerala, India'); ?>

                                        • <?php echo e($farmItem->primary_crop); ?>

                                    </div>
                                </div>
                                <a href="<?php echo e(route('admin.farms.show', $farmItem->id)); ?>"
                                    class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 11px;">
                                    View Farm Page <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $farmItem->updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white border-start border-4 border-success">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold mb-2"
                                                style="font-size: 10px;">
                                                <?php echo e($farmItem->status === 'approved' ? 'Active Cycle' : 'Pending'); ?>

                                            </span>
                                            <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;"><?php echo e($update->title); ?></h5>
                                            <div class="text-muted" style="font-size: 10px;">
                                                Updated <?php echo e($update->created_at ? $update->created_at->diffForHumans() : 'recently'); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted my-3" style="font-size: 12px; line-height: 1.6;">
                                        <?php echo e($update->description); ?>

                                    </p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($update->image_path): ?>
                                        <div class="mb-3">
                                            <img src="<?php echo e(asset('storage/' . $update->image_path)); ?>" class="img-fluid rounded-3 shadow-sm"
                                                style="max-height: 220px; object-fit: cover;">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white text-center">
                                    <i class="fas fa-bullhorn text-muted opacity-50 fa-2x mb-2"></i>
                                    <div class="fw-bold text-dark" style="font-size: 13px;">No updates published for
                                        <?php echo e($farmItem->name); ?>

                                        yet
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">Use the "Post New Update" button above to publish
                                        crop
                                        progress logs to investors.</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                            <i class="fas fa-seedling text-success opacity-50 fa-3x mb-3"></i>
                            <h5 class="fw-bold text-dark">No Farm Plots Available</h5>
                            <p class="text-muted small">Register a new farm plot to start posting live updates to investors.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- 4.5 Harvest Management Tab Module (Figma Exact & 100% Dynamic) -->
                <div class="farmer-tab-content tab-pane fade <?php echo e(request('tab') === 'harvest-management' ? 'show active' : ''); ?>"
                    id="tab-harvest-management" role="tabpanel"
                    style="<?php echo e(request('tab') === 'harvest-management' ? 'display:block;' : 'display:none;'); ?>">
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $allFarmsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farmItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                    <div class="position-relative" style="height: 140px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farmItem->farm_photo_path): ?>
                                            <img src="<?php echo e(asset('storage/' . $farmItem->farm_photo_path)); ?>" class="w-100 h-100"
                                                style="object-fit: cover;">
                                        <?php else: ?>
                                            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="position-absolute top-0 start-0 w-100 h-100"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                                        <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                            <span class="badge bg-success rounded-pill px-2.5 py-1 fw-bold mb-1"
                                                style="font-size: 9px;"><?php echo e($farmItem->primary_crop); ?></span>
                                            <div class="fw-bold fs-6"><?php echo e($farmItem->name); ?></div>
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="bg-light rounded-3 p-2 text-center">
                                                    <div class="text-muted fw-bold text-uppercase" style="font-size: 9px;">Yield
                                                        Tonnage</div>
                                                    <div class="fw-bold text-dark" style="font-size: 12px;">
                                                        <?php
                                                            $dispTons = $farmItem->harvests->where('status', '!=', 'gallery_photo')->first()?->actual_yield
                                                                ?? ($farmItem->projected_yield_kg ? round($farmItem->projected_yield_kg / 1000, 2) : ($farmItem->expected_yield ?? 12.5));
                                                        ?>
                                                        <?php echo e(number_format((float) $dispTons, 2)); ?> Tons
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
                                            <strong class="text-dark"><?php echo e($farmItem->location ?? 'Kerala'); ?></strong>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3"
                                            style="font-size: 11px;">
                                            <span class="text-muted"><i class="fas fa-clock text-primary me-1"></i>Yielding
                                                Period:</span>
                                            <strong class="text-dark"><?php echo e($farmItem->yielding_period ?? 6); ?> Months</strong>
                                        </div>

                                        <div class="pt-3 border-top d-flex gap-2">
                                            <a href="<?php echo e(route('admin.farms.show', $farmItem->id)); ?>#harvest"
                                                class="btn btn-success rounded-pill w-100 fw-bold py-2" style="font-size: 11px;">
                                                <i class="fas fa-eye me-1"></i> View Details & Harvest
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                                    <i class="fas fa-wheat-awn text-success opacity-50 fa-3x mb-3"></i>
                                    <h5 class="fw-bold text-dark">No Active Harvest Records</h5>
                                    <p class="text-muted small">Register a farm plot to monitor crop harvest milestones.</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $salesAndProofs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="ps-4 text-muted">
                                                <?php echo e($sale->sale_date ? $sale->sale_date->format('d M Y') : $sale->created_at->format('d M Y')); ?>

                                            </td>
                                            <td class="fw-bold text-dark">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Illuminate\Support\Str::endsWith(strtolower($sale->invoice_path ?? ''), '.pdf')): ?>
                                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-image text-primary me-2"></i>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php echo e($sale->invoice_path ? basename($sale->invoice_path) : 'Sale_Receipt_#' . $sale->id); ?>

                                            </td>
                                            <td><?php echo e($sale->farm->name ?? 'N/A'); ?></td>
                                            <td class="fw-bold">₹ <?php echo e(number_format($sale->sale_amount)); ?></td>
                                            <td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sale->status === 'verified' || $sale->status === 'approved'): ?>
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 border border-success border-opacity-25">Verified</span>
                                                <?php elseif($sale->status === 'pending'): ?>
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 border border-warning border-opacity-25">Pending
                                                        Review</span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 border border-secondary border-opacity-25"><?php echo e(ucfirst($sale->status ?? 'Draft')); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td class="pe-4 text-end">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sale->invoice_path): ?>
                                                    <a href="<?php echo e(Storage::url($sale->invoice_path)); ?>" target="_blank"
                                                        class="btn btn-light btn-sm rounded-pill fw-bold text-success px-3"
                                                        style="font-size: 10px;">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted" style="font-size: 10px;">No file</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fa-2x mb-3 text-black-50 opacity-50"></i>
                                                <p class="mb-0 fw-bold">No sales proofs or invoices uploaded yet.</p>
                                                <p class="small">Upload a document to securely record it on the ledger.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <?php echo e(number_format($myFarms->avg('expected_roi') ?? 0, 1)); ?>%
                                </h3>
                                <div class="text-muted" style="font-size: 10px;">Expected</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-white shadow-sm rounded-4 p-3 h-100">
                                <div class="text-muted fw-semibold" style="font-size: 10px; text-transform: uppercase;">PENDING
                                    DISBURSEMENTS</div>
                                <h3 class="fw-bold text-danger my-1" style="font-size: 20px;">₹
                                    <?php echo e(number_format($myFarms->sum('pending_disbursement_amount') ?? 0)); ?>

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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;"><?php echo e($farm->name); ?></h6>
                                            <div class="text-muted" style="font-size: 10px;">ID: <?php echo e($farm->id); ?> •
                                                <?php echo e($farm->primary_crop); ?>

                                            </div>
                                        </div>
                                        <span
                                            class="badge bg-<?php echo e($farm->status === 'completed' ? 'success' : ($farm->status === 'approved' ? 'primary' : 'warning')); ?> text-white rounded-pill px-2.5 py-1"
                                            style="font-size: 9px;"><?php echo e(strtoupper($farm->status)); ?></span>
                                    </div>

                                    <div class="my-3">
                                        <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">TOTAL FUNDING
                                            RAISED</div>
                                        <div class="fw-bold text-dark" style="font-size: 18px;">₹
                                            <?php echo e(number_format($farm->funding_raised)); ?>

                                        </div>
                                    </div>

                                    <div class="bg-light rounded-3 p-3 mb-3" style="font-size: 11px;">
                                        <div class="fw-bold text-dark mb-2" style="font-size: 10px; text-transform: uppercase;">
                                            SETTLEMENT CHECKLIST</div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Blockchain
                                                Payout</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Completed</span>
                                            <?php else: ?>
                                                <span class="fw-bold text-muted">Pending</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Investor
                                                Disbursement</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Disbursed</span>
                                            <?php else: ?>
                                                <span class="fw-bold text-muted">Pending</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Final
                                                Audit</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Verified</span>
                                            <?php else: ?>
                                                <span class="fw-bold text-muted">Pending</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted"><i class="fas fa-check text-success me-1"></i>Tax
                                                Compliance</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                <span class="fw-bold text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Cleared</span>
                                            <?php else: ?>
                                                <span class="fw-bold text-muted">Pending</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-light rounded-3 w-100 py-2 fw-semibold text-dark mt-auto"
                                        style="font-size: 11px;" data-bs-toggle="modal"
                                        data-bs-target="#farmSettlementModal<?php echo e($farm->id); ?>">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </button>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="col-12 text-center py-4">
                                <div class="text-muted mb-2"><i class="fas fa-folder-open fa-2x opacity-50"></i></div>
                                <h6>No settlements found</h6>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Farm Settlement Modals (Outside Card Stacking Context) -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $myFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="modal fade text-start" id="farmSettlementModal<?php echo e($farm->id); ?>" tabindex="-1"
                            aria-labelledby="farmSettlementModalLabel<?php echo e($farm->id); ?>" aria-hidden="true" data-bs-backdrop="static">
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
                                                    id="farmSettlementModalLabel<?php echo e($farm->id); ?>"><?php echo e($farm->name); ?> - Settlement
                                                    Ledger</h5>
                                                <small class="text-white-50">Farm Plot ID: #<?php echo e($farm->id); ?> • Crop:
                                                    <?php echo e($farm->primary_crop); ?></small>
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
                                                        class="fw-bold text-dark fs-6">₹<?php echo e(number_format($farm->funding_target)); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Total Capital Raised</small>
                                                    <span
                                                        class="fw-bold text-success fs-6">₹<?php echo e(number_format($farm->funding_raised)); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Total Acres</small>
                                                    <span class="fw-bold text-dark fs-6"><?php echo e($farm->total_acres); ?> Acres</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white rounded-3 border">
                                                    <small class="text-muted text-uppercase fw-bold d-block mb-1"
                                                        style="font-size: 10px;">Expected ROI</small>
                                                    <span class="fw-bold text-info fs-6"><?php echo e($farm->expected_roi ?? 15); ?>%</span>
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
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Completed</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Settlement</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Disbursed</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Settlement</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Verified & Passed</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Final Audit</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'completed'): ?>
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Cleared</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Clearance</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-white p-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">Close</button>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()?->is_admin && $farm->status !== 'completed'): ?>
                                            <form action="<?php echo e(route('admin.farms.settle', $farm)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                                    <i class="fas fa-check-circle me-1"></i> Finalize Settlement Now
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('admin.farms.show', $farm)); ?>"
                                                class="btn btn-primary rounded-pill px-4 fw-bold">
                                                <i class="fas fa-external-link-alt me-1"></i> Open Full Farm Details
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                                <h3 class="fw-bold text-success mb-2"><?php echo e($myFarms->sum('total_acres') ?? 0); ?> Acres</h3>
                                <div class="text-muted" style="font-size: 11px;">Across <?php echo e($myFarms->count()); ?> Active Farms
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                                <div class="text-muted fw-bold mb-1" style="font-size: 10px; text-transform: uppercase;">ACTIVE
                                    INVESTOR CAPITAL</div>
                                <h3 class="fw-bold text-dark mb-2">₹ <?php echo e(number_format($myFarms->sum('funding_raised') ?? 0)); ?>

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
                                    <?php echo e($estYield > 0 ? number_format($estYield) . ' Tons' : 'Pending'); ?>

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
                                        <th class="py-3 border-0 fw-semibold text-uppercase text-center"
                                            style="font-size: 10px;">Verification Status</th>
                                        <th class="pe-3 py-3 rounded-end border-0 fw-semibold text-uppercase text-end"
                                            style="font-size: 10px;">Portfolio Tracking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myFarms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr class="border-bottom">
                                            <td class="ps-3 py-3 text-dark fw-bold"><?php echo e($farm->name); ?></td>
                                            <td class="py-3"><?php echo e($farm->primary_crop); ?></td>
                                            <td class="py-3"><?php echo e($farm->total_acres); ?> Acres</td>
                                            <td class="py-3 text-success fw-semibold">₹ <?php echo e(number_format($farm->funding_raised)); ?>

                                            </td>
                                            <td class="py-3 fw-bold"><?php echo e($farm->expected_roi ?? 0); ?>%</td>
                                            <td class="py-3 text-center">
                                                <span
                                                    class="badge bg-<?php echo e($farm->status === 'completed' ? 'dark text-white' : ($farm->status === 'approved' ? 'success' : 'warning')); ?> bg-opacity-10 text-<?php echo e($farm->status === 'completed' ? 'white' : ($farm->status === 'approved' ? 'success' : 'warning')); ?> px-3 py-2 rounded-pill fw-bold"
                                                    style="font-size: 10px;">
                                                    <i
                                                        class="fas fa-<?php echo e($farm->status === 'completed' ? 'check-double text-white' : ($farm->status === 'approved' ? 'check-circle' : 'clock')); ?> me-1"></i>
                                                    <?php echo e(strtoupper($farm->status === 'completed' ? 'FINALIZED' : $farm->status)); ?>

                                                </span>
                                            </td>
                                            <td class="pe-3 py-3 text-end">
                                                <a href="<?php echo e(route('investor.portfolio.track', $farm->id)); ?>"
                                                    class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold shadow-sm"
                                                    style="font-size: 11px;">
                                                    <i class="fas fa-chart-line me-1"></i> Track Farm
                                                </a>
                                                <a href="<?php echo e(route('admin.farms.show', $farm->id)); ?>"
                                                    class="btn btn-sm btn-light rounded-pill px-2.5 py-1 text-muted border ms-1"
                                                    style="font-size: 11px;" title="Farm Management">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-seedling fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">No farms registered yet.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                        <th class="py-3 border-0 fw-semibold text-uppercase text-center"
                                            style="font-size: 10px;">Status</th>
                                        <th class="pe-3 py-3 rounded-end border-0 fw-semibold text-uppercase text-end"
                                            style="font-size: 10px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myFarmInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr class="border-bottom">
                                            <td class="ps-3 py-3 text-dark fw-bold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 12px;">
                                                        <?php echo e(strtoupper(substr($inv->user->name, 0, 2))); ?>

                                                    </div>
                                                    <?php echo e($inv->user->name); ?>

                                                </div>
                                            </td>
                                            <td class="py-3 text-muted"><?php echo e($inv->farm->name); ?></td>
                                            <td class="py-3 text-success fw-bold">₹ <?php echo e(number_format($inv->amount)); ?></td>
                                            <td class="py-3 text-primary fw-bold"><?php echo e(number_format($inv->equity_share, 1)); ?>%</td>
                                            <td class="py-3 text-center">
                                                <span
                                                    class="badge bg-<?php echo e($inv->status === 'approved' ? 'success' : 'warning'); ?> bg-opacity-10 text-<?php echo e($inv->status === 'approved' ? 'success' : 'warning'); ?> px-3 py-2 rounded-pill fw-bold"
                                                    style="font-size: 10px;">
                                                    <?php echo e(strtoupper($inv->status)); ?>

                                                </span>
                                            </td>
                                            <td class="pe-3 py-3 text-end">
                                                <a href="<?php echo e(route('investor.portfolio.track', $inv->farm_id)); ?>"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 fw-bold"
                                                    style="font-size: 10px;">
                                                    <i class="fas fa-eye me-1"></i> Track Position
                                                </a>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No investments have been made in
                                                your farms yet.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><?php echo e(auth()->user()->name); ?></h5>
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
                                    value="<?php echo e(auth()->user()->farmer?->full_name ?? auth()->user()->name); ?>" readonly
                                    style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Email Address</label>
                                <input type="email" class="form-control rounded-3 py-2" value="<?php echo e(auth()->user()->email); ?>"
                                    readonly style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">District / State</label>
                                <input type="text" class="form-control rounded-3 py-2"
                                    value="<?php echo e(auth()->user()->farmer?->district ?? 'Anantapur'); ?>, <?php echo e(auth()->user()->farmer?->state ?? 'Andhra Pradesh'); ?>"
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
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-shield-alt text-success me-2"></i>Security & Change Password</h6>
                        <form action="<?php echo e(route('password.change')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e(auth()->user()->email); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->changePassword->any()): ?>
                                <div class="alert alert-danger p-2 mb-3 small">
                                    <ul class="mb-0">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->changePassword->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <li><?php echo e($err); ?></li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small fw-bold">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" class="form-control rounded-3" placeholder="••••••••" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small fw-bold">New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" class="form-control rounded-3" placeholder="Min. 8 characters" minlength="8" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small fw-bold">Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password_confirmation" class="form-control rounded-3" placeholder="Confirm new password" minlength="8" required>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm"
                                        style="font-size: 11px; background-color: #064e3b; border-color: #064e3b;">
                                        <i class="fas fa-key me-1"></i> Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Farmer Farm Details Quick-View Modals (Outside .tab-content so they always popup cleanly) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $myFarms ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $mTarget = $farm->funding_target > 0 ? $farm->funding_target : 1;
                    $mRaised = $farm->funding_raised ?? 0;
                    $mPerc = min(100, round(($mRaised / $mTarget) * 100));
                    $mBudget = is_array($farm->budget_breakdown) ? $farm->budget_breakdown : (json_decode($farm->budget_breakdown ?? '[]', true) ?: []);
                    $mTimeline = is_array($farm->farming_timeline) ? $farm->farming_timeline : (json_decode($farm->farming_timeline ?? '[]', true) ?: []);
                ?>
                <div class="modal fade text-start" id="farmDetailsModal<?php echo e($farm->id); ?>" tabindex="-1"
                    aria-labelledby="farmDetailsModalLabel<?php echo e($farm->id); ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header border-0 text-white p-4"
                                style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        <h5 class="modal-title fw-bold mb-0" id="farmDetailsModalLabel<?php echo e($farm->id); ?>">
                                            <?php echo e($farm->name); ?>

                                        </h5>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->status === 'approved'): ?>
                                            <span class="badge bg-light text-success rounded-pill px-2.5 py-1 fw-bold"
                                                style="font-size: 10px;">Approved</span>
                                        <?php elseif($farm->status === 'completed'): ?>
                                            <span class="badge bg-dark text-white rounded-pill px-2.5 py-1 fw-bold"
                                                style="font-size: 10px;">Completed</span>
                                        <?php elseif($farm->status === 'rejected'): ?>
                                            <span class="badge bg-danger text-white rounded-pill px-2.5 py-1 fw-bold"
                                                style="font-size: 10px;">Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fw-bold"
                                                style="font-size: 10px;">Pending Review</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="text-white-50" style="font-size: 11px;">
                                        #FARM-<?php echo e(str_pad($farm->id, 4, '0', STR_PAD_LEFT)); ?> &bull;
                                        <i class="fas fa-map-marker-alt me-1"></i><?php echo e($farm->location ?? 'Kerala'); ?>

                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-4 bg-light">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('submitted_farm_id') == $farm->id): ?>
                                    <div class="alert alert-success border-0 rounded-3 d-flex align-items-center gap-2 mb-3 py-2.5 px-3"
                                        style="font-size: 12px;">
                                        <i class="fas fa-check-circle fs-5"></i>
                                        <div><strong>Application Submitted!</strong> Your farm plot details are below and awaiting admin verification.</div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php
                                    $mPhotos = is_array($farm->additional_photos) ? $farm->additional_photos : (json_decode($farm->additional_photos ?? '[]', true) ?: []);
                                    $mDocs = is_array($farm->additional_documents) ? $farm->additional_documents : (json_decode($farm->additional_documents ?? '[]', true) ?: []);
                                ?>

                                <!-- Cover Photo -->
                                <div class="rounded-4 overflow-hidden mb-3 shadow-sm" style="height: 180px;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->farm_photo_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $farm->farm_photo_path)); ?>" class="w-100 h-100"
                                            style="object-fit: cover;">
                                    <?php elseif(count($mPhotos) > 0): ?>
                                        <img src="<?php echo e(asset('storage/' . $mPhotos[0])); ?>" class="w-100 h-100"
                                            style="object-fit: cover;">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=900&auto=format&fit=crop"
                                            class="w-100 h-100" style="object-fit: cover;">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($mPhotos) > 1): ?>
                                    <div class="d-flex gap-2 flex-wrap mb-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pPath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <a href="<?php echo e(asset('storage/' . $pPath)); ?>" target="_blank" class="d-inline-block rounded-3 overflow-hidden border" style="width: 64px; height: 48px;">
                                                <img src="<?php echo e(asset('storage/' . $pPath)); ?>" class="w-100 h-100" style="object-fit: cover;">
                                            </a>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <!-- Core Details Grid -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Primary Crop</div>
                                            <div class="fw-bold text-dark mt-1" style="font-size: 13px;"><?php echo e($farm->primary_crop); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->secondary_crop): ?>
                                                <div class="text-muted" style="font-size: 10px;">Secondary: <?php echo e($farm->secondary_crop); ?></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Total Area</div>
                                            <div class="fw-bold text-dark mt-1" style="font-size: 13px;"><?php echo e($farm->total_acres); ?> Acres</div>
                                            <div class="text-muted" style="font-size: 10px;">Category: <?php echo e($farm->listing_category ?? 'General'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Expected ROI & Cycle</div>
                                            <div class="fw-bold text-success mt-1" style="font-size: 13px;"><?php echo e($farm->expected_roi ?? 15); ?>% ROI</div>
                                            <div class="text-muted" style="font-size: 10px;"><?php echo e($farm->yielding_period ?? 6); ?> Months</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Funding Target</div>
                                            <div class="fw-bold text-dark mt-1" style="font-size: 13px;">₹<?php echo e(number_format($farm->funding_target ?? 0)); ?></div>
                                            <div class="text-muted" style="font-size: 10px;">Your Stake: ₹<?php echo e(number_format($farm->your_contribution ?? 0)); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Investment Limits</div>
                                            <div class="fw-bold text-dark mt-1" style="font-size: 12px;">
                                                ₹<?php echo e(number_format($farm->min_investment ?? 0)); ?> – ₹<?php echo e(number_format($farm->max_investment ?? 0)); ?>

                                            </div>
                                            <div class="text-muted" style="font-size: 10px;">Investors: <?php echo e($farm->investor_count ?? 0); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="bg-white rounded-3 p-3 border h-100">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Expected Start Date</div>
                                            <div class="fw-bold text-dark mt-1" style="font-size: 13px;">
                                                <?php echo e($farm->expected_start_date ? \Carbon\Carbon::parse($farm->expected_start_date)->format('d M Y') : 'N/A'); ?>

                                            </div>
                                            <div class="text-muted" style="font-size: 10px;">Funding: <?php echo e(ucfirst($farm->funding_status ?? 'closed')); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Funding Progress -->
                                <div class="bg-white rounded-3 p-3 border mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 11px;">
                                        <span class="text-muted fw-semibold">Funding Progress (<?php echo e($mPerc); ?>%)</span>
                                        <span class="fw-bold text-success">₹<?php echo e(number_format($mRaised)); ?> / ₹<?php echo e(number_format($mTarget)); ?></span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 7px;">
                                        <div class="progress-bar bg-success rounded-pill" style="width: <?php echo e($mPerc); ?>%;"></div>
                                    </div>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($mBudget) > 0): ?>
                                    <div class="bg-white rounded-3 p-3 border mb-3">
                                        <h6 class="fw-bold text-dark mb-2" style="font-size: 12px;">Budget Breakdown</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0" style="font-size: 11px;">
                                                <tbody>
                                                    <?php $mBudgetSum = 0; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mBudget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <?php $amt = (float)($item['amount'] ?? 0); $mBudgetSum += $amt; ?>
                                                        <tr>
                                                            <td class="text-muted"><?php echo e($item['purpose'] ?? 'Item'); ?></td>
                                                            <td class="text-end fw-semibold text-dark">₹<?php echo e(number_format($amt)); ?></td>
                                                        </tr>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    <tr class="table-light fw-bold">
                                                        <td>Total Budget</td>
                                                        <td class="text-end text-success">₹<?php echo e(number_format($mBudgetSum)); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($mTimeline) > 0): ?>
                                    <div class="bg-white rounded-3 p-3 border mb-3">
                                        <h6 class="fw-bold text-dark mb-2" style="font-size: 12px;">Farming Timeline</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1.5" style="font-size: 10px;">
                                                    <?php echo e($stage['stage'] ?? 'Stage'); ?> (M<?php echo e($stage['start_month'] ?? 0); ?>–M<?php echo e($stage['end_month'] ?? 0); ?>)
                                                </span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($mDocs) > 0): ?>
                                    <div class="bg-white rounded-3 p-3 border mb-3">
                                        <h6 class="fw-bold text-dark mb-2" style="font-size: 12px;">Uploaded Documents</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $docPath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <a href="<?php echo e(asset('storage/' . $docPath)); ?>" target="_blank"
                                                    class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1" style="font-size: 11px;">
                                                    <i class="fas fa-file-pdf text-danger me-1"></i> Document #<?php echo e($idx + 1); ?>

                                                </a>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($farm->admin_notes)): ?>
                                    <div class="alert alert-warning border-0 rounded-3 mb-0 py-2.5 px-3" style="font-size: 11px;">
                                        <strong>Admin Notes:</strong> <?php echo e($farm->admin_notes); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="modal-footer border-0 bg-white px-4 py-3 d-flex justify-content-between flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold"
                                    data-bs-dismiss="modal" style="font-size: 11px;">Close</button>
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('admin.farms.edit', $farm)); ?>"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold"
                                        style="font-size: 11px;">
                                        <i class="fas fa-edit me-1"></i> Edit Farm
                                    </a>
                                    <a href="<?php echo e(route('admin.farms.show', $farm)); ?>"
                                        class="btn btn-success btn-sm rounded-pill px-4 fw-bold"
                                        style="font-size: 11px;">
                                        <i class="fas fa-external-link-alt me-1"></i> Open Full Details Page
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <script>
                function openFarmDetailsModal(farmId) {
                    const modalEl = document.getElementById('farmDetailsModal' + farmId);
                    if (!modalEl) return;
                    if (modalEl.parentElement !== document.body) {
                        document.body.appendChild(modalEl);
                    }
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    }
                }
            </script>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('submitted_farm_id')): ?>
                <script>
                    window.addEventListener('load', function () {
                        openFarmDetailsModal(<?php echo e((int) session('submitted_farm_id')); ?>);
                    });
                </script>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <?php else: ?>
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
                                    <h3 class="fw-bold mb-2 fs-2">Welcome back, <?php echo e(auth()->user()->name); ?>! </h3>
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
                                        ₹<?php echo e(number_format(($myInvestments ?? collect([]))->sum('amount') ?? 0)); ?></h3>
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
                                    <h3 class="fw-bold text-dark mb-1 fs-3">₹<?php echo e(number_format($val)); ?></h3>
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
                                    <h3 class="fw-bold text-dark mb-1 fs-3"><?php echo e(count($myInvestments ?? [])); ?></h3>
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
                                    <h3 class="fw-bold text-dark mb-1 fs-3">₹<?php echo e(number_format(round($totalInv * 0.18))); ?></h3>
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
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                            style="width: 34px; height: 34px;">
                                                            <i class="fas fa-tractor" style="font-size: 12px;"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark"><?php echo e($inv->farm?->name ?? 'Farm Plot'); ?>

                                                            </div>
                                                            <div class="text-muted" style="font-size: 10px;">
                                                                <?php echo e($inv->farm?->location ?? 'Kerala'); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 fw-semibold text-dark">
                                                    <?php echo e($inv->farm?->primary_crop ?? 'Crop'); ?>

                                                </td>
                                                <td class="px-3 py-3 fw-bold text-success fs-6">₹<?php echo e(number_format($inv->amount)); ?>

                                                </td>
                                                <td class="px-3 py-3 fw-bold text-primary">
                                                    <?php echo e(number_format($inv->equity_share, 1)); ?>%
                                                </td>
                                                <td class="px-3 py-3">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->status === 'approved' || $inv->status === 'active'): ?>
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-check-circle me-1"></i> Active</span>
                                                    <?php elseif($inv->status === 'rejected'): ?>
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-times-circle me-1"></i> Rejected</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold"><i
                                                                class="fas fa-clock me-1"></i> Pending Verification</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td class="px-4 py-3 text-end">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->farm): ?>
                                                        <a href="<?php echo e(route('investor.portfolio.track', $inv->farm)); ?>"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-bold"
                                                            style="font-size: 11px;">
                                                            <i class="fas fa-chart-line me-1"></i> View Details
                                                        </a>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
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
                                    <div class="col-md-6 col-lg-4 my-farm-card-item" data-farm-status="<?php echo e($statusKey); ?>">
                                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden"
                                            style="border: 1px solid #e5e7eb !important;">
                                            <!-- Cover Photo Header with Status Badge -->
                                            <div class="position-relative" style="height: 160px;">
                                                <img src="<?php echo e($inv->farm?->farm_photo_path ? asset('storage/' . $inv->farm->farm_photo_path) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop'); ?>"
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
                                                    <h5 class="fw-bold text-dark mb-0 fs-6"><?php echo e($inv->farm?->name ?? 'Sun-Grown Orchards'); ?>

                                                    </h5>
                                                    <span class="text-warning fw-bold small" style="font-size: 11px;"><i
                                                            class="fas fa-star me-1"></i>4.7</span>
                                                </div>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    <?php echo e($inv->farm?->location ?? 'Nashik, Maharashtra'); ?>

                                                </p>

                                                <!-- Farmer & Crop Row -->
                                                <div class="row g-2 mb-3 pb-3 border-bottom text-muted" style="font-size: 10px;">
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-semibold mb-0.5" style="letter-spacing: 0.5px;">FARMER
                                                        </div>
                                                        <strong
                                                            class="text-dark d-block text-truncate"><?php echo e($inv->farm?->farmer?->full_name ?? 'Ramesh Kumar'); ?></strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-semibold mb-0.5" style="letter-spacing: 0.5px;">CROP
                                                        </div>
                                                        <strong
                                                            class="text-dark d-block text-truncate"><?php echo e($inv->farm?->primary_crop ?? 'Organic Alphonso'); ?></strong>
                                                    </div>
                                                </div>

                                                <!-- Financial Metrics -->
                                                <div class="mb-3" style="font-size: 11px;">
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Total Investment</span>
                                                        <strong class="text-dark fw-bold">₹<?php echo e(number_format($invAmount)); ?></strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Expected ROI</span>
                                                        <strong class="text-dark fw-bold"><?php echo e($roi); ?>%</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Returns</span>
                                                        <strong class="text-dark fw-bold">₹<?php echo e(number_format($returnVal)); ?></strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1.5">
                                                        <span class="text-muted">Harvest Date</span>
                                                        <strong
                                                            class="text-dark fw-bold"><?php echo e($inv->farm?->expected_harvest_date ? date('d M Y', strtotime($inv->farm->expected_harvest_date)) : '12 Feb 2027'); ?></strong>
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
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->farm): ?>
                                                    <a href="<?php echo e(route('investor.farms.show', $inv->farm)); ?>"
                                                        class="btn btn-outline-secondary btn-sm rounded-pill w-100 fw-bold py-2"
                                                        style="font-size: 11px; border-color: #d1d5db; color: #374151;">
                                                        View Details
                                                    </a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $availableFarms ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden position-relative">
                                            <div class="position-relative overflow-hidden" style="height: 150px;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($farm->farm_photo_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $farm->farm_photo_path)); ?>" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                <?php elseif(!empty($farm->additional_photos) && is_array($farm->additional_photos) && count($farm->additional_photos) > 0): ?>
                                                    <img src="<?php echo e(asset('storage/' . $farm->additional_photos[0])); ?>" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                <?php else: ?>
                                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600&auto=format&fit=crop"
                                                        class="w-100 h-100" style="object-fit: cover;">
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>
                                                <?php
                                                    $target = $farm->funding_target > 0 ? $farm->funding_target : 1;
                                                    $raised = $farm->funding_raised ?? 0;
                                                    $perc = min(100, round(($raised / $target) * 100));
                                                    $isClosed = ($farm->funding_status === 'closed' || $farm->status === 'completed' || $raised >= $target);
                                                ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isClosed): ?>
                                                    <span
                                                        class="position-absolute top-0 start-0 m-3 badge bg-secondary shadow-sm rounded-pill px-2.5 py-1.5 fw-bold"
                                                        style="font-size: 10px; z-index: 2; background-color: #475569 !important;">
                                                        <i class="fas fa-lock me-1"></i> 100% FUNDED
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <span
                                                    class="position-absolute top-0 end-0 m-3 badge bg-success shadow-sm rounded-pill px-3 py-1.5 fw-bold"
                                                    style="font-size: 10px; z-index: 2;">
                                                    <i class="fas fa-check-circle me-1"></i> VERIFIED
                                                </span>
                                            </div>

                                            <div class="card-body p-4">
                                                <a href="<?php echo e(route('investor.farms.show', $farm)); ?>" class="text-decoration-none">
                                                    <h6 class="fw-bold text-dark mb-1 hover-success"><?php echo e($farm->name); ?></h6>
                                                </a>
                                                <p class="text-muted mb-3" style="font-size: 11px;"><i
                                                        class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    <?php echo e($farm->location ?? 'Kerala'); ?>

                                                </p>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Est. Return</div>
                                                            <div class="fw-bold text-success" style="font-size: 12px;">
                                                                <?php echo e($farm->expected_roi ?? '18'); ?>% ROI
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="bg-light rounded-3 p-2 text-center">
                                                            <div class="text-muted fw-bold text-uppercase mb-0.5" style="font-size: 9px;">
                                                                Cycle</div>
                                                            <div class="fw-bold text-dark" style="font-size: 11px;">
                                                                <?php echo e($farm->yielding_period ?? '6'); ?> Months
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-1"
                                                    style="font-size: 11px;">
                                                    <span class="text-muted">Funding Raised</span>
                                                    <span class="fw-bold <?php echo e($isClosed ? 'text-secondary' : 'text-success'); ?>">₹<?php echo e(number_format($raised)); ?> /
                                                        ₹<?php echo e(number_format($target)); ?></span>
                                                </div>
                                                <div class="progress rounded-pill mb-3" style="height: 6px;">
                                                    <div class="progress-bar <?php echo e($isClosed ? 'bg-secondary' : 'bg-success'); ?> rounded-pill" role="progressbar"
                                                        style="width: <?php echo e($perc); ?>%;"></div>
                                                </div>

                                                <div class="pt-3 border-top">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isClosed): ?>
                                                        <button type="button"
                                                            class="btn btn-secondary btn-sm rounded-pill w-100 fw-bold py-2"
                                                            disabled
                                                            style="font-size: 12px; background-color: #64748b; border-color: #64748b; cursor: not-allowed; opacity: 0.85;">
                                                            <i class="fas fa-lock me-1.5"></i> Fully Funded (Closed)
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button"
                                                            class="btn btn-success btn-sm rounded-pill w-100 fw-bold shadow-sm py-2"
                                                            data-bs-toggle="modal" data-bs-target="#makeInvestmentModal"
                                                            data-farm-id="<?php echo e($farm->id); ?>" data-farm-name="<?php echo e($farm->name); ?>"
                                                            data-farm-roi="<?php echo e($farm->expected_roi ?? 18.5); ?>"
                                                            data-farm-target="<?php echo e($farm->funding_target ?? 800000); ?>"
                                                            data-farm-min="<?php echo e($farm->min_investment ?? 10000); ?>"
                                                            data-farm-remaining="<?php echo e(max(0, $target - $raised)); ?>"
                                                            style="font-size: 12px; background-color: #064e3b; border-color: #064e3b;">
                                                            <i class="fas fa-hand-holding-usd me-1.5"></i> Invest Now
                                                        </button>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="col-12 text-center py-5">
                                <div class="card border-0 shadow-sm rounded-4 p-5">
                                    <i class="fas fa-store text-muted fa-3x mb-3 opacity-50"></i>
                                    <h5 class="fw-bold text-dark mb-1">No Verified Farms Listed Currently</h5>
                                    <p class="text-muted mb-0" style="font-size: 12px;">Check back soon for new agricultural
                                        listings approved by Admin.</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $myInvestments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inv->farm && $inv->farm->farmer): ?>
                                            <tr class="border-bottom">
                                                <td class="ps-3 py-3 text-dark fw-bold">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center fw-bold"
                                                            style="width: 32px; height: 32px; font-size: 12px;">
                                                            <?php echo e(strtoupper(substr($inv->farm->farmer->full_name ?? 'FM', 0, 2))); ?>

                                                        </div>
                                                        <?php echo e($inv->farm->farmer->full_name ?? 'Unknown Farmer'); ?>

                                                    </div>
                                                </td>
                                                <td class="py-3 text-muted"><?php echo e($inv->farm->location ?? 'Unknown'); ?></td>
                                                <td class="py-3 text-muted"><?php echo e($inv->farm->name); ?></td>
                                                <td class="py-3 text-success fw-bold">₹ <?php echo e(number_format($inv->amount)); ?></td>
                                                <td class="py-3 text-primary fw-bold">
                                                    <?php echo e(number_format($inv->farm->expected_roi ?? 0, 1)); ?>%
                                                </td>
                                                <td class="pe-3 py-3 text-end">
                                                    <span
                                                        class="badge bg-<?php echo e($inv->status === 'approved' ? 'success' : 'warning'); ?> bg-opacity-10 text-<?php echo e($inv->status === 'approved' ? 'success' : 'warning'); ?> px-3 py-2 rounded-pill fw-bold"
                                                        style="font-size: 10px;">
                                                        <?php echo e(strtoupper($inv->status)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">You haven't invested in any farmers
                                                yet.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <input type="text" class="form-control rounded-3" value="<?php echo e(auth()->user()->name); ?>"
                                        readonly style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Email Address</label>
                                    <input type="email" class="form-control rounded-3" value="<?php echo e(auth()->user()->email); ?>"
                                        readonly style="font-size: 12px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Phone Number</label>
                                    <input type="text" class="form-control rounded-3"
                                        value="<?php echo e(auth()->user()->phone ?? '+91 98765 43210'); ?>" style="font-size: 12px;">
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Upload Sales & Proof Document Modal -->
        <div class="modal fade" id="uploadMissingModal" tabindex="-1" aria-labelledby="uploadMissingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-success bg-opacity-10 border-0 p-4">
                        <h5 class="modal-title fw-bold text-success" id="uploadMissingModalLabel"><i
                                class="fas fa-file-upload me-2"></i>Upload Sales & Proof Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" ari a-label="Close"></button>
                    </div>
                    <form action="<?php echo e(route('admin.sales.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Select Farm Plot <span
                                        class="text-danger">*</span></label>
                                <select name="farm_id" class="form-select rounded-3" required style="font-size: 12px;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ($myFarms ?? \App\Models\Farm::all()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($f->id); ?>"><?php echo e($f->name); ?> (<?php echo e($f->primary_crop); ?>)</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                                    value="<?php echo e(date('Y-m-d')); ?>" required style="font-size: 12px;">
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
                                        class="fas fa-hand-holding-usd text-success me-2"></i>1. Select Investment Capital
                                </h5>
                                <p class="text-white-50 mb-0" style="font-size: 11px;">Select plot & amount to earn
                                    projected yield returns</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4 bg-white">
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Selected Farm Plot <span
                                        class="text-danger">*</span></label>
                                <select id="dash_modal_farm_id" class="form-select form-select-lg rounded-3"
                                    style="font-size: 13px;" onchange="updateDashInvestCalc()">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ($availableFarms ?? \App\Models\Farm::where('status', 'approved')->get()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php
                                            $fTarget = $f->funding_target > 0 ? $f->funding_target : 350000;
                                            $fRaised = $f->funding_raised ?? 0;
                                            $fRemaining = max(0, $fTarget - $fRaised);
                                            $fClosed = ($f->funding_status === 'closed' || $f->status === 'completed' || $fRemaining <= 0);
                                        ?>
                                        <option value="<?php echo e($f->id); ?>" data-target="<?php echo e($fTarget); ?>"
                                            data-roi="<?php echo e($f->expected_roi ?? 18.5); ?>"
                                            data-min="<?php echo e($f->min_investment ?? 10000); ?>"
                                            data-max="<?php echo e($fRemaining > 0 ? $fRemaining : ($f->max_investment ?? $fTarget)); ?>"
                                            data-remaining="<?php echo e($fRemaining); ?>"
                                            data-closed="<?php echo e($fClosed ? '1' : '0'); ?>"
                                            data-name="<?php echo e($f->name); ?>"
                                            <?php echo e($fClosed ? 'disabled' : ''); ?>>
                                            <?php echo e($f->name); ?> (<?php echo e($f->primary_crop); ?> - <?php echo e($f->location ?? 'Kerala'); ?>) <?php echo e($fClosed ? '— [100% Fully Funded]' : ''); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Investment Amount (₹) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">₹</span>
                                    <input type="number" step="1000" min="10000"
                                        class="form-control form-control-lg rounded-end fw-bold" id="dash_step1AmountInput"
                                        value="20000" required oninput="updateDashInvestCalc()">
                                </div>
                                <small class="text-muted d-block mt-1" id="dash_investmentLimitsHelp"
                                    style="font-size: 10px;">Min: ₹10,000 | Max Limit: ₹3,00,000</small>
                            </div>

                            <!-- Dynamic Calculation Card -->
                            <div class="p-3 rounded-3 mb-4 text-white"
                                style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%);">
                                <div class="d-flex justify-content-between align-items-center mb-2"
                                    style="font-size: 11px;">
                                    <span class="text-white-50">Estimated Equity Ownership:</span>
                                    <strong class="text-white" id="dash_calcEquityShare">1.25%</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                                    <span class="text-white-50">Projected Total Return:</span>
                                    <strong class="text-white fs-5 fw-bold" id="dash_calcProjectedReturn"
                                        style="color: #34d399 !important;">₹11,850</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Select Payment Method</label>
                                <select id="dash_step1PaymentMethod" class="form-select form-select-lg rounded-3"
                                    style="font-size: 13px;">
                                    <option value="UPI" selected>Instant UPI (GooglePay / PhonePe / Paytm)</option>
                                    <option value="net_banking">Net Banking (HDFC, ICICI, SBI, Axis)</option>
                                    <option value="bank_transfer">Bank Transfer (NEFT / RTGS / IMPS)</option>
                                    <option value="card">Credit / Debit Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" onclick="goToDashboardStep2Payment()"
                                class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm"
                                style="background-color: #064e3b; border-color: #064e3b;">
                                Proceed to Payment <i class="fas fa-arrow-right ms-1.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2 PANE: Payment Summary & Confirmation -->
                    <div id="inv_wizard_step2_pane" style="display: none;">
                        <form action="" method="POST" id="dash_finalInvestForm" onsubmit="event.preventDefault(); submitRazorpayPayment();">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="farm_id" id="dash_finalFarmIdInput">
                            <input type="hidden" name="amount" id="dash_finalAmountInput">
                            <input type="hidden" name="payment_method" id="dash_finalPaymentMethodInput">

                            <div class="modal-header border-0 text-white p-4" style="background: #064e3b;">
                                <div>
                                    <h5 class="modal-title fw-bold mb-1"><i
                                            class="fas fa-shield-alt text-success me-2"></i>2. Secure Payment Gateway</h5>
                                    <p class="text-white-50 mb-0" style="font-size: 11px;">Complete your transfer to seal
                                        your equity share</p>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-4 bg-white">
                                <div
                                    class="p-3.5 bg-light rounded-4 mb-4 border d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted fw-bold text-uppercase d-block"
                                            style="font-size: 9px; letter-spacing: 0.5px;">TOTAL PAYABLE AMOUNT</small>
                                        <h3 class="fw-bold text-dark mb-0 fs-2" id="dash_paymentSummaryAmount">₹20,000</h3>
                                    </div>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-bold"
                                        style="font-size: 11px;" id="dash_paymentSummaryGateway">
                                        Razorpay Gateway
                                    </span>
                                </div>

                                <!-- Payment Gateway Visual -->
                                <div class="border rounded-4 p-4 text-center mb-4 bg-white shadow-sm"
                                    style="border-color: #e5e7eb !important;">
                                    <div class="mb-3">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-bold"
                                            style="font-size: 10px;">
                                            <i class="fas fa-shield-check me-1"></i> SECURED BY RAZORPAY
                                        </span>
                                    </div>

                                    <div class="p-3 bg-light rounded-3 d-inline-block mb-3 border text-center" style="min-width: 240px;">
                                        <div class="fw-bold text-dark fs-5 mb-1"><i class="fas fa-bolt text-warning me-1"></i> Razorpay Standard</div>
                                        <div class="text-muted fw-bold" style="font-size: 10.5px;">UPI • GPay • PhonePe • Cards • NetBanking</div>
                                    </div>

                                    <p class="text-muted mb-0" style="font-size: 11px;">
                                        Click below to open the <strong>Razorpay Checkout</strong> popup and complete your test payment.
                                    </p>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-0 p-4 pt-0 justify-content-between">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"
                                    onclick="backToDashboardStep1()" style="font-size: 12px;">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </button>
                                <button type="button" id="dash_payRazorpayBtn" onclick="submitRazorpayPayment()" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm"
                                    style="background-color: #064e3b; border-color: #064e3b; font-size: 13px;">
                                    <i class="fas fa-bolt me-1.5"></i> Pay via Razorpay
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Razorpay Standard Checkout SDK -->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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
                const remaining = opt.getAttribute('data-remaining') !== null ? parseFloat(opt.getAttribute('data-remaining')) : null;
                const isClosed = opt.getAttribute('data-closed') === '1' || (remaining !== null && remaining <= 0);
                const amount = parseFloat(amtInput.value) || 0;

                amtInput.min = minVal;
                if (maxVal > 0) {
                    amtInput.max = maxVal;
                }

                if (limitsLabel) {
                    if (isClosed) {
                        limitsLabel.innerHTML = '<span class="text-danger fw-bold"><i class="fas fa-lock me-1"></i>This farm cycle is 100% funded and closed to new investments.</span>';
                    } else {
                        limitsLabel.innerText = `Min: ₹${minVal.toLocaleString('en-IN')} | Remaining Allocation: ₹${maxVal.toLocaleString('en-IN')}`;
                    }
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
                    alert('Please select an active farm plot.');
                    return;
                }

                const opt = select.options[select.selectedIndex];
                const isClosed = opt && (opt.disabled || opt.getAttribute('data-closed') === '1');
                if (isClosed) {
                    alert('This farm cycle has reached 100% funding and is currently closed to new investment pledges. Please select another open farm.');
                    return;
                }

                const farmId = select.value;
                const amount = parseFloat(amtInput.value) || 0;
                const minVal = parseFloat(opt?.getAttribute('data-min')) || 100;
                const maxVal = parseFloat(opt?.getAttribute('data-max')) || Infinity;

                if (amount < minVal) {
                    alert('Minimum investment amount is ₹' + minVal.toLocaleString('en-IN'));
                    return;
                }

                if (amount > maxVal && maxVal > 0) {
                    alert('Investment amount cannot exceed the remaining capacity of ₹' + maxVal.toLocaleString('en-IN'));
                    return;
                }

                const form = document.getElementById('dash_finalInvestForm');
                if (form) {
                    form.action = '/investor/farms/' + farmId + '/invest';
                }

                const finalAmt = document.getElementById('dash_finalAmountInput');
                if (finalAmt) finalAmt.value = amount;

                const finalFarm = document.getElementById('dash_finalFarmIdInput');
                if (finalFarm) finalFarm.value = farmId;

                const finalPay = document.getElementById('dash_finalPaymentMethodInput');
                if (finalPay) finalPay.value = payMethod.value;

                const sumAmt = document.getElementById('dash_paymentSummaryAmount');
                if (sumAmt) sumAmt.innerText = '₹' + amount.toLocaleString('en-IN');

                const sumGate = document.getElementById('dash_paymentSummaryGateway');
                if (sumGate && payMethod && payMethod.selectedIndex >= 0) {
                    sumGate.innerText = 'Razorpay Gateway';
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

            function submitRazorpayPayment() {
                const farmId = document.getElementById('dash_finalFarmIdInput')?.value || document.getElementById('dash_modal_farm_id')?.value;
                const amount = parseFloat(document.getElementById('dash_finalAmountInput')?.value) || 0;
                const payBtn = document.getElementById('dash_payRazorpayBtn');

                if (!farmId || amount <= 0) {
                    alert('Please select a valid farm and investment amount.');
                    return;
                }

                if (payBtn) {
                    payBtn.disabled = true;
                    payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1.5"></i> Opening Razorpay...';
                }

                fetch("<?php echo e(route('payment.create_order')); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                    },
                    body: JSON.stringify({
                        farm_id: farmId,
                        amount: amount
                    })
                })
                .then(res => res.json())
                .then(orderData => {
                    if (!orderData.success) {
                        alert('Could not initialize Razorpay order: ' + (orderData.message || 'Please check keys and amount.'));
                        if (payBtn) {
                            payBtn.disabled = false;
                            payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                        }
                        return;
                    }

                    const options = {
                        key: orderData.key,
                        amount: orderData.amount,
                        currency: orderData.currency,
                        name: "SoulSoil Agriculture",
                        description: "Farm Investment Pledge",
                        image: "<?php echo e(asset('images/logo.png')); ?>",
                        order_id: orderData.order_id,
                        handler: function (response) {
                            if (payBtn) {
                                payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1.5"></i> Verifying Payment...';
                            }

                            fetch("<?php echo e(route('payment.verify')); ?>", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                                },
                                body: JSON.stringify({
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_signature: response.razorpay_signature,
                                    farm_id: farmId,
                                    amount: amount
                                })
                            })
                            .then(r => r.json())
                            .then(result => {
                                if (result.success) {
                                    window.location.href = result.redirect_url;
                                } else {
                                    alert(result.message || 'Payment signature verification failed.');
                                    if (payBtn) {
                                        payBtn.disabled = false;
                                        payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                                    }
                                }
                            })
                            .catch(err => {
                                alert('Network error verifying payment.');
                                if (payBtn) {
                                    payBtn.disabled = false;
                                    payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                                }
                            });
                        },
                        modal: {
                            ondismiss: function () {
                                if (payBtn) {
                                    payBtn.disabled = false;
                                    payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                                }
                            }
                        },
                        prefill: {
                            name: "<?php echo e(auth()->user()?->name); ?>",
                            email: "<?php echo e(auth()->user()?->email); ?>",
                            contact: "<?php echo e(auth()->user()?->phone); ?>"
                        },
                        theme: {
                            color: "#064e3b"
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.on('payment.failed', function (resp) {
                        alert('Payment failed: ' + (resp.error?.description || 'Transaction cancelled.'));
                        if (payBtn) {
                            payBtn.disabled = false;
                            payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                        }
                    });
                    rzp.open();
                })
                .catch(err => {
                    alert('Error connecting to payment gateway: ' + err.message);
                    if (payBtn) {
                        payBtn.disabled = false;
                        payBtn.innerHTML = '<i class="fas fa-bolt me-1.5"></i> Pay via Razorpay';
                    }
                });
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
                                    // If selected option is disabled/closed, switch to first open option
                                    if (select.selectedIndex === -1 || select.options[select.selectedIndex]?.disabled) {
                                        for (let i = 0; i < select.options.length; i++) {
                                            if (!select.options[i].disabled) {
                                                select.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    }
                                    updateDashInvestCalc();
                                }
                            }
                        }
                    });
                }
                // Initialize default selection to an open non-disabled farm if current is disabled
                const initialSelect = document.getElementById('dash_modal_farm_id');
                if (initialSelect && initialSelect.options[initialSelect.selectedIndex]?.disabled) {
                    for (let i = 0; i < initialSelect.options.length; i++) {
                        if (!initialSelect.options[i].disabled) {
                            initialSelect.selectedIndex = i;
                            break;
                        }
                    }
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
                const minInvInput = document.getElementById('wiz_min_inv');
                const maxInvInput = document.getElementById('wiz_max_inv');
                const ctxAskEl = document.getElementById('ctx_ask');

                function syncFundingTargetToMaxInv() {
                    if (!fundingTargetInput) return;
                    const askVal = parseFloat(fundingTargetInput.value) || 0;

                    if (ctxAskEl) {
                        ctxAskEl.innerText = '₹' + askVal.toLocaleString('en-IN');
                    }

                    if (maxInvInput && askVal > 0 && (!maxInvInput.dataset.userEdited || parseFloat(maxInvInput.value) > askVal)) {
                        maxInvInput.value = askVal;
                    }

                    if (minInvInput && askVal > 0 && parseFloat(minInvInput.value) > askVal) {
                        minInvInput.value = askVal;
                    }
                }

                if (fundingTargetInput) {
                    fundingTargetInput.addEventListener('input', syncFundingTargetToMaxInv);
                    fundingTargetInput.addEventListener('change', syncFundingTargetToMaxInv);
                    syncFundingTargetToMaxInv();
                }

                if (minInvInput) {
                    minInvInput.addEventListener('input', function () {
                        this.classList.remove('is-invalid');
                    });
                }

                if (maxInvInput) {
                    maxInvInput.addEventListener('input', function () {
                        this.dataset.userEdited = "true";
                        this.classList.remove('is-invalid');
                    });
                }

                // Validate all wizard steps and sync hidden JSON before final form submit
                const addFarmForm = document.getElementById('addFarmWizardForm');
                if (addFarmForm) {
                    addFarmForm.addEventListener('submit', function (e) {
                        if (typeof syncTimelineJson === 'function') syncTimelineJson();
                        if (typeof calculateBudgetTotal === 'function') calculateBudgetTotal(false);

                        for (let s = 1; s <= 5; s++) {
                            if (typeof validateWizardStep === 'function' && !validateWizardStep(s)) {
                                e.preventDefault();
                                if (typeof goToWizardStep === 'function') goToWizardStep(s);
                                return false;
                            }
                        }
                    });
                }
            });
        </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
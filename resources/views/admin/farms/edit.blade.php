@extends('layouts.admin')

@section('page-title', 'Edit Farm Plot')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-edit me-2 text-success"></i>Edit Farm Plot - {{ $farm->name }}</h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">Modify basic details, financial parameters, yield timeline, soil metrics, and media documents.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}#my-farms" class="btn btn-light rounded-pill px-3 py-1.5 fw-semibold text-muted" style="font-size: 11px;">
                    <i class="fas fa-arrow-left me-1"></i> Back to My Farms
                </a>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('admin.farms.update', $farm) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Section 1: Basic Farm Details -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-success mb-3" style="font-size: 13px;"><i class="fas fa-info-circle me-1.5"></i> 1. Basic Farm Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Farm Plot Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $farm->name) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Location / District <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $farm->location) }}" placeholder="e.g. Punjab, India" style="font-size: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Total Area (Acres) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="total_acres" class="form-control rounded-3" value="{{ old('total_acres', $farm->total_acres ?? $farm->area_acres) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Primary Crop <span class="text-danger">*</span></label>
                                <input type="text" name="primary_crop" class="form-control rounded-3" value="{{ old('primary_crop', $farm->primary_crop) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Secondary Crop</label>
                                <input type="text" name="secondary_crop" class="form-control rounded-3" value="{{ old('secondary_crop', $farm->secondary_crop) }}" style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Listing Category <span class="text-danger">*</span></label>
                                <select name="listing_category" class="form-select rounded-3" style="font-size: 12px;">
                                    <option value="standard" {{ old('listing_category', $farm->listing_category) === 'standard' ? 'selected' : '' }}>Standard Cultivation</option>
                                    <option value="organic" {{ old('listing_category', $farm->listing_category) === 'organic' ? 'selected' : '' }}>Organic Certified</option>
                                    <option value="hydroponic" {{ old('listing_category', $farm->listing_category) === 'hydroponic' ? 'selected' : '' }}>Hydroponic & Precision</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Financial & Investment Parameters -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-success mb-3" style="font-size: 13px;"><i class="fas fa-hand-holding-usd me-1.5"></i> 2. Financial & Investment Parameters</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Funding Target / Ask (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="funding_target" class="form-control rounded-3" value="{{ old('funding_target', $farm->funding_target) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Your Contribution / Farmer's Stake (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="your_contribution" class="form-control rounded-3 fw-bold text-success" value="{{ old('your_contribution', $farm->your_contribution ?? 50000) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Expected Annualized ROI (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" name="expected_roi" class="form-control rounded-3" value="{{ old('expected_roi', $farm->expected_roi) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Min Investment per Investor (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="min_investment" class="form-control rounded-3" value="{{ old('min_investment', $farm->min_investment) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Max Investment per Investor (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="max_investment" class="form-control rounded-3" value="{{ old('max_investment', $farm->max_investment) }}" required style="font-size: 12px;">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Yield Cycle & Operational Parameters -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-success mb-3" style="font-size: 13px;"><i class="fas fa-calendar-alt me-1.5"></i> 3. Yield Cycle & Schedule</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Yielding Cycle (Months) <span class="text-danger">*</span></label>
                                <input type="number" name="yielding_period" class="form-control rounded-3" value="{{ old('yielding_period', $farm->yielding_period) }}" required style="font-size: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Expected Cycle Start Date</label>
                                <input type="date" name="expected_start_date" class="form-control rounded-3" value="{{ old('expected_start_date', $farm->expected_start_date) }}" style="font-size: 12px;">
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Media Uploads -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-success mb-3" style="font-size: 13px;"><i class="fas fa-camera me-1.5"></i> 4. Media & Land Verification Documents</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Update Hero / Cover Photo (JPG, PNG)</label>
                                <input type="file" name="farm_photo" class="form-control rounded-3" accept=".jpg,.jpeg,.png" style="font-size: 12px;">
                                @if($farm->farm_photo_path)
                                    <div class="mt-2 text-muted" style="font-size: 11px;"><i class="fas fa-image me-1"></i> Current photo uploaded</div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Upload Additional Land Deed / Verification PDFs</label>
                                <input type="file" name="farm_documents[]" class="form-control rounded-3" accept=".pdf" multiple style="font-size: 12px;">
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Admin Review Controls -->
                    @if(auth()->user()?->is_admin)
                        <div class="bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3 p-3 mb-4">
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;"><i class="fas fa-user-shield me-1.5 text-warning"></i> Admin Approval & Funding Controls</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Verification Status</label>
                                    <select name="status" class="form-select rounded-3" style="font-size: 12px;">
                                        <option value="pending" {{ $farm->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="approved" {{ $farm->status === 'approved' ? 'selected' : '' }}>Approved & Listed</option>
                                        <option value="rejected" {{ $farm->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Funding Window Status</label>
                                    <select name="funding_status" class="form-select rounded-3" style="font-size: 12px;">
                                        <option value="open" {{ ($farm->funding_status ?? 'open') === 'open' ? 'selected' : '' }}>Open for Investment</option>
                                        <option value="closed" {{ ($farm->funding_status ?? 'open') === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('admin.dashboard') }}#my-farms" class="btn btn-light rounded-pill px-4 py-2 fw-semibold" style="font-size: 12px;">Cancel</a>
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm" style="font-size: 12px;">
                            <i class="fas fa-save me-1.5"></i> Save Farm Plot Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

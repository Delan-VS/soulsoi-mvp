@extends('layouts.admin')

@section('page-title', 'Farm Verification & Listing Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Farm Listing Verification & Funding Directory</h4>
        <p class="text-muted mb-0" style="font-size: 11px;">Manually review land plot applications, approve listings, or stop funding collection on active farms.</p>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold border-0">Plot Code</th>
                        <th class="px-4 py-3 fw-semibold border-0">Farm & Owner</th>
                        <th class="px-3 py-3 fw-semibold border-0">Crop & Area</th>
                        <th class="px-3 py-3 fw-semibold border-0">Funding Progress</th>
                        <th class="px-3 py-3 fw-semibold border-0">Status</th>
                        <th class="px-4 py-3 fw-semibold border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($farms as $farm)
                        <tr>
                            <!-- Plot Code -->
                            <td class="px-4 py-3">
                                <span class="fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">
                                    #FARM-{{ str_pad($farm->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <!-- Farm & Owner -->
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 overflow-hidden shadow-sm" style="width: 44px; height: 44px; min-width: 44px;">
                                        @if($farm->farm_photo_path)
                                            <img src="{{ asset('storage/' . $farm->farm_photo_path) }}" class="w-100 h-100" style="object-fit: cover;">
                                        @elseif(!empty($farm->additional_photos) && is_array($farm->additional_photos) && count($farm->additional_photos) > 0)
                                            <img src="{{ asset('storage/' . $farm->additional_photos[0]) }}" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <div class="bg-success bg-opacity-10 text-success w-100 h-100 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-tractor fs-6"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $farm->name }}</div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            <i class="fas fa-user-circle me-1"></i>Owner: {{ $farm->farmer?->full_name ?? 'N/A' }}
                                            <span class="ms-2"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $farm->location ?? 'Kerala' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Crop & Area -->
                            <td class="px-3 py-3">
                                <div class="fw-bold text-dark">{{ $farm->primary_crop }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $farm->total_acres }} Acres &bull; {{ $farm->listing_category ?? 'General' }}</div>
                            </td>

                            <!-- Funding Progress -->
                            <td class="px-3 py-3" style="min-width: 180px;">
                                <?php $target = $farm->funding_target > 0 ? $farm->funding_target : 1; $raised = $farm->funding_raised ?? 0; $perc = min(100, round(($raised / $target) * 100)); ?>
                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 11px;">
                                    <span class="fw-bold text-dark">₹{{ number_format($raised) }}</span>
                                    <span class="text-muted" style="font-size: 10px;">/ ₹{{ number_format($target) }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $perc >= 100 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $perc }}%;"></div>
                                </div>
                                <div class="text-end text-muted mt-1" style="font-size: 9px;">{{ $perc }}% Funded</div>
                            </td>

                            <!-- Status -->
                            <td class="px-3 py-3">
                                <div class="d-flex flex-column gap-1">
                                    <!-- Approval Status -->
                                    <div>
                                        @if(in_array($farm->status, ['approved', 'active']))
                                            <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                <i class="fas fa-check-circle me-1"></i> Approved
                                            </span>
                                        @elseif($farm->status === 'completed')
                                            <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill fw-bold">
                                                <i class="fas fa-check-double me-1"></i> Completed & Settled
                                            </span>
                                        @elseif($farm->status === 'rejected')
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 rounded-pill fw-bold">
                                                <i class="fas fa-times-circle me-1"></i> Rejected
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill fw-bold">
                                                <i class="fas fa-clock me-1"></i> Pending Review
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Funding Status -->
                                    <div>
                                        @if($farm->funding_status === 'closed')
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-0.5 rounded-pill" style="font-size: 9px;">
                                                <i class="fas fa-lock me-1"></i> Funding Closed
                                            </span>
                                        @else
                                            <span class="badge bg-info bg-opacity-10 text-info px-2 py-0.5 rounded-pill" style="font-size: 9px;">
                                                <i class="fas fa-signal me-1"></i> Collecting Funds
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                    
                                    <!-- Manual Approve/Reject for Pending Listings -->
                                    @if($farm->status === 'pending' || $farm->status === 'submitted')
                                        <form action="{{ route('admin.farms.approve', $farm) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.farms.reject', $farm) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Stop Collecting Button for Active / In-Progress Collecting Farms -->
                                    @if($farm->status === 'approved' && ($farm->funding_status ?? 'open') !== 'closed')
                                        <form action="{{ route('admin.farms.stop_collecting', $farm) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark rounded-pill px-3 py-1 fw-bold shadow-sm" style="font-size: 11px;">
                                                <i class="fas fa-hand-paper me-1"></i> Stop Collecting
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Review Details -->
                                    <a href="{{ route('admin.farms.show', $farm) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                        Review Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-tractor fa-3x mb-3 text-light"></i>
                                <p class="mb-0">No farm plots found in the listing queue.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($farms->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $farms->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

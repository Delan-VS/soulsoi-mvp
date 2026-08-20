@extends('layouts.admin')

@section('page-title', 'Farmer Verification Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Farmer Verification Directory</h4>
        <p class="text-muted mb-0" style="font-size: 11px;">Review, verify, approve or reject registered farmer applications.</p>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold border-0">Farmer ID</th>
                        <th class="px-4 py-3 fw-semibold border-0">Farmer Details</th>
                        <th class="px-3 py-3 fw-semibold border-0">Location</th>
                        <th class="px-3 py-3 fw-semibold border-0">Verification Badges</th>
                        <th class="px-3 py-3 fw-semibold border-0">Overall Status</th>
                        <th class="px-4 py-3 fw-semibold border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($farmers as $farmer)
                        <tr>
                            <!-- Farmer ID -->
                            <td class="px-4 py-3">
                                <span class="fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">
                                    #FRM-{{ str_pad($farmer->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <!-- Farmer Details -->
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 12px;">
                                        {{ strtoupper(substr($farmer->full_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $farmer->full_name }}</div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            <i class="far fa-envelope me-1"></i>{{ $farmer->user?->email ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Location -->
                            <td class="px-3 py-3">
                                <div class="fw-medium text-dark"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $farmer->district ?? 'N/A' }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $farmer->state ?? 'Kerala' }}</div>
                            </td>

                            <!-- Verification Badges -->
                            <td class="px-3 py-3">
                                <div class="d-flex gap-1 flex-wrap" style="font-size: 10px;">
                                    <span class="badge {{ $farmer->mobile_verification === 'completed' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-light text-muted border' }} px-2 py-1">
                                        Mobile
                                    </span>
                                    <span class="badge {{ $farmer->bank_verification === 'completed' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-light text-muted border' }} px-2 py-1">
                                        Bank
                                    </span>
                                    <span class="badge {{ $farmer->document_verification === 'completed' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-light text-muted border' }} px-2 py-1">
                                        KYC Docs
                                    </span>
                                </div>
                            </td>

                            <!-- Overall Status -->
                            <td class="px-3 py-3">
                                @if($farmer->overall_status === 'approved')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="fas fa-check-circle me-1"></i> Approved
                                    </span>
                                @elseif($farmer->overall_status === 'rejected')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>

                            <!-- Manual Approval / Actions -->
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2 align-items-center">
                                    @if($farmer->overall_status === 'pending')
                                        <form action="{{ route('admin.farmers.approve', $farmer) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.farmers.reject', $farmer) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.farmers.show', $farmer) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 11px;">
                                        Review Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 text-light"></i>
                                <p class="mb-0">No farmers found in the verification queue.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($farmers->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $farmers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
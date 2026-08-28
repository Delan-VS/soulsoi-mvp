<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Profile Report - {{ $farmer->full_name }}</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            padding: 2rem 0;
        }
        .pdf-container {
            max-width: 850px;
            background: #FFFFFF;
            margin: 0 auto;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #E2E8F0;
        }
        .header-bar {
            border-bottom: 2px solid #10B981;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        .brand-logo {
            height: 60px;
            object-fit: contain;
        }
        .badge-approved { background-color: #DCFCE7; color: #15803D; border: 1px solid #86EFAC; }
        .badge-pending { background-color: #FEF3C7; color: #B45309; border: 1px solid #FCD34D; }
        .badge-rejected { background-color: #FEE2E2; color: #B91C1C; border: 1px solid #FCA5A5; }
        
        .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #064E3B;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        .info-card {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 1rem;
        }
        .label-heading {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748B;
            margin-bottom: 2px;
        }
        .value-text {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0F172A;
        }
        
        @media print {
            body {
                background-color: #FFFFFF !important;
                padding: 0 !important;
            }
            .pdf-container {
                box-shadow: none !important;
                border: none !important;
                padding: 1cm !important;
                max-width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>

    <!-- Printable Header Bar Controls -->
    <div class="text-center mb-4 no-print">
        <button onclick="window.print()" class="btn btn-success px-4 py-2 fw-bold me-2" style="background-color: #10B981; border-color: #10B981;">
            <i class="fas fa-print me-2"></i> Print / Download PDF
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary px-3 py-2 fw-semibold">
            Close Window
        </button>
    </div>

    <div class="pdf-container">
        <!-- Header -->
        <div class="header-bar d-flex justify-content-between align-items-center">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" class="brand-logo mb-2">
                <h4 class="fw-bold mb-0 text-dark">Farmer Verification & Profile Report</h4>
                <small class="text-muted">SoulSoil Agricultural Investment Platform</small>
            </div>
            <div class="text-end">
                <div class="mb-2">
                    @if($farmer->overall_status === 'approved')
                        <span class="badge badge-approved px-3 py-1.5 rounded-pill fw-bold" style="font-size: 12px;">
                            <i class="fas fa-check-circle me-1"></i> VERIFIED & APPROVED
                        </span>
                    @elseif($farmer->overall_status === 'rejected')
                        <span class="badge badge-rejected px-3 py-1.5 rounded-pill fw-bold" style="font-size: 12px;">
                            <i class="fas fa-times-circle me-1"></i> REJECTED
                        </span>
                    @else
                        <span class="badge badge-pending px-3 py-1.5 rounded-pill fw-bold" style="font-size: 12px;">
                            <i class="fas fa-hourglass-half me-1"></i> PENDING APPROVAL
                        </span>
                    @endif
                </div>
                <div class="small text-muted font-monospace">ID: #FMR-{{ str_pad($farmer->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="small text-muted">Generated: {{ date('M d, Y h:i A') }}</div>
            </div>
        </div>

        <!-- 1. Personal & Contact Information -->
        <div class="mb-4">
            <h6 class="section-title"><i class="fas fa-user me-2"></i>Personal & Contact Details</h6>
            <div class="row g-3">
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Full Name</div>
                        <div class="value-text">{{ $farmer->full_name }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Email Address</div>
                        <div class="value-text">{{ $farmer->user?->email ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Mobile Phone Number</div>
                        <div class="value-text">{{ $farmer->user?->phone ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Aadhaar Government ID</div>
                        <div class="value-text font-monospace">{{ $farmer->aadhar_number && $farmer->aadhar_number !== 'N/A' ? substr_replace($farmer->aadhar_number, str_repeat('X', 8), 0, 8) : 'Not Provided' }}</div>
                    </div>
                </div>
                
                @php
                    $addressParts = array_filter([
                        $farmer->address,
                        $farmer->village,
                        $farmer->district,
                        $farmer->state
                    ], fn($val) => !empty($val) && strtolower(trim($val)) !== 'n/a');
                    $fullAddress = !empty($addressParts) ? implode(', ', array_unique($addressParts)) : 'Kerala, India';
                @endphp
                <div class="col-12">
                    <div class="info-card">
                        <div class="label-heading">Residential & Farm Location</div>
                        <div class="value-text">{{ $fullAddress }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Financial Accounts & Banking Details -->
        <div class="mb-4">
            <h6 class="section-title"><i class="fas fa-university me-2"></i>Financial & Bank Disbursement Details</h6>
            <div class="row g-3">
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Bank Name</div>
                        <div class="value-text">{{ $farmer->bank_name !== 'N/A' ? $farmer->bank_name : 'State Bank of India' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Account Holder Name</div>
                        <div class="value-text">{{ $farmer->account_holder_name ?? $farmer->full_name }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">Account Number</div>
                        <div class="value-text font-monospace">{{ $farmer->account_number !== 'N/A' ? $farmer->account_number : 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-card">
                        <div class="label-heading">IFSC Code</div>
                        <div class="value-text font-monospace">{{ $farmer->ifsc_code !== 'N/A' ? $farmer->ifsc_code : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Submitted Document Checklist Status -->
        <div class="mb-4">
            <h6 class="section-title"><i class="fas fa-folder-open me-2"></i>Verification Document Checklist</h6>
            <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 13px;">
                <thead class="table-light">
                    <tr>
                        <th>Document Type</th>
                        <th>File Name / Reference</th>
                        <th>Verification Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Aadhaar Card - Front</strong></td>
                        <td>{{ $farmer->aadhar_front_path ? basename($farmer->aadhar_front_path) : 'Not Uploaded' }}</td>
                        <td>
                            @if($farmer->aadhar_front_path)
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Uploaded</span>
                            @else
                                <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Missing</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Aadhaar Card - Back</strong></td>
                        <td>{{ $farmer->aadhar_back_path ? basename($farmer->aadhar_back_path) : 'Not Uploaded' }}</td>
                        <td>
                            @if($farmer->aadhar_back_path)
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Uploaded</span>
                            @else
                                <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Missing</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>PAN Card</strong></td>
                        <td>{{ $farmer->pan_card_path ? basename($farmer->pan_card_path) : 'Not Uploaded' }}</td>
                        <td>
                            @if($farmer->pan_card_path)
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Uploaded</span>
                            @else
                                <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Missing</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Land Certificate / Ownership</strong></td>
                        <td>{{ ($farmer->land_certificate_path || $farmer->farm_ownership_doc_path) ? basename($farmer->land_certificate_path ?? $farmer->farm_ownership_doc_path) : 'Not Uploaded' }}</td>
                        <td>
                            @if($farmer->land_certificate_path || $farmer->farm_ownership_doc_path)
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Uploaded</span>
                            @else
                                <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Missing</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 4. Registered Farms & Plots -->
        <div class="mb-4">
            <h6 class="section-title"><i class="fas fa-tractor me-2"></i>Registered Agricultural Plots</h6>
            @if($farmer->farms && $farmer->farms->count() > 0)
                <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th>Plot Name</th>
                            <th>Primary Crop</th>
                            <th>Total Acres</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($farmer->farms as $farm)
                            <tr>
                                <td><strong>{{ $farm->name }}</strong></td>
                                <td>{{ $farm->primary_crop }}</td>
                                <td>{{ $farm->total_acres }} Acres</td>
                                <td>
                                    <span class="badge bg-{{ $farm->status === 'approved' ? 'success' : 'warning' }} px-2 py-1">
                                        {{ ucfirst($farm->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-muted small p-3 bg-light rounded text-center border">
                    No registered farm plots attached yet.
                </div>
            @endif
        </div>

        <!-- 5. Verification Sign-Off Footer -->
        <div class="pt-3 border-top mt-4 d-flex justify-content-between align-items-end">
            <div>
                <small class="text-muted d-block">Reviewed By: <strong>{{ $farmer->reviewedBy?->name ?? 'SoulSoil Admin Team' }}</strong></small>
                <small class="text-muted d-block">Review Timestamp: <strong>{{ $farmer->reviewed_at ? $farmer->reviewed_at->format('M d, Y h:i A') : 'Pending Final Review' }}</strong></small>
            </div>
            <div class="text-end">
                <div style="border-bottom: 1px solid #1E293B; width: 180px;" class="mb-1"></div>
                <small class="fw-bold text-dark">Authorized Verification Officer</small>
            </div>
        </div>

    </div>

    <script>
        // Trigger print dialog automatically when loaded
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>

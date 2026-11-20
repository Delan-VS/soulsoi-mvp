<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Onboarding - SoulSoil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #F1EFE8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 2rem 0;
        }
        .form-card {
            border: 1px solid #e0ddd4;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            background: white;
            padding: 2.5rem;
        }
        .btn-primary {
            background-color: #5cc42c;
            border-color: #5cc42c;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #479920;
            border-color: #479920;
        }
        .form-control, .form-select {
            border: 1px solid #e0ddd4;
            padding: 0.75rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5cc42c;
            box-shadow: 0 0 0 0.2rem rgba(92, 196, 44, 0.25);
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }

        /* Document Upload Dropzone Styling (Figma Design) */
        .upload-card-box {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 1.25rem 1rem;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            position: relative;
        }
        .upload-card-box:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .upload-icon {
            font-size: 1.75rem;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }
        .upload-label-title {
            font-weight: 700;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }
        .upload-hint-text {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 0.75rem;
        }
        .btn-upload-file {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 1rem;
            border-radius: 8px;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            display: inline-block;
        }
        .selected-filename {
            font-size: 0.75rem;
            color: #059669;
            font-weight: 600;
            margin-top: 0.5rem;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-white border-bottom mb-4">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" height="40" class="me-2">
                <span class="fw-bold" style="color: #5cc42c;">Farmer Portal</span>
            </a>
            <div>
                <span class="me-3 fw-bold">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Log out</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container max-w-3xl">
        <div class="form-card mx-auto" style="max-width: 800px;">
            <h2 class="mb-1 fw-bold" style="color: #2d3748;">Complete Your Profile</h2>
            <p class="text-muted mb-4">Please provide your details and verification documents so we can verify your account.</p>

            @if(session('success'))
            <div class="alert alert-success fw-bold">
                {{ session('success') }}
            </div>
            @endif
            
            @if($errors->any())
            <div class="alert alert-danger p-3 mb-4 small">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @php
                $statusClass = 'status-pending';
                $statusText = 'Verification Pending';
                if($farmer->overall_status === 'approved') {
                    $statusClass = 'status-approved';
                    $statusText = 'Verified & Approved';
                } elseif($farmer->overall_status === 'rejected') {
                    $statusClass = 'status-rejected';
                    $statusText = 'Verification Rejected';
                }
            @endphp

            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="text-secondary small fw-bold">CURRENT STATUS:</span>
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>

                @if($farmer->overall_status === 'rejected')
                    <div class="card border-0 shadow-sm rounded-3 mt-3 overflow-hidden" style="border-left: 5px solid #dc2626 !important; background: #fef2f2;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="text-danger mt-1">
                                    <i class="fas fa-exclamation-circle fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-danger mb-1">Application Verification Rejected</h6>
                                    <p class="text-secondary small mb-2">
                                        Your registration documents could not be verified by the administrator. Please review the reason below, make corrections or re-upload clearer documents, and click <strong>Submit for Verification</strong>.
                                    </p>
                                    <div class="p-3 bg-white rounded-3 border border-danger border-opacity-25 shadow-xs">
                                        <div class="fw-bold text-danger small mb-1">
                                            <i class="fas fa-comment-dots me-1"></i> Reason for Rejection:
                                        </div>
                                        <div class="text-dark fw-semibold" style="font-size: 13.5px;">
                                            {{ $farmer->admin_notes ?: 'Documents or bank details did not meet the verification requirements. Please review and update your information.' }}
                                        </div>
                                    </div>
                                    @if($farmer->reviewed_at)
                                        <div class="text-muted small mt-2" style="font-size: 11px;">
                                            <i class="fas fa-clock me-1"></i> Reviewed on {{ $farmer->reviewed_at->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($farmer->overall_status === 'pending' && $farmer->admin_notes)
                    <div class="card border-0 shadow-sm rounded-3 mt-3 overflow-hidden" style="border-left: 5px solid #f59e0b !important; background: #fffbeb;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="text-warning mt-1">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">Application Under Re-Review</h6>
                                    <p class="text-secondary small mb-2">
                                        You have submitted updated details. Our admin team is reviewing your changes against the previous review remarks.
                                    </p>
                                    <div class="p-2.5 bg-white rounded-3 border border-warning border-opacity-30">
                                        <div class="fw-bold text-dark small mb-1" style="font-size: 11.5px;">
                                            <i class="fas fa-history text-warning me-1"></i> Previous Rejection Reason:
                                        </div>
                                        <div class="text-muted small">
                                            {{ $farmer->admin_notes }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <form action="{{ route('farmer.onboarding.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h5 class="fw-bold mt-4 mb-3" style="color: #5cc42c;">Personal Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">DATE OF BIRTH</label>
                        <input type="date" class="form-control" name="dob" value="{{ old('dob', $farmer->dob?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">AADHAR NUMBER (12 Digits)</label>
                        <input type="text" class="form-control" name="aadhar_number" value="{{ old('aadhar_number', $farmer->aadhar_number !== 'N/A' ? $farmer->aadhar_number : '') }}" placeholder="123456789012" maxlength="12" pattern="[0-9]{12}" title="12-digit Aadhaar number" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">FULL ADDRESS</label>
                    <textarea class="form-control" name="address" rows="3" required>{{ old('address', $farmer->address !== 'N/A' ? $farmer->address : '') }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-secondary small fw-bold">VILLAGE</label>
                        <input type="text" class="form-control" name="village" value="{{ old('village', $farmer->village !== 'N/A' ? $farmer->village : '') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-secondary small fw-bold">DISTRICT</label>
                        <input type="text" class="form-control" name="district" value="{{ old('district', $farmer->district) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-secondary small fw-bold">STATE</label>
                        <input type="text" class="form-control" name="state" value="{{ old('state', $farmer->state) }}" required>
                    </div>
                </div>

                <h5 class="fw-bold mt-4 mb-3" style="color: #5cc42c;">Bank Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">BANK NAME</label>
                        <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name', $farmer->bank_name !== 'N/A' ? $farmer->bank_name : '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">ACCOUNT HOLDER NAME</label>
                        <input type="text" class="form-control" name="account_holder_name" value="{{ old('account_holder_name', $farmer->account_holder_name) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">ACCOUNT NUMBER</label>
                        <input type="text" class="form-control" name="account_number" value="{{ old('account_number', $farmer->account_number !== 'N/A' ? $farmer->account_number : '') }}" placeholder="30012345678" maxlength="18" pattern="[0-9]{9,18}" title="9 to 18-digit account number" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label text-secondary small fw-bold">IFSC CODE</label>
                        <input type="text" class="form-control" name="ifsc_code" value="{{ old('ifsc_code', $farmer->ifsc_code !== 'N/A' ? $farmer->ifsc_code : '') }}" placeholder="SBIN0001234" maxlength="11" pattern="[A-Za-z]{4}0[A-Za-z0-9]{6}" title="11-character IFSC code" required>
                    </div>
                </div>
                
                <!-- Document Uploads Section (Figma Layout) -->
                <div class="bg-white p-4 rounded-3 border mb-4 shadow-sm">
                    <h5 class="text-center fw-bold text-dark mb-4" style="color: #5cc42c;">Document Uploads</h5>

                    <!-- 1. Upload Aadhaar Card -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2">Upload Aadhaar Card</label>
                        <div class="row g-3">
                            <!-- Front Side -->
                            <div class="col-md-6">
                                <div class="upload-card-box" onclick="document.getElementById('aadhar_front').click();">
                                    <div class="upload-icon"><i class="fas fa-upload"></i></div>
                                    <div class="upload-label-title">Front Side</div>
                                    <div class="upload-hint-text">Clear photo of your Aadhaar card front</div>
                                    <span class="btn-upload-file">{{ $farmer->aadhar_front_path ? 'Change File' : 'Upload file' }}</span>
                                    <input type="file" id="aadhar_front" name="aadhar_front" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_aadhar_front')">
                                    <div id="file_name_aadhar_front" class="selected-filename">
                                        @if($farmer->aadhar_front_path)
                                            <i class="fas fa-check-circle me-1"></i> File Uploaded
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Back Side -->
                            <div class="col-md-6">
                                <div class="upload-card-box" onclick="document.getElementById('aadhar_back').click();">
                                    <div class="upload-icon"><i class="fas fa-upload"></i></div>
                                    <div class="upload-label-title">Back Side</div>
                                    <div class="upload-hint-text">Clear photo of your Aadhaar card back</div>
                                    <span class="btn-upload-file">{{ $farmer->aadhar_back_path ? 'Change File' : 'Upload file' }}</span>
                                    <input type="file" id="aadhar_back" name="aadhar_back" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_aadhar_back')">
                                    <div id="file_name_aadhar_back" class="selected-filename">
                                        @if($farmer->aadhar_back_path)
                                            <i class="fas fa-check-circle me-1"></i> File Uploaded
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Upload Pan Card -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2">Upload Pan Card</label>
                        <div class="upload-card-box" onclick="document.getElementById('pan_card').click();">
                            <div class="upload-icon"><i class="fas fa-upload"></i></div>
                            <div class="upload-hint-text">Upload clear scan or photo of your original PAN card</div>
                            <span class="btn-upload-file">{{ $farmer->pan_card_path ? 'Change File' : 'Upload file' }}</span>
                            <input type="file" id="pan_card" name="pan_card" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_pan_card')">
                            <div id="file_name_pan_card" class="selected-filename">
                                @if($farmer->pan_card_path)
                                    <i class="fas fa-check-circle me-1"></i> File Uploaded
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 3. Additional Documents -->
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small mb-2">Additional Documents</label>
                        <div class="upload-card-box" onclick="document.getElementById('land_certificate').click();">
                            <div class="upload-icon"><i class="fas fa-upload"></i></div>
                            <div class="upload-hint-text">Upload clear scan or photo of your original ID/land document</div>
                            <span class="btn-upload-file">{{ $farmer->land_certificate_path ? 'Change File' : 'Upload file' }}</span>
                            <input type="file" id="land_certificate" name="land_certificate" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_land_cert')">
                            <div id="file_name_land_cert" class="selected-filename">
                                @if($farmer->land_certificate_path)
                                    <i class="fas fa-check-circle me-1"></i> File Uploaded
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-4 text-muted">
                <button type="submit" class="btn btn-primary w-100 py-2">Submit Details for Verification</button>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input, targetId) {
            const displayEl = document.getElementById(targetId);
            if (input.files && input.files[0]) {
                displayEl.innerHTML = '<i class="fas fa-check-circle me-1"></i> ' + input.files[0].name;
            }
        }
    </script>
</body>
</html>

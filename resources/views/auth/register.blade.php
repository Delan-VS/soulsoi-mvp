<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SoulSoil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #F1EFE8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .login-card {
            border: 1px solid #e0ddd4;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            background: white;
            width: 100%;
            max-width: 680px;
            padding: 2.5rem;
        }
        .brand-subtitle {
            color: #5F5E5A;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #5cc42c;
            border-color: #5cc42c;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #479920;
            border-color: #479920;
        }
        .form-control, .form-select {
            border: 1px solid #e0ddd4;
            padding: 0.75rem;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5cc42c;
            box-shadow: 0 0 0 0.2rem rgba(92, 196, 44, 0.25);
        }

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
        .btn-upload-file:hover {
            background-color: #2563eb;
            color: #ffffff;
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
    <div class="login-card">
        <div class="text-center mb-1">
            <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" style="height: 85px; object-fit: contain;">
        </div>
        <h4 class="fw-bold text-center text-dark mb-1">Join SoulSoil</h4>
        <p class="brand-subtitle">Create a Farmer or Investor account for Admin verification.</p>

        @if($errors->any())
        <div class="alert alert-danger p-3 mb-3 small rounded-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="alert alert-warning p-3 mb-4 rounded-3 d-flex align-items-center gap-2" style="font-size: 12px;">
            <i class="fas fa-info-circle fa-lg text-warning flex-shrink-0"></i>
            <div>
                <strong>Approval Required:</strong> New Farmer & Investor registrations are submitted in <strong>Pending</strong> status and require Admin approval.
            </div>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label text-secondary small fw-bold">FULL NAME <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Ramesh Kumar" required autofocus>
                </div>
                <div class="col-md-6">
                    <label for="role" class="form-label text-secondary small fw-bold">ACCOUNT ROLE <span class="text-danger">*</span></label>
                    <select class="form-select" id="role" name="role" onchange="toggleFarmerFields()" required>
                        <option value="" disabled {{ !request('role') && !old('role') ? 'selected' : '' }}>Select role...</option>
                        <option value="farmer" {{ (request('role') == 'farmer' || old('role') == 'farmer') ? 'selected' : '' }}>🌾 Farmer (Agricultural Partner)</option>
                        <option value="investor" {{ (request('role') == 'investor' || old('role') == 'investor') ? 'selected' : '' }}>💼 Investor (Capital Partner)</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label text-secondary small fw-bold">PHONE NUMBER (10 Digits) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="9876543210" maxlength="10" pattern="[0-9]{10}" title="10-digit mobile number" required>
                </div>
            </div>

            <!-- Farmer-Specific Profile & Document Upload Section -->
            <div id="farmer-fields-section" style="display: {{ (request('role') == 'farmer' || old('role') == 'farmer') ? 'block' : 'none' }};" class="p-3 bg-light rounded-3 mb-3 border">
                <h6 class="fw-bold text-success mb-3"><i class="fas fa-tractor me-1"></i> Farmer Profile & Verification Details</h6>
                
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">DISTRICT</label>
                        <input type="text" class="form-control form-control-sm" name="district" value="{{ old('district') }}" placeholder="e.g. Kottayam">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-bold">STATE</label>
                        <input type="text" class="form-control form-control-sm" name="state" value="{{ old('state', 'Kerala') }}" placeholder="Kerala">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label text-secondary small fw-bold">FARM / RESIDENTIAL ADDRESS</label>
                    <input type="text" class="form-control form-control-sm" name="address" value="{{ old('address') }}" placeholder="House Name / Village / Street">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">AADHAR NUMBER (12 Digits)</label>
                    <input type="text" class="form-control form-control-sm" name="aadhar_number" value="{{ old('aadhar_number') }}" placeholder="123456789012" maxlength="12" pattern="[0-9]{12}" title="12-digit Aadhaar number">
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">BANK NAME</label>
                        <input type="text" class="form-control form-control-sm" name="bank_name" value="{{ old('bank_name') }}" placeholder="State Bank of India">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">ACCOUNT NO</label>
                        <input type="text" class="form-control form-control-sm" name="account_number" value="{{ old('account_number') }}" placeholder="30012345678" maxlength="18" pattern="[0-9]{9,18}" title="9 to 18-digit account number">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-bold">IFSC CODE</label>
                        <input type="text" class="form-control form-control-sm" name="ifsc_code" value="{{ old('ifsc_code') }}" placeholder="SBIN0001234" maxlength="11" pattern="[A-Za-z]{4}0[A-Za-z0-9]{6}" title="11-character IFSC code">
                    </div>
                </div>

                <!-- Document Uploads Card (Figma Layout) -->
                <div class="bg-white p-3.5 rounded-3 border mb-2">
                    <h5 class="text-center fw-bold text-dark mb-4">Document Uploads</h5>

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
                                    <span class="btn-upload-file">Upload file</span>
                                    <input type="file" id="aadhar_front" name="aadhar_front" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_aadhar_front')">
                                    <div id="file_name_aadhar_front" class="selected-filename"></div>
                                </div>
                            </div>
                            <!-- Back Side -->
                            <div class="col-md-6">
                                <div class="upload-card-box" onclick="document.getElementById('aadhar_back').click();">
                                    <div class="upload-icon"><i class="fas fa-upload"></i></div>
                                    <div class="upload-label-title">Back Side</div>
                                    <div class="upload-hint-text">Clear photo of your Aadhaar card back</div>
                                    <span class="btn-upload-file">Upload file</span>
                                    <input type="file" id="aadhar_back" name="aadhar_back" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_aadhar_back')">
                                    <div id="file_name_aadhar_back" class="selected-filename"></div>
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
                            <span class="btn-upload-file">Upload file</span>
                            <input type="file" id="pan_card" name="pan_card" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_pan_card')">
                            <div id="file_name_pan_card" class="selected-filename"></div>
                        </div>
                    </div>

                    <!-- 3. Additional Documents -->
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small mb-2">Additional Documents</label>
                        <div class="upload-card-box" onclick="document.getElementById('land_certificate').click();">
                            <div class="upload-icon"><i class="fas fa-upload"></i></div>
                            <div class="upload-hint-text">Upload clear scan or photo of your original ID/land document</div>
                            <span class="btn-upload-file">Upload file</span>
                            <input type="file" id="land_certificate" name="land_certificate" accept="image/*,.pdf" style="display:none;" onchange="updateFileName(this, 'file_name_land_cert')">
                            <div id="file_name_land_cert" class="selected-filename"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="password" class="form-label text-secondary small fw-bold">PASSWORD <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label text-secondary small fw-bold">CONFIRM PASSWORD <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                <i class="fas fa-user-plus me-1"></i> Submit Registration for Approval
            </button>
        </form>

        <div class="text-center mt-2">
            <a href="{{ route('login') }}" class="text-decoration-none small" style="color: #5cc42c; font-weight: 600;">Already have an account? Sign in</a>
        </div>
    </div>

    <script>
        function toggleFarmerFields() {
            const roleSelect = document.getElementById('role');
            const farmerFields = document.getElementById('farmer-fields-section');
            const investorFields = document.getElementById('investor-fields-section');
            
            if (roleSelect.value === 'farmer') {
                if (farmerFields) farmerFields.style.display = 'block';
                if (investorFields) investorFields.style.display = 'none';
            } else if (roleSelect.value === 'investor') {
                if (farmerFields) farmerFields.style.display = 'none';
                if (investorFields) investorFields.style.display = 'block';
            } else {
                if (farmerFields) farmerFields.style.display = 'none';
                if (investorFields) investorFields.style.display = 'none';
            }
        }

        // Run on load
        document.addEventListener('DOMContentLoaded', toggleFarmerFields);

        function updateFileName(input, targetId) {
            const displayEl = document.getElementById(targetId);
            if (input.files && input.files[0]) {
                displayEl.innerHTML = '<i class="fas fa-check-circle me-1"></i> ' + input.files[0].name;
            } else {
                displayEl.innerHTML = '';
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
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

        .form-control,
        .form-select {
            border: 1px solid #e0ddd4;
            padding: 0.75rem;
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
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

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.18) !important;
        }

        .is-valid {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.18) !important;
        }
    </style>
</head>

<body>
    <div class="login-card">
        @php
            $currentRole = request('role', old('role', 'farmer'));
            $isFarmer = ($currentRole === 'farmer');
        @endphp

        <div class="text-center mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" style="height: 85px; object-fit: contain;">
        </div>

        <!-- Role Selector Switcher -->
        <div class="d-flex justify-content-center mb-3">
            <div class="btn-group p-1 bg-light border rounded-pill shadow-xs" role="group" aria-label="Role selector" style="max-width: 380px; width: 100%;">
                <button type="button" class="btn btn-sm rounded-pill fw-bold {{ $isFarmer ? 'btn-success text-white shadow-sm' : 'text-secondary border-0 bg-transparent' }}" id="roleFarmerBtn" onclick="setRegistrationRole('farmer')" style="flex: 1; transition: all 0.2s; font-size: 0.85rem;">
                    Farmer
                </button>
                <button type="button" class="btn btn-sm rounded-pill fw-bold {{ !$isFarmer ? 'btn-primary text-white shadow-sm' : 'text-secondary border-0 bg-transparent' }}" id="roleInvestorBtn" onclick="setRegistrationRole('investor')" style="flex: 1; transition: all 0.2s; font-size: 0.85rem;">
                    Investor
                </button>
            </div>
        </div>

        <h4 class="fw-bold text-center text-dark mb-1" id="form-heading-title">
            {{ $isFarmer ? 'Farmer Registration' : 'Investor Registration' }}
        </h4>
        <p class="brand-subtitle" id="form-heading-subtitle">
            {{ $isFarmer ? 'Submit your details and documents for Admin verification.' : 'Create an investor account to discover verified farmlands.' }}
        </p>

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
                <strong>Approval Required:</strong> New Farmer & Investor registrations are submitted in
                <strong>Pending</strong> status and require Admin approval.
            </div>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Role passed as hidden input -->
            <input type="hidden" name="role" id="role" value="{{ $currentRole }}">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label text-secondary small fw-bold">FULL NAME <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required
                        autofocus>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label text-secondary small fw-bold">
                        EMAIL ADDRESS <span class="text-danger" id="email-required-indicator" style="display: {{ !$isFarmer ? 'inline' : 'none' }};">*</span>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" {{ !$isFarmer ? 'required' : '' }}>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label text-secondary small fw-bold">PHONE NUMBER <span
                            class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                        value="{{ old('phone', '+91 ') }}" maxlength="15"
                        pattern="^\+91\s?[0-9]{10}$" title="10-digit mobile number starting with +91 (e.g. +91 9876543210)" required>
                </div>
            </div>

            <!-- Farmer-Specific Profile & Document Upload Section -->
            <div id="farmer-fields-section"
                style="display: {{ $isFarmer ? 'block' : 'none' }};"
                class="p-3 bg-light rounded-3 mb-3 border">
                <h6 class="fw-bold text-success mb-3"><i class="fas fa-tractor me-1"></i> Farmer Profile & Verification
                    Details</h6>

                <div class="row g-2 mb-2">
                    <div class="col-md-4">
                        <label for="state" class="form-label text-secondary small fw-bold">STATE <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="state" name="state"
                            value="{{ old('state', 'Kerala') }}" readonly
                            style="background-color: #f1f5f9; color: #475569; border-color: #cbd5e1; cursor: default; font-weight: 500;" {{ $isFarmer ? 'required' : 'disabled' }}>
                    </div>
                    <div class="col-md-4">
                        <label for="district" class="form-label text-secondary small fw-bold">DISTRICT <span
                                class="text-danger">*</span></label>
                        <select class="form-select form-control-sm" id="district" name="district" {{ $isFarmer ? 'required' : 'disabled' }}>
                            <option value="" disabled {{ !old('district') ? 'selected' : '' }}>Select District...
                            </option>
                            @foreach(['Alappuzha', 'Ernakulam', 'Idukki', 'Kannur', 'Kasaragod', 'Kollam', 'Kottayam', 'Kozhikode', 'Malappuram', 'Palakkad', 'Pathanamthitta', 'Thiruvananthapuram', 'Thrissur', 'Wayanad', 'Other'] as $dist)
                                <option value="{{ $dist }}" {{ old('district') == $dist ? 'selected' : '' }}>{{ $dist }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="pincode" class="form-label text-secondary small fw-bold">PINCODE <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="pincode" name="pincode"
                            value="{{ old('pincode') }}" maxlength="6" pattern="[0-9]{6}" title="6-digit PIN code" {{ $isFarmer ? 'required' : 'disabled' }}>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="address" class="form-label text-secondary small fw-bold">FARM / RESIDENTIAL
                        ADDRESS <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="address" name="address"
                        value="{{ old('address') }}" {{ $isFarmer ? 'required' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="aadhar_number" class="form-label text-secondary small fw-bold">AADHAAR NUMBER (12
                        Digits) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="aadhar_number" name="aadhar_number"
                        value="{{ old('aadhar_number') }}" maxlength="12" pattern="[0-9]{12}"
                        title="12-digit Aadhaar number" {{ $isFarmer ? 'required' : 'disabled' }}>
                </div>

                <!-- Bank Details directly after Aadhaar -->
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label for="bank_name" class="form-label text-secondary small fw-bold">BANK NAME <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name"
                            value="{{ old('bank_name') }}" {{ $isFarmer ? 'required' : 'disabled' }}>
                    </div>
                    <div class="col-md-6">
                        <label for="ifsc_code" class="form-label text-secondary small fw-bold">IFSC CODE <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="ifsc_code" name="ifsc_code"
                            value="{{ old('ifsc_code') }}" maxlength="11" pattern="[A-Za-z]{4}0[A-Za-z0-9]{6}"
                            title="11-character IFSC code (e.g. SBIN0001234)" {{ $isFarmer ? 'required' : 'disabled' }} oninput="validateIfscCode()" onblur="validateIfscCode()" style="text-transform: uppercase;">
                        <div id="ifsc_code_error" class="text-danger small mt-1" style="display: none; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-times-circle me-1"></i> Invalid IFSC format. Must be 11 characters (e.g. SBIN0001234).
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label for="account_number" class="form-label text-secondary small fw-bold">ACCOUNT NO <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="account_number"
                            name="account_number" value="{{ old('account_number') }}" maxlength="18"
                            pattern="[0-9]{9,18}" title="9 to 18-digit account number" {{ $isFarmer ? 'required' : 'disabled' }} oninput="validateAccountNumberMatch()">
                    </div>
                    <div class="col-md-6">
                        <label for="account_number_confirmation" class="form-label text-secondary small fw-bold">CONFIRM ACCOUNT
                            NO <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="account_number_confirmation"
                            name="account_number_confirmation" value="{{ old('account_number_confirmation') }}" maxlength="18"
                            pattern="[0-9]{9,18}" title="Confirm your account number" {{ $isFarmer ? 'required' : 'disabled' }} oninput="validateAccountNumberMatch()">
                        <div id="account_number_confirmation_error" class="text-danger small mt-1" style="display: none; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-times-circle me-1"></i> Account number confirmation does not match.
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-12">
                        <label for="account_holder_name" class="form-label text-secondary small fw-bold">ACCOUNT HOLDER
                            NAME <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="account_holder_name"
                            name="account_holder_name" value="{{ old('account_holder_name') }}" {{ $isFarmer ? 'required' : 'disabled' }}>
                    </div>
                </div>

                <!-- Document Uploads Card (Figma Layout) -->
                <div class="bg-white p-3.5 rounded-3 border mb-2">
                    <h5 class="text-center fw-bold text-dark mb-2">Document Uploads</h5>
                    <div class="text-center mb-3">
                        <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle text-primary me-1"></i> Images and documents must be <strong>1MB or less</strong> (JPG, PNG, PDF)
                        </span>
                    </div>

                    <!-- Hidden inputs for AJAX uploaded files -->
                    <input type="hidden" name="aadhar_front_path" id="aadhar_front_path" value="{{ old('aadhar_front_path') }}" {{ $isFarmer ? '' : 'disabled' }}>
                    <input type="hidden" name="aadhar_back_path" id="aadhar_back_path" value="{{ old('aadhar_back_path') }}" {{ $isFarmer ? '' : 'disabled' }}>
                    <input type="hidden" name="pan_card_path" id="pan_card_path" value="{{ old('pan_card_path') }}" {{ $isFarmer ? '' : 'disabled' }}>
                    <input type="hidden" name="land_certificate_path" id="land_certificate_path" value="{{ old('land_certificate_path') }}" {{ $isFarmer ? '' : 'disabled' }}>

                    <!-- 1. Upload Aadhaar Card -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2">Upload Aadhaar Card <span class="text-danger">*</span> <span class="text-muted fw-normal" style="font-size: 0.75rem;">(Max 1MB per image)</span></label>
                        <div class="row g-3">
                            <!-- Front Side -->
                            <div class="col-md-6">
                                <div class="upload-card-box" onclick="document.getElementById('aadhar_front').click();">
                                    <div class="upload-icon"><i class="fas fa-upload"></i></div>
                                    <div class="upload-label-title">Front Side <span class="text-danger">*</span></div>
                                    <div class="upload-hint-text">Clear photo of Aadhaar front (Max 1MB)</div>
                                    <span class="btn-upload-file">Upload file</span>
                                    <input type="file" id="aadhar_front" name="aadhar_front" accept="image/*,.pdf"
                                        style="display:none;" {{ $isFarmer ? '' : 'disabled' }} onchange="uploadFileAjax(this, 'aadhar_front', 'file_name_aadhar_front', 'aadhar_front_path')">
                                    <div id="file_name_aadhar_front" class="selected-filename"></div>
                                </div>
                            </div>
                            <!-- Back Side -->
                            <div class="col-md-6">
                                <div class="upload-card-box" onclick="document.getElementById('aadhar_back').click();">
                                    <div class="upload-icon"><i class="fas fa-upload"></i></div>
                                    <div class="upload-label-title">Back Side <span class="text-danger">*</span></div>
                                    <div class="upload-hint-text">Clear photo of Aadhaar back (Max 1MB)</div>
                                    <span class="btn-upload-file">Upload file</span>
                                    <input type="file" id="aadhar_back" name="aadhar_back" accept="image/*,.pdf"
                                        style="display:none;" {{ $isFarmer ? '' : 'disabled' }} onchange="uploadFileAjax(this, 'aadhar_back', 'file_name_aadhar_back', 'aadhar_back_path')">
                                    <div id="file_name_aadhar_back" class="selected-filename"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Upload Pan Card -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-2">Upload Pan Card <span class="text-muted fw-normal" style="font-size: 0.75rem;">(Max 1MB)</span></label>
                        <div class="upload-card-box" onclick="document.getElementById('pan_card').click();">
                            <div class="upload-icon"><i class="fas fa-upload"></i></div>
                            <div class="upload-hint-text">Upload clear scan or photo of PAN card (Max 1MB)</div>
                            <span class="btn-upload-file">Upload file</span>
                            <input type="file" id="pan_card" name="pan_card" accept="image/*,.pdf" style="display:none;"
                                {{ $isFarmer ? '' : 'disabled' }} onchange="uploadFileAjax(this, 'pan_card', 'file_name_pan_card', 'pan_card_path')">
                            <div id="file_name_pan_card" class="selected-filename"></div>
                        </div>
                    </div>

                    <!-- 3. Additional Documents -->
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small mb-2">Additional Documents <span class="text-muted fw-normal" style="font-size: 0.75rem;">(Max 1MB)</span></label>
                        <div class="upload-card-box" onclick="document.getElementById('land_certificate').click();">
                            <div class="upload-icon"><i class="fas fa-upload"></i></div>
                            <div class="upload-hint-text">Upload scan or photo of ID/land document (Max 1MB)</div>
                            <span class="btn-upload-file">Upload file</span>
                            <input type="file" id="land_certificate" name="land_certificate" accept="image/*,.pdf"
                                style="display:none;" {{ $isFarmer ? '' : 'disabled' }} onchange="uploadFileAjax(this, 'land_certificate', 'file_name_land_cert', 'land_certificate_path')">
                            <div id="file_name_land_cert" class="selected-filename"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-2">
                <div class="col-md-6">
                    <label for="password" class="form-label text-secondary small fw-bold">PASSWORD <span
                            class="text-danger">*</span></label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" id="password" name="password" minlength="8"
                            required oninput="validatePasswordRules()">
                        <button type="button"
                            class="btn btn-sm text-secondary position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent"
                            onclick="togglePassVisibility('password', this)"
                            style="font-size: 0.8rem; font-weight: 600;">Show</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label text-secondary small fw-bold">CONFIRM PASSWORD
                        <span class="text-danger">*</span></label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" id="password_confirmation"
                            name="password_confirmation" minlength="8" required oninput="validatePasswordRules()">
                        <button type="button"
                            class="btn btn-sm text-secondary position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent"
                            onclick="togglePassVisibility('password_confirmation', this)"
                            style="font-size: 0.8rem; font-weight: 600;">Show</button>
                    </div>
                </div>
            </div>

            <!-- Password Validation Requirements Guide -->
            <div class="p-3 mb-4 rounded-3 bg-light border" id="password-validation-box" style="font-size: 12px;">
                <div class="fw-bold text-secondary mb-2"><i class="fas fa-shield-alt me-1 text-primary"></i> Password
                    Requirements:</div>
                <div class="row g-2">
                    <div class="col-sm-6">
                        <div id="rule-length" class="text-muted d-flex align-items-center gap-1.5">
                            <i class="fas fa-times-circle text-danger me-1"></i> At least 8 characters
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="rule-letters" class="text-muted d-flex align-items-center gap-1.5">
                            <i class="fas fa-times-circle text-danger me-1"></i> Contains letters (a-z, A-Z)
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="rule-numbers" class="text-muted d-flex align-items-center gap-1.5">
                            <i class="fas fa-times-circle text-danger me-1"></i> Contains at least 1 number (0-9)
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="rule-match" class="text-muted d-flex align-items-center gap-1.5">
                            <i class="fas fa-times-circle text-danger me-1"></i> Passwords match
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" id="submit-btn" class="btn btn-primary w-100 mb-2 shadow-sm" disabled style="opacity: 0.6; cursor: not-allowed;">
                <i class="fas fa-user-plus me-1"></i> Submit Registration for Approval
            </button>
            <div id="form-validation-status" class="text-center small text-muted mb-3" style="font-size: 0.8rem;">
                <i class="fas fa-info-circle me-1 text-warning"></i> Complete all required fields to enable registration.
            </div>
        </form>

        <div class="text-center mt-2">
            <a href="{{ route('login') }}" class="text-decoration-none small"
                style="color: #5cc42c; font-weight: 600;">Already have an account? Sign in</a>
        </div>
    </div>

    <script>
        function setRegistrationRole(role) {
            const roleInput = document.getElementById('role');
            if (roleInput) {
                roleInput.value = role;
            }

            const farmerBtn = document.getElementById('roleFarmerBtn');
            const investorBtn = document.getElementById('roleInvestorBtn');
            const headingTitle = document.getElementById('form-heading-title');
            const headingSubtitle = document.getElementById('form-heading-subtitle');
            const emailReqStar = document.getElementById('email-required-indicator');
            const emailInput = document.getElementById('email');

            if (role === 'farmer') {
                if (farmerBtn) {
                    farmerBtn.className = 'btn btn-sm rounded-pill fw-bold btn-success text-white shadow-sm';
                }
                if (investorBtn) {
                    investorBtn.className = 'btn btn-sm rounded-pill fw-bold text-secondary border-0 bg-transparent';
                }
                if (headingTitle) headingTitle.textContent = 'Farmer Registration';
                if (headingSubtitle) headingSubtitle.textContent = 'Submit your details and documents for Admin verification.';
                if (emailReqStar) emailReqStar.style.display = 'none';
                if (emailInput) {
                    emailInput.removeAttribute('required');
                }
            } else {
                if (farmerBtn) {
                    farmerBtn.className = 'btn btn-sm rounded-pill fw-bold text-secondary border-0 bg-transparent';
                }
                if (investorBtn) {
                    investorBtn.className = 'btn btn-sm rounded-pill fw-bold btn-primary text-white shadow-sm';
                }
                if (headingTitle) headingTitle.textContent = 'Investor Registration';
                if (headingSubtitle) headingSubtitle.textContent = 'Create an investor account to discover verified farmlands.';
                if (emailReqStar) emailReqStar.style.display = 'inline';
                if (emailInput) {
                    emailInput.setAttribute('required', 'required');
                }
            }

            toggleFarmerFields();
            checkFormValidity();
        }

        function toggleFarmerFields() {
            const roleInput = document.getElementById('role');
            const role = roleInput ? roleInput.value : 'farmer';
            const farmerFields = document.getElementById('farmer-fields-section');

            if (!farmerFields) return;

            const farmerControls = farmerFields.querySelectorAll('input, select, textarea');

            if (role === 'farmer') {
                farmerFields.style.display = 'block';
                farmerControls.forEach(ctrl => {
                    ctrl.disabled = false;
                    if (['state', 'district', 'pincode', 'address', 'aadhar_number', 'bank_name', 'ifsc_code', 'account_number', 'account_number_confirmation', 'account_holder_name'].includes(ctrl.name)) {
                        ctrl.required = true;
                    }
                });
            } else {
                farmerFields.style.display = 'none';
                farmerControls.forEach(ctrl => {
                    ctrl.disabled = true;
                    ctrl.required = false;
                });
            }
        }

        // AJAX Document Upload Handler
        function uploadFileAjax(input, type, displayId, hiddenInputId) {
            const displayEl = document.getElementById(displayId);
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const maxSizeBytes = 1024 * 1024; // 1 MB limit (1,048,576 bytes)

            // Client-side 1MB size check
            if (file.size > maxSizeBytes) {
                const actualMb = (file.size / (1024 * 1024)).toFixed(2);
                displayEl.innerHTML = `
                    <div class="text-danger small mt-2 fw-semibold p-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25 text-center">
                        <i class="fas fa-exclamation-triangle me-1"></i> File size is ${actualMb}MB. Images and documents must be 1MB or less.
                    </div>
                `;
                input.value = '';
                document.getElementById(hiddenInputId).value = '';
                checkFormValidity();
                return;
            }

            const formData = new FormData();
            formData.append('document', file);
            formData.append('type', type);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : (document.querySelector('input[name="_token"]') ? document.querySelector('input[name="_token"]').value : '');

            displayEl.innerHTML = '<div class="text-primary py-2 small fw-semibold"><span class="spinner-border spinner-border-sm me-1" role="status"></span> Uploading file...</div>';

            fetch('{{ route('register.upload.document') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    let errMsg = 'Upload failed. File must be under 1MB.';
                    if (data.errors && data.errors.document) {
                        errMsg = data.errors.document[0];
                    } else if (data.message) {
                        errMsg = data.message;
                    }
                    throw new Error(errMsg);
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    document.getElementById(hiddenInputId).value = data.path;
                    if (data.is_image) {
                        displayEl.innerHTML = `
                            <div class="mt-2 text-center">
                                <img src="${data.url}" alt="Preview" class="rounded border shadow-sm" style="max-height: 85px; max-width: 100%; object-fit: contain;">
                                <div class="text-success small fw-semibold mt-1">
                                    <i class="fas fa-check-circle me-1"></i> ${data.filename}
                                </div>
                            </div>
                        `;
                    } else {
                        displayEl.innerHTML = `
                            <div class="mt-2 text-center text-success small fw-semibold">
                                <i class="fas fa-file-pdf text-danger fa-2x mb-1 d-block"></i>
                                <i class="fas fa-check-circle me-1"></i> ${data.filename}
                            </div>
                        `;
                    }
                    checkFormValidity();
                } else {
                    displayEl.innerHTML = '<div class="text-danger small mt-1"><i class="fas fa-times-circle me-1"></i> Upload error. Please retry.</div>';
                    input.value = '';
                    document.getElementById(hiddenInputId).value = '';
                    checkFormValidity();
                }
            })
            .catch(err => {
                console.error('AJAX upload error:', err);
                displayEl.innerHTML = `<div class="text-danger small mt-2 fw-semibold p-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25 text-center"><i class="fas fa-times-circle me-1"></i> ${err.message || 'Upload failed. File must be under 1MB.'}</div>`;
                input.value = '';
                document.getElementById(hiddenInputId).value = '';
                checkFormValidity();
            });
        }

        // Real-Time Form Validity Checker to Enable/Disable Submit Button
        function checkFormValidity() {
            const role = document.getElementById('role') ? document.getElementById('role').value : 'farmer';
            const submitBtn = document.getElementById('submit-btn');
            const statusEl = document.getElementById('form-validation-status');
            if (!submitBtn) return;

            let isValid = true;
            let missing = [];

            // 1. Full Name
            const nameEl = document.getElementById('name');
            if (!nameEl || nameEl.value.trim().length < 2) {
                isValid = false;
                missing.push('Full Name');
            }

            // 2. Email (required for investor, optional but validated for farmer)
            const emailEl = document.getElementById('email');
            const emailVal = emailEl ? emailEl.value.trim() : '';
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (role === 'investor') {
                if (!emailVal || !emailRegex.test(emailVal)) {
                    isValid = false;
                    missing.push('Valid Email Address');
                }
            } else if (emailVal && !emailRegex.test(emailVal)) {
                isValid = false;
                missing.push('Valid Email Format');
            }

            // 3. Phone Number (+91 followed by 10 digits)
            const phoneEl = document.getElementById('phone');
            if (!phoneEl || !/^\+91\s?[0-9]{10}$/.test(phoneEl.value.trim())) {
                isValid = false;
                missing.push('10-digit Phone Number');
            }

            if (role === 'farmer') {
                // District
                const districtEl = document.getElementById('district');
                if (!districtEl || !districtEl.value) {
                    isValid = false;
                    missing.push('District');
                }

                // State
                const stateEl = document.getElementById('state');
                if (!stateEl || stateEl.value.trim().length < 2) {
                    isValid = false;
                    missing.push('State');
                }

                // Pincode (6 digits)
                const pincodeEl = document.getElementById('pincode');
                if (!pincodeEl || !/^[0-9]{6}$/.test(pincodeEl.value.trim())) {
                    isValid = false;
                    missing.push('6-digit PIN code');
                }

                // Farm / Residential Address
                const addressEl = document.getElementById('address');
                if (!addressEl || addressEl.value.trim().length < 3) {
                    isValid = false;
                    missing.push('Address');
                }

                // Aadhaar Number (12 digits)
                const aadharEl = document.getElementById('aadhar_number');
                if (!aadharEl || !/^[0-9]{12}$/.test(aadharEl.value.trim())) {
                    isValid = false;
                    missing.push('12-digit Aadhaar Number');
                }

                // Bank Name
                const bankEl = document.getElementById('bank_name');
                if (!bankEl || bankEl.value.trim().length < 2) {
                    isValid = false;
                    missing.push('Bank Name');
                }

                // IFSC Code (11 alphanumeric, e.g. SBIN0001234)
                const ifscEl = document.getElementById('ifsc_code');
                if (!ifscEl || !/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/.test(ifscEl.value.trim())) {
                    isValid = false;
                    missing.push('IFSC Code');
                }

                // Account Number (9-18 digits)
                const accNoEl = document.getElementById('account_number');
                const accVal = accNoEl ? accNoEl.value.trim() : '';
                if (!/^[0-9]{9,18}$/.test(accVal)) {
                    isValid = false;
                    missing.push('Account Number');
                }

                // Confirm Account Number
                const confAccNoEl = document.getElementById('account_number_confirmation');
                const confAccVal = confAccNoEl ? confAccNoEl.value.trim() : '';
                validateAccountNumberMatch();
                if (!confAccVal || confAccVal !== accVal) {
                    isValid = false;
                    missing.push('Matching Confirm Account No');
                }

                // Account Holder Name
                const accHolderEl = document.getElementById('account_holder_name');
                if (!accHolderEl || accHolderEl.value.trim().length < 2) {
                    isValid = false;
                    missing.push('Account Holder Name');
                }

                // Aadhaar Front Side Upload
                const frontPath = document.getElementById('aadhar_front_path') ? document.getElementById('aadhar_front_path').value : '';
                const frontFile = document.getElementById('aadhar_front') && document.getElementById('aadhar_front').files.length > 0;
                if (!frontPath && !frontFile) {
                    isValid = false;
                    missing.push('Aadhaar Front Side Upload');
                }

                // Aadhaar Back Side Upload
                const backPath = document.getElementById('aadhar_back_path') ? document.getElementById('aadhar_back_path').value : '';
                const backFile = document.getElementById('aadhar_back') && document.getElementById('aadhar_back').files.length > 0;
                if (!backPath && !backFile) {
                    isValid = false;
                    missing.push('Aadhaar Back Side Upload');
                }
            }

            // Password
            const passEl = document.getElementById('password');
            const pass = passEl ? passEl.value : '';
            const hasPass = pass.length >= 8 && /[a-zA-Z]/.test(pass) && /[0-9]/.test(pass);
            if (!hasPass) {
                isValid = false;
                missing.push('Password Requirements');
            }

            // Password Confirmation
            const confirmEl = document.getElementById('password_confirmation');
            const confirmVal = confirmEl ? confirmEl.value : '';
            if (!confirmVal || confirmVal !== pass) {
                isValid = false;
                missing.push('Matching Password Confirmation');
            }

            if (isValid) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                if (statusEl) {
                    statusEl.className = 'text-center small text-success mb-3 fw-semibold';
                    statusEl.innerHTML = '<i class="fas fa-check-circle me-1"></i> All fields complete! Ready to submit.';
                }
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                if (statusEl) {
                    statusEl.className = 'text-center small text-muted mb-3';
                    const missingText = missing.join(', ');
                    statusEl.innerHTML = `<i class="fas fa-info-circle me-1 text-warning"></i> Complete all required fields to enable registration (${missing.length} remaining: ${missingText}).`;
                }
            }
        }

        function validateAccountNumberMatch() {
            const accNoEl = document.getElementById('account_number');
            const confAccNoEl = document.getElementById('account_number_confirmation');
            const errEl = document.getElementById('account_number_confirmation_error');
            if (!confAccNoEl) return;

            const accVal = accNoEl ? accNoEl.value.trim() : '';
            const confVal = confAccNoEl.value.trim();

            if (confVal.length > 0) {
                if (confVal !== accVal) {
                    confAccNoEl.classList.add('is-invalid');
                    confAccNoEl.classList.remove('is-valid');
                    if (errEl) errEl.style.display = 'block';
                } else {
                    confAccNoEl.classList.remove('is-invalid');
                    confAccNoEl.classList.add('is-valid');
                    if (errEl) errEl.style.display = 'none';
                }
            } else {
                confAccNoEl.classList.remove('is-invalid', 'is-valid');
                if (errEl) errEl.style.display = 'none';
            }
        }

        function validateIfscCode() {
            const ifscEl = document.getElementById('ifsc_code');
            const errEl = document.getElementById('ifsc_code_error');
            if (!ifscEl) return;

            // Automatically uppercase and clean input
            let val = ifscEl.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (val !== ifscEl.value) {
                ifscEl.value = val;
            }

            const ifscRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/;

            if (val.length === 0) {
                ifscEl.classList.remove('is-invalid', 'is-valid');
                if (errEl) errEl.style.display = 'none';
            } else if (ifscRegex.test(val)) {
                ifscEl.classList.remove('is-invalid');
                ifscEl.classList.add('is-valid');
                if (errEl) errEl.style.display = 'none';
            } else {
                ifscEl.classList.add('is-invalid');
                ifscEl.classList.remove('is-valid');
                if (errEl) {
                    errEl.style.display = 'block';
                    if (val.length < 11) {
                        errEl.innerHTML = `<i class="fas fa-times-circle me-1"></i> IFSC code must be 11 characters (${val.length}/11 entered).`;
                    } else if (val.length === 11 && val[4] !== '0') {
                        errEl.innerHTML = `<i class="fas fa-times-circle me-1"></i> 5th character must be '0' (zero), e.g. SBIN0001234.`;
                    } else {
                        errEl.innerHTML = `<i class="fas fa-times-circle me-1"></i> Invalid format. First 4 characters must be letters (e.g. SBIN0001234).`;
                    }
                }
            }

            checkFormValidity();
        }

        function validatePasswordRules() {
            const pass = document.getElementById('password') ? document.getElementById('password').value : '';
            const confirm = document.getElementById('password_confirmation') ? document.getElementById('password_confirmation').value : '';

            const hasLength = pass.length >= 8;
            const hasLetters = /[a-zA-Z]/.test(pass);
            const hasNumbers = /[0-9]/.test(pass);
            const hasMatch = pass.length > 0 && pass === confirm;

            updateRule('rule-length', hasLength, 'At least 8 characters');
            updateRule('rule-letters', hasLetters, 'Contains letters (a-z, A-Z)');
            updateRule('rule-numbers', hasNumbers, 'Contains at least 1 number (0-9)');
            updateRule('rule-match', hasMatch, 'Passwords match');

            checkFormValidity();
        }

        function updateRule(elementId, isValid, text) {
            const el = document.getElementById(elementId);
            if (!el) return;
            if (isValid) {
                el.className = 'text-success fw-semibold d-flex align-items-center gap-1.5';
                el.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i> ${text}`;
            } else {
                el.className = 'text-muted d-flex align-items-center gap-1.5';
                el.innerHTML = `<i class="fas fa-times-circle text-danger me-1"></i> ${text}`;
            }
        }

        function togglePassVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            btn.textContent = isPass ? 'Hide' : 'Show';
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleFarmerFields();
            validatePasswordRules();

            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                if (!phoneInput.value || phoneInput.value.trim() === '') {
                    phoneInput.value = '+91 ';
                }

                phoneInput.addEventListener('focus', function () {
                    if (!this.value.startsWith('+91')) {
                        this.value = '+91 ';
                    }
                });

                phoneInput.addEventListener('input', function () {
                    let val = this.value;
                    if (!val.startsWith('+91')) {
                        let digits = val.replace(/[^0-9]/g, '');
                        if (digits.startsWith('91')) {
                            digits = digits.substring(2);
                        }
                        this.value = '+91 ' + digits.substring(0, 10);
                    } else {
                        let prefix = '+91 ';
                        let rest = val.substring(3).replace(/[^0-9]/g, '').substring(0, 10);
                        this.value = prefix + rest;
                    }
                });

                phoneInput.addEventListener('keydown', function (e) {
                    if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart <= 4 && this.selectionEnd <= 4) {
                        e.preventDefault();
                    }
                });
            }

            // Real-time listener for all form inputs
            const form = document.querySelector('form');
            if (form) {
                ['input', 'change', 'keyup', 'paste'].forEach(evtName => {
                    form.addEventListener(evtName, function () {
                        checkFormValidity();
                    });
                });

                form.addEventListener('submit', function (e) {
                    checkFormValidity();
                    const submitBtn = document.getElementById('submit-btn');
                    if (submitBtn && submitBtn.disabled) {
                        e.preventDefault();
                        alert('Please complete all required fields properly before submitting.');
                        return false;
                    }

                    const role = document.getElementById('role') ? document.getElementById('role').value : 'farmer';

                    if (role === 'investor') {
                        const emailEl = document.getElementById('email');
                        const emailVal = emailEl ? emailEl.value.trim() : '';
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailVal || !emailRegex.test(emailVal)) {
                            e.preventDefault();
                            alert('Please provide a valid email address.');
                            if (emailEl) emailEl.focus();
                            return false;
                        }
                    }

                    if (phoneInput && !/^\+91\s?[0-9]{10}$/.test(phoneInput.value.trim())) {
                        e.preventDefault();
                        alert('Phone number must start with +91 followed by a 10-digit mobile number.');
                        phoneInput.focus();
                        return false;
                    }

                    if (role === 'farmer') {
                        const accNo = document.getElementById('account_number') ? document.getElementById('account_number').value.trim() : '';
                        const confAccNo = document.getElementById('account_number_confirmation') ? document.getElementById('account_number_confirmation').value.trim() : '';
                        if (accNo && confAccNo && accNo !== confAccNo) {
                            e.preventDefault();
                            alert('Account number confirmation does not match.');
                            document.getElementById('account_number_confirmation').focus();
                            return false;
                        }
                    }

                    const pass = document.getElementById('password') ? document.getElementById('password').value : '';
                    const confirm = document.getElementById('password_confirmation') ? document.getElementById('password_confirmation').value : '';

                    if (pass.length < 8 || !/[a-zA-Z]/.test(pass) || !/[0-9]/.test(pass)) {
                        e.preventDefault();
                        alert('Password must be at least 8 characters long and contain both letters and numbers.');
                        document.getElementById('password').focus();
                        return false;
                    }
                    if (pass !== confirm) {
                        e.preventDefault();
                        alert('Password confirmation does not match.');
                        document.getElementById('password_confirmation').focus();
                        return false;
                    }
                });
            }

            // Initial check on load
            checkFormValidity();
        });
    </script>
</body>

</html>
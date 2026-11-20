<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SoulSoil Admin</title>
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
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }
        .brand-title {
            color: #5cc42c;
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .brand-subtitle {
            color: #5F5E5A;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .btn-primary {
            background-color: #5cc42c;
            border-color: #5cc42c;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #479920;
            border-color: #479920;
        }
        .form-control {
            border: 1px solid #e0ddd4;
            padding: 0.75rem;
        }
        .form-control:focus {
            border-color: #5cc42c;
            box-shadow: 0 0 0 0.2rem rgba(92, 196, 44, 0.25);
        }
        .password-field { position: relative; }
        .password-toggle {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #5F5E5A;
            font-size: .85rem;
            font-weight: 600;
        }
        .role-choice-card {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.15rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #ffffff;
            color: inherit;
        }
        .role-choice-card:hover {
            border-color: #5cc42c;
            background-color: #f8faf6;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(92, 196, 44, 0.12);
            color: inherit;
        }
        .role-choice-card.investor-card:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.12);
            color: inherit;
        }
        .role-icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-1">
            <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" style="height: 100px; object-fit: contain;">
        </div>
        <p class="brand-subtitle">Sign in to manage your farms and investments.</p>

        @if(session('success'))
        <div class="alert alert-success p-2.5 mb-3 small rounded-3 d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger p-2 mb-3 small">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label text-secondary small fw-bold mb-0">PASSWORD</label>
                    <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold" onclick="openPasswordModal('reset')" style="color: #5cc42c; font-size: 0.82rem;">
                        Forgot Password?
                    </button>
                </div>
                <div class="password-field">
                    <input type="password" class="form-control pe-5" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                    <button type="button" class="password-toggle" id="password-toggle" aria-label="Show password">Show</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <div>
                <span class="text-secondary small">Don't have an account?</span>
                <button type="button" class="btn btn-link p-0 text-decoration-none fw-bold ms-1" id="createAccountBtn" data-bs-toggle="modal" data-bs-target="#registerModal" style="color: #5cc42c; font-size: 0.88rem; vertical-align: baseline;">
                    Create Account
                </button>
            </div>
            <div>
                <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold text-secondary small" onclick="openPasswordModal('change')" title="Update existing password with verification">
                    <i class="fas fa-lock me-1 text-muted" style="font-size: 11px;"></i> Change Password
                </button>
            </div>
        </div>

        <div class="mt-3 pt-3 border-top" style="border-top: 1px solid #e0ddd4 !important;">
            <p class="text-center text-muted small fw-bold mb-1">TRY A DEMO ACCOUNT</p>
            <p class="text-center text-muted small mb-2">Choose a role to sign in instantly.</p>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickLogin('admin@soulsoil.com', 'password')">
                    Admin: admin@soulsoil.com
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickLogin('remesh@gmail.com', 'password')">
                    Farmer: remesh@gmail.com
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickLogin('siddharth@example.com', 'password')">
                    Investor: siddharth@example.com
                </button>
            </div>
        </div>
    </div>

    <!-- Create Account Role Selection Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0 pb-1 pt-4 px-4">
                    <div>
                        <h5 class="modal-title fw-bold text-dark fs-5" id="registerModalLabel">
                            Create an Account
                        </h5>
                        <p class="text-muted small mb-0 mt-1">Select your account type to register with SoulSoil:</p>
                    </div>
                    <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-3">
                    <div class="d-grid gap-3">
                        <!-- Button 1: Register as Farmer -->
                        <a href="{{ route('register', ['role' => 'farmer']) }}" id="registerFarmerBtn" class="role-choice-card farmer-card">
                            <div class="w-100">
                                <div class="fw-bold text-dark fs-6">Register as Farmer</div>
                                <div class="text-muted small mt-1" style="line-height: 1.35; font-size: 0.78rem;">
                                    For agricultural landowners & farm owners to list harvests and manage crops
                                </div>
                            </div>
                        </a>

                        <!-- Button 2: Register as Investors -->
                        <a href="{{ route('register', ['role' => 'investor']) }}" id="registerInvestorBtn" class="role-choice-card investor-card">
                            <div class="w-100">
                                <div class="fw-bold text-dark fs-6">Register as Investors</div>
                                <div class="text-muted small mt-1" style="line-height: 1.35; font-size: 0.78rem;">
                                    Discover verified high-yield agricultural farms and invest capital
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center">
                    <span class="text-muted small">
                        Already have an account? 
                        <a href="javascript:void(0)" data-bs-dismiss="modal" class="fw-bold text-decoration-none" style="color: #5cc42c;">Sign In here</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Unified Password Modal (Both Reset & Change) -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 22px; overflow: hidden;">
                <div class="modal-header border-0 pb-2 pt-4 px-4 bg-light">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="modal-title fw-bold text-dark fs-5" id="passwordModalLabel">
                                Password Settings
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Navigation Pills for Reset vs Change -->
                        <ul class="nav nav-pills nav-fill bg-white p-1 rounded-pill border" id="passwordModalTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill py-1.5 fw-bold" id="tab-reset-btn" data-bs-toggle="pill" data-bs-target="#pane-reset-password" type="button" role="tab" style="font-size: 0.82rem;">
                                    <i class="fas fa-key me-1"></i> Reset Password
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill py-1.5 fw-bold" id="tab-change-btn" data-bs-toggle="pill" data-bs-target="#pane-change-password" type="button" role="tab" style="font-size: 0.82rem;">
                                    <i class="fas fa-lock me-1"></i> Change Password
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- PANE 1: RESET PASSWORD (Forgot Password: No Current Password Required) -->
                    <div class="tab-pane fade show active" id="pane-reset-password" role="tabpanel">
                        <form action="{{ route('password.reset') }}" method="POST">
                            @csrf
                            <div class="modal-body p-4 pt-3">
                                <div class="alert alert-info py-2 px-3 mb-3 small border-0 bg-info bg-opacity-10 text-dark rounded-3" style="font-size: 11px;">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Forgot your password? Enter your registered email to set a brand new password.
                                </div>
                                @if($errors->resetPassword->any())
                                <div class="alert alert-danger p-2 mb-3 small rounded-3">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->resetPassword->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="rp_email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
                                    <input type="email" class="form-control" id="rp_email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="rp_new_password" class="form-label text-secondary small fw-bold">NEW PASSWORD</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control pe-5" id="rp_new_password" name="new_password" placeholder="Enter new password" autocomplete="new-password" minlength="8" required>
                                        <button type="button" class="password-toggle cp-password-toggle" data-target="rp_new_password" aria-label="Show password">Show</button>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.76rem;">Must be at least 8 characters with letters & numbers.</div>
                                </div>

                                <div class="mb-1">
                                    <label for="rp_new_password_confirmation" class="form-label text-secondary small fw-bold">CONFIRM NEW PASSWORD</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control pe-5" id="rp_new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" autocomplete="new-password" minlength="8" required>
                                        <button type="button" class="password-toggle cp-password-toggle" data-target="rp_new_password_confirmation" aria-label="Show password">Show</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary flex-fill rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary flex-fill rounded-pill fw-bold" style="background-color: #064e3b; border-color: #064e3b;">Reset Password</button>
                            </div>
                        </form>
                    </div>

                    <!-- PANE 2: CHANGE PASSWORD (Requires Current Password Verification) -->
                    <div class="tab-pane fade" id="pane-change-password" role="tabpanel">
                        <form action="{{ route('password.change') }}" method="POST">
                            @csrf
                            <div class="modal-body p-4 pt-3">
                                <div class="alert alert-secondary py-2 px-3 mb-3 small border-0 bg-light text-dark rounded-3" style="font-size: 11px;">
                                    <i class="fas fa-shield-alt text-success me-1"></i> Know your current password? Verify it here to securely set a new one.
                                </div>
                                @if($errors->changePassword->any())
                                <div class="alert alert-danger p-2 mb-3 small rounded-3">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->changePassword->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="cp_email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
                                    <input type="email" class="form-control" id="cp_email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cp_current_password" class="form-label text-secondary small fw-bold">CURRENT PASSWORD</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control pe-5" id="cp_current_password" name="current_password" placeholder="Enter current password" autocomplete="current-password" required>
                                        <button type="button" class="password-toggle cp-password-toggle" data-target="cp_current_password" aria-label="Show password">Show</button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="cp_new_password" class="form-label text-secondary small fw-bold">NEW PASSWORD</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control pe-5" id="cp_new_password" name="new_password" placeholder="Enter new password" autocomplete="new-password" minlength="8" required>
                                        <button type="button" class="password-toggle cp-password-toggle" data-target="cp_new_password" aria-label="Show password">Show</button>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.76rem;">Must be different from your current password.</div>
                                </div>

                                <div class="mb-1">
                                    <label for="cp_new_password_confirmation" class="form-label text-secondary small fw-bold">CONFIRM NEW PASSWORD</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control pe-5" id="cp_new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" autocomplete="new-password" minlength="8" required>
                                        <button type="button" class="password-toggle cp-password-toggle" data-target="cp_new_password_confirmation" aria-label="Show password">Show</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary flex-fill rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary flex-fill rounded-pill fw-bold" style="background-color: #064e3b; border-color: #064e3b;">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
        document.getElementById('password-toggle').addEventListener('click', function () {
            const password = document.getElementById('password');
            const visible = password.type === 'text';
            password.type = visible ? 'password' : 'text';
            this.textContent = visible ? 'Show' : 'Hide';
            this.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
        });

        document.querySelectorAll('.cp-password-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = document.getElementById(this.getAttribute('data-target'));
                if (!input) return;
                const visible = input.type === 'text';
                input.type = visible ? 'password' : 'text';
                this.textContent = visible ? 'Show' : 'Hide';
                this.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
            });
        });

        function openPasswordModal(mode) {
            const modalEl = document.getElementById('passwordModal');
            if (!modalEl) return;
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            const loginEmail = document.getElementById('email')?.value || '';
            const rpEmail = document.getElementById('rp_email');
            const cpEmail = document.getElementById('cp_email');
            if (loginEmail) {
                if (rpEmail && !rpEmail.value) rpEmail.value = loginEmail;
                if (cpEmail && !cpEmail.value) cpEmail.value = loginEmail;
            }

            if (mode === 'change') {
                const changeBtn = document.getElementById('tab-change-btn');
                if (changeBtn) bootstrap.Tab.getOrCreateInstance(changeBtn).show();
            } else {
                const resetBtn = document.getElementById('tab-reset-btn');
                if (resetBtn) bootstrap.Tab.getOrCreateInstance(resetBtn).show();
            }
            modal.show();
        }

        @if($errors->changePassword->any())
            openPasswordModal('change');
        @elseif($errors->resetPassword->any())
            openPasswordModal('reset');
        @endif
    </script>
</body>
</html>

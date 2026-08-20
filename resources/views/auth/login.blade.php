<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SoulSoil Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F1EFE8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-1">
            <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" style="height: 100px; object-fit: contain;">
        </div>
        <p class="brand-subtitle">Sign in to manage your farms and investments.</p>

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
                <label for="password" class="form-label text-secondary small fw-bold">PASSWORD</label>
                <div class="password-field">
                    <input type="password" class="form-control pe-5" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                    <button type="button" class="password-toggle" id="password-toggle" aria-label="Show password">Show</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
        </form>

        <div class="mt-4 pt-3 border-top" style="border-top: 1px solid #e0ddd4 !important;">
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

    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            // Removed automatic submit so the user can review before clicking login
        }
        document.getElementById('password-toggle').addEventListener('click', function () {
            const password = document.getElementById('password');
            const visible = password.type === 'text';
            password.type = visible ? 'password' : 'text';
            this.textContent = visible ? 'Show' : 'Hide';
            this.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
        });
    </script>
</body>
</html>

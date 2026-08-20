<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SoulSoil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F1EFE8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .login-card {
            border: 1px solid #e0ddd4;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            background: white;
            width: 100%;
            max-width: 480px;
            padding: 2.5rem;
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
        .form-control, .form-select {
            border: 1px solid #e0ddd4;
            padding: 0.75rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5cc42c;
            box-shadow: 0 0 0 0.2rem rgba(92, 196, 44, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-1">
            <img src="{{ asset('images/logo.png') }}" alt="SoulSoil Logo" style="height: 100px; object-fit: contain;">
        </div>
        <p class="brand-subtitle">Create an account to join SoulSoil.</p>

        @if($errors->any())
        <div class="alert alert-danger p-2 mb-3 small">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label text-secondary small fw-bold">FULL NAME</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label text-secondary small fw-bold">PHONE NUMBER</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label text-secondary small fw-bold">ROLE</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" disabled selected>Select your role...</option>
                    <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>Farmer</option>
                    <option value="investor" {{ old('role') == 'investor' ? 'selected' : '' }}>Investor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-secondary small fw-bold">PASSWORD</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-secondary small fw-bold">CONFIRM PASSWORD</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Create Account</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #5cc42c; font-weight: 600;">Already have an account? Sign in</a>
        </div>
    </div>
</body>
</html>

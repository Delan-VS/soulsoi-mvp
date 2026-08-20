<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Onboarding - SoulSoil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <p class="text-muted mb-4">Please provide your details so we can verify your account and allow you to request farm investments.</p>

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
                <span class="text-secondary small fw-bold me-2">CURRENT STATUS:</span>
                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                @if($farmer->overall_status === 'rejected' && $farmer->admin_notes)
                    <div class="alert alert-danger mt-3">
                        <strong>Reason for Rejection:</strong> {{ $farmer->admin_notes }}
                    </div>
                @endif
            </div>

            <form action="{{ route('farmer.onboarding.submit') }}" method="POST">
                @csrf
                
                <h5 class="fw-bold mt-4 mb-3" style="color: #5cc42c;">Personal Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">DATE OF BIRTH</label>
                        <input type="date" class="form-control" name="dob" value="{{ old('dob', $farmer->dob?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">AADHAR NUMBER</label>
                        <input type="text" class="form-control" name="aadhar_number" value="{{ old('aadhar_number', $farmer->aadhar_number) }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">FULL ADDRESS</label>
                    <textarea class="form-control" name="address" rows="3" required>{{ old('address', $farmer->address) }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-secondary small fw-bold">VILLAGE</label>
                        <input type="text" class="form-control" name="village" value="{{ old('village', $farmer->village) }}" required>
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
                        <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name', $farmer->bank_name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">ACCOUNT HOLDER NAME</label>
                        <input type="text" class="form-control" name="account_holder_name" value="{{ old('account_holder_name', $farmer->account_holder_name) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-bold">ACCOUNT NUMBER</label>
                        <input type="text" class="form-control" name="account_number" value="{{ old('account_number', $farmer->account_number) }}" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label text-secondary small fw-bold">IFSC CODE</label>
                        <input type="text" class="form-control" name="ifsc_code" value="{{ old('ifsc_code', $farmer->ifsc_code) }}" required>
                    </div>
                </div>
                
                <hr class="mb-4 text-muted">
                <button type="submit" class="btn btn-primary w-100 py-2">Submit Details for Verification</button>
            </form>
        </div>
    </div>
</body>
</html>

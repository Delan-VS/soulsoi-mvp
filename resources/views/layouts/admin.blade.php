<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SoulSoil</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-blue: #5cc42c;
            --primary-light: rgba(92, 196, 44, 0.05);
            --success-green: #10B981;
            --success-light: rgba(16, 185, 129, 0.05);
            --warning-amber: #F59E0B;
            --warning-light: rgba(245, 158, 11, 0.05);
            --danger-red: #EF4444;
            --danger-light: rgba(239, 68, 68, 0.05);
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --bg-surface: #F8FAFC;
            --border-color: #E2E8F0;

            /* Override Bootstrap 5 CSS variables — kills ALL blue globally */
            --bs-primary: #5cc42c;
            --bs-primary-rgb: 92, 196, 44;
            --bs-link-color: #5cc42c;
            --bs-link-hover-color: #479920;
            --bs-link-color-rgb: 92, 196, 44;
        }

        /* Bootstrap pagination blue kill — hardcoded overrides */
        .page-link {
            color: #5cc42c !important;
            border-color: #dee2e6;
        }

        .page-link:hover {
            color: #479920 !important;
            background-color: rgba(92, 196, 44, 0.08) !important;
            border-color: #5cc42c !important;
        }

        .page-link:focus {
            box-shadow: 0 0 0 0.25rem rgba(92, 196, 44, 0.25) !important;
            color: #5cc42c !important;
        }

        .page-item.active .page-link {
            background-color: #5cc42c !important;
            border-color: #5cc42c !important;
            color: white !important;
        }

        .page-item.disabled .page-link {
            color: #94a3b8 !important;
        }

        body {
            color: var(--text-primary);
            background-color: var(--bg-surface);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Global Smaller Heading Font Sizes */
        h1, .h1 { font-size: 1.45rem !important; line-height: 1.3; }
        h2, .h2 { font-size: 1.3rem !important; line-height: 1.3; }
        h3, .h3 { font-size: 1.15rem !important; line-height: 1.35; }
        h4, .h4 { font-size: 1.05rem !important; line-height: 1.4; }
        h5, .h5 { font-size: 0.95rem !important; line-height: 1.4; }
        h6, .h6 { font-size: 0.85rem !important; line-height: 1.4; }

        .display-1 { font-size: 2.1rem !important; }
        .display-2 { font-size: 1.85rem !important; }
        .display-3 { font-size: 1.65rem !important; }
        .display-4 { font-size: 1.45rem !important; }
        .display-5 { font-size: 1.3rem !important; }
        .display-6 { font-size: 1.15rem !important; }

        .modal-title { font-size: 1.1rem !important; }
        .card-title { font-size: 1.05rem !important; }

        .sidebar {
            background: white;
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            padding: 2rem 1rem;
            position: sticky;
            top: 0;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.01);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .nav-link {
            color: var(--text-secondary) !important;
            padding: 0.8rem 1.2rem;
            margin: 0.35rem 0;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
            border-left: none;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 10px;
            color: var(--text-secondary);
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary-blue) !important;
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            color: var(--primary-blue) !important;
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-blue) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .sidebar .nav-link.active i {
            color: white !important;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text-primary) !important;
            font-size: 1.35rem;
        }

        /* Override Bootstrap Info colors as well */
        .text-info {
            color: var(--primary-blue) !important;
        }

        .bg-success {
            background-color: var(--primary-blue) !important;
        }

        .alert-info {
            background-color: var(--primary-light) !important;
            color: var(--primary-blue) !important;
            border-color: var(--primary-blue) !important;
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
        }

        .card-header h5 {
            font-weight: 600;
            color: var(--text-primary);
        }

        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #479920;
            border-color: #479920;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(92, 196, 44, 0.2);
        }

        .btn-success {
            background-color: var(--success-green);
            border-color: var(--success-green);
        }

        .btn-success:hover {
            background-color: #0d9488;
            border-color: #0d9488;
        }

        .btn-danger {
            background-color: var(--danger-red);
            border-color: var(--danger-red);
        }

        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
        }

        /* Green outline buttons - replaces Bootstrap default blue */
        .btn-outline-success,
        .btn-outline-primary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            background-color: transparent;
        }

        .btn-outline-success:hover,
        .btn-outline-primary:hover {
            color: white;
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        /* Progress bar green */
        .progress-bar {
            background-color: var(--primary-blue);
        }

        .bg-success {
            background-color: var(--primary-blue) !important;
        }

        /* Form control green focus */
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(92, 196, 44, 0.2);
        }

        /* Link colors */
        a:not(.btn):not(.nav-link):not(.list-group-item) {
            color: var(--primary-blue);
        }

        a:not(.btn):not(.nav-link):not(.list-group-item):hover {
            color: #479920;
        }

        .badge {
            border-radius: 6px;
            padding: 0.45em 0.75em;
            font-weight: 600;
        }

        .badge-pending {
            background-color: var(--warning-light);
            color: var(--warning-amber) !important;
            border: 1px solid rgba(245, 158, 11, 0.15);
        }

        .badge-approved {
            background-color: var(--success-light);
            color: var(--success-green) !important;
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        .badge-rejected {
            background-color: var(--danger-light);
            color: var(--danger-red) !important;
            border: 1px solid rgba(239, 68, 68, 0.15);
        }

        .verification-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 0.45em 0.65em;
            font-size: 0.85em;
            font-weight: 600;
        }

        .verification-badge.completed {
            background-color: var(--success-light);
            color: var(--success-green);
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        .verification-badge.pending {
            background-color: var(--warning-light);
            color: var(--warning-amber);
            border: 1px solid rgba(245, 158, 11, 0.15);
        }

        .stat-card {
            padding: 2rem 1.5rem;
            position: relative;
        }

        .stat-number {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background-color: var(--success-light);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--success-green);
        }

        .alert-danger {
            background-color: var(--danger-light);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--danger-red);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #F8FAFC;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: var(--bg-surface);
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .mobile-menu-toggle {
            display: none;
        }

        @media (max-width: 767.98px) {
            .app-shell {
                display: block;
            }

            .sidebar {
                position: fixed;
                z-index: 1050;
                top: 0;
                left: 0;
                width: min(290px, 85vw);
                height: 100vh;
                min-height: 100vh;
                padding: 1.5rem 1rem;
                transform: translateX(-105%);
                transition: transform .25s ease;
                overflow-y: auto;
            }

            .sidebar.is-open {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                position: fixed;
                z-index: 1040;
                inset: 0;
                background: rgba(15, 23, 42, .42);
                opacity: 0;
                visibility: hidden;
                transition: opacity .25s ease, visibility .25s ease;
            }

            .sidebar-backdrop.is-visible {
                opacity: 1;
                visibility: visible;
            }

            .main-panel {
                width: 100%;
            }

            .mobile-menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                padding: 0;
                border: 1px solid var(--border-color);
                background: #fff;
                color: var(--text-primary);
                border-radius: 10px;
            }

            .navbar {
                padding: .75rem 1rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .content-area {
                padding: 1rem !important;
            }

            .card-header,
            .card-body {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .table-responsive {
                border-radius: 12px;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0 app-shell">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar" id="app-sidebar" aria-label="Main navigation">
                <div>
                    <!-- Logo / Brand Header -->
                    <div class="px-3 mb-4 d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="SoulSoil"
                            style="height: 38px; width: 38px; object-fit: contain;">
                        <div>
                            <h5 class="mb-0 fw-bold"
                                style="color: #2C2C2A; font-family: 'Inter', sans-serif; font-size: 1.15rem; letter-spacing: 0.5px; line-height: 1.1;">
                                SOUL SOIL</h5>
                            @if(auth()->user()?->is_admin)
                                <small class="text-muted fw-semibold"
                                    style="font-size: 9px; letter-spacing: 1px; text-transform: uppercase; d-block;">Admin
                                    Panel</small>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="nav flex-column">
                        @if(auth()->user()?->is_admin)
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') && (!request('tab') || request('tab') === 'overview') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard', ['tab' => 'overview']) }}">
                                <i class="fas fa-chart-line me-2"></i> Dashboard
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.farmers.*') ? 'active' : '' }}"
                                href="{{ route('admin.farmers.index') }}">
                                <i class="fas fa-users me-2"></i> Farmer Verification
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.farms.*') ? 'active' : '' }}"
                                href="{{ route('admin.farms.index') }}">
                                <i class="fas fa-barn me-2"></i> Farm Verification
                            </a>
                            <a class="nav-link {{ request('tab') === 'investors' || request()->routeIs('admin.investors.*') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard', ['tab' => 'investors']) }}">
                                <i class="fas fa-handshake me-2"></i> Investors
                            </a>

                        @elseif(auth()->user()?->farmer)
                            <a class="nav-link active" href="{{ route('admin.dashboard') }}#dashboard" data-tab="dashboard">
                                <i class="fas fa-th-large me-2"></i> Dashboard
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#my-farms" data-tab="my-farms">
                                <i class="fas fa-seedling me-2"></i> My Farms
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#add-farm" data-tab="add-farm">
                                <i class="fas fa-plus-circle me-2"></i> Add New Farm
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#farm-updates" data-tab="farm-updates">
                                <i class="fas fa-bullhorn me-2"></i> Farm Updates
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#harvest-management" data-tab="harvest-management">
                                <i class="fas fa-wheat-awn me-2"></i> Harvest Management
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#sales-proof" data-tab="sales-proof">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Sales & Proof
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#settlements" data-tab="settlements">
                                <i class="fas fa-wallet me-2"></i> Settlements
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#portfolio" data-tab="portfolio">
                                <i class="fas fa-briefcase me-2"></i> Portfolio
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#profile" data-tab="profile">
                                <i class="fas fa-user-circle me-2"></i> Profile
                            </a>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}#settings" data-tab="settings">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        @else
                            <a class="nav-link {{ !request('tab') || request('tab') === 'overview' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#overview" data-tab="overview">
                                <i class="fas fa-th-large me-2"></i> Dashboard
                            </a>
                            <a class="nav-link {{ request('tab') === 'investments' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#investments" data-tab="investments">
                                <i class="fas fa-hand-holding-usd me-2"></i> My Farms
                            </a>
                            <a class="nav-link {{ request('tab') === 'invest' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#invest" data-tab="invest">
                                <i class="fas fa-store me-2"></i> Browse Farms
                            </a>
                            <a class="nav-link {{ request('tab') === 'analysis' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#analysis" data-tab="analysis">
                                <i class="fas fa-chart-pie me-2"></i> Portfolio
                            </a>
                            <a class="nav-link {{ request('tab') === 'profile' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#profile" data-tab="profile">
                                <i class="fas fa-user-circle me-2"></i> Profile
                            </a>
                            <a class="nav-link {{ request('tab') === 'settings' ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}#settings" data-tab="settings">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Bottom User Profile Section -->
                <div class="pt-4 border-top" style="border-top: 1px solid var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-2 px-2">
                        <div class="d-flex align-items-center justify-content-center fw-bold bg-primary text-white rounded-circle shadow-sm"
                            style="width: 40px; height: 40px; font-size: 14px; background-color: var(--primary-blue) !important; flex-shrink: 0;">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'G', 0, 2)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0 fw-bold text-truncate" style="font-size: 14px; color: var(--text-primary);">
                                {{ auth()->user()?->name ?? 'Guest' }}
                            </h6>
                            <small class="text-muted d-block text-truncate"
                                style="font-size: 11px;">{{ auth()->user()?->email ?? 'Not logged in' }}</small>
                        </div>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <!-- Main Content -->
            <div class="sidebar-backdrop d-md-none" id="sidebar-backdrop"></div>

            <div class="col-md-10 main-panel">
                @empty($hide_navbar)
                    <nav class="navbar navbar-light">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center gap-2">
                                <button class="mobile-menu-toggle" id="mobile-menu-toggle" type="button"
                                    aria-label="Open navigation" aria-controls="app-sidebar" aria-expanded="false">
                                    <i class="fas fa-bars" aria-hidden="true"></i>
                                </button>
                                <span class="navbar-brand">@yield('page-title', 'Dashboard')</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button id="fullscreen-toggle"
                                    class="btn btn-light rounded-circle p-2 me-2 d-none d-md-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;" title="Toggle Fullscreen">
                                    <i class="fas fa-expand text-muted"></i>
                                </button>
                                <span class="fw-semibold text-secondary d-none d-md-inline"
                                    style="font-size: 14px;">{{ auth()->user()?->name ?? 'Guest' }}</span>
                                <div class="d-flex align-items-center justify-content-center fw-bold bg-primary text-white rounded-circle shadow-sm"
                                    style="width: 40px; height: 40px; font-size: 14px; background-color: var(--primary-blue) !important; border: 2px solid white;">
                                    {{ strtoupper(substr(auth()->user()?->name ?? 'GU', 0, 2)) }}
                                </div>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-danger ms-2" style="font-size: 18px;" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                @endempty

                <div class="p-4 content-area">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Validation Errors!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Keep the navigation usable on phones without changing desktop behaviour.
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('app-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function closeMobileMenu() {
            sidebar?.classList.remove('is-open');
            sidebarBackdrop?.classList.remove('is-visible');
            menuToggle?.setAttribute('aria-expanded', 'false');
        }

        menuToggle?.addEventListener('click', () => {
            const opening = !sidebar.classList.contains('is-open');
            sidebar.classList.toggle('is-open', opening);
            sidebarBackdrop.classList.toggle('is-visible', opening);
            menuToggle.setAttribute('aria-expanded', String(opening));
        });
        sidebarBackdrop?.addEventListener('click', closeMobileMenu);
        sidebar?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMobileMenu));
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) closeMobileMenu();
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                if (bsAlert) bsAlert.close();
            }, 5000);
        });

        // Client-side SPA tab switching for Farmers, Admins, and Investors
        document.addEventListener('DOMContentLoaded', function () {
            const tabLinks = document.querySelectorAll('.sidebar .nav-link[data-tab]');
            const tabContents = document.querySelectorAll('.tab-content .tab-pane, .farmer-tab-content');

            function switchTab(tabId) {
                if (!tabId) return;

                // Hide all contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('active', 'show');
                });

                // Show selected content
                const targetContent = document.getElementById('tab-' + tabId) || document.getElementById(tabId);
                if (targetContent) {
                    targetContent.style.display = 'block';
                    setTimeout(() => targetContent.classList.add('active', 'show'), 30);
                }

                // Save active tab in localStorage so navigation back restores current module
                localStorage.setItem('active_soulsoil_tab', tabId);

                // Update active link classes
                tabLinks.forEach(link => {
                    if (link.getAttribute('data-tab') === tabId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });

                // Update page title dynamically
                const pageTitle = document.querySelector('.navbar-brand');
                if (pageTitle) {
                    const link = document.querySelector('.sidebar .nav-link[data-tab="' + tabId + '"]');
                    if (link) {
                        let text = "";
                        for (let child of link.childNodes) {
                            if (child.nodeType === Node.TEXT_NODE) {
                                text += child.textContent;
                            }
                        }
                        text = text.trim();
                        if (text) {
                            pageTitle.textContent = text;
                        }
                    }
                }

                // Trigger a resize event to fix Chart.js canvases that were rendered while hidden
                window.dispatchEvent(new Event('resize'));
            }

            // Only run farmer SPA tab switching if on the main dashboard route
            if (window.location.pathname === '{{ route('admin.dashboard', [], false) }}' || window.location.pathname === '/admin' || window.location.pathname === '/admin/') {
                tabLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        const tabId = this.getAttribute('data-tab');
                        e.preventDefault();
                        switchTab(tabId);
                        window.location.hash = tabId;
                    });
                });

                // Priority: 1. URL Hash, 2. URL Query Param (?tab=), 3. localStorage, 4. Default ('overview' or 'dashboard')
                const urlParams = new URLSearchParams(window.location.search);
                const queryTab = urlParams.get('tab');
                const savedTab = localStorage.getItem('active_soulsoil_tab');

                let initialTab = document.getElementById('tab-dashboard') ? 'dashboard' : 'overview';
                if (window.location.hash) {
                    const hashTab = window.location.hash.substring(1);
                    if (document.getElementById('tab-' + hashTab) || document.getElementById(hashTab)) {
                        initialTab = hashTab;
                    }
                } else if (queryTab && (document.getElementById('tab-' + queryTab) || document.getElementById(queryTab))) {
                    initialTab = queryTab;
                } else if (savedTab && (document.getElementById('tab-' + savedTab) || document.getElementById(savedTab))) {
                    initialTab = savedTab;
                }

                switchTab(initialTab);

                // Listen for hash changes
                window.addEventListener('hashchange', function () {
                    const hashTab = window.location.hash.substring(1);
                    if (document.getElementById('tab-' + hashTab) || document.getElementById(hashTab)) {
                        switchTab(hashTab);
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
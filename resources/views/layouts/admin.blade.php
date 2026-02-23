<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Salon Cantik Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-spa"></i>
                <span>Salon <strong>Admin</strong></span>
            </div>
            <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> <span>Pemesanan</span>
                @php $pending = \App\Models\Booking::where('status','pending')->count(); @endphp
                @if($pending > 0)
                    <span class="badge-count">{{ $pending }}</span>
                @endif
            </a>
            <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-spa"></i> <span>Katalog Jasa</span>
            </a>
            <a href="{{ route('admin.export.index') }}" class="nav-item {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
                <i class="fas fa-file-excel"></i> <span>Export Data</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> <span>Pengaturan</span>
            </a>
            <div class="nav-divider"></div>
            <a href="{{ route('home') }}" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> <span>Lihat Website</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item nav-logout">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="admin-main" id="adminMain">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger-admin" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">@yield('title', 'Dashboard')</div>
            </div>
            <div class="topbar-right">
                @php $bookingStatus = \App\Models\Setting::get('booking_open','1') == '1'; @endphp
                <div class="topbar-booking-status">
                    <span class="status-dot {{ $bookingStatus ? 'status-open' : 'status-closed' }}"></span>
                    {{ $bookingStatus ? 'Booking Buka' : 'Booking Tutup' }}
                </div>
                <div class="topbar-admin">
                    <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
                    <span>{{ session('admin_name', 'Admin') }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success" id="alertSuccess">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" id="alertError">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>

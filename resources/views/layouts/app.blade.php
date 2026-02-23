<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Salon Cantik - Tampil Cantik, Percaya Diri Setiap Hari')">
    <title>@yield('title', 'Salon Cantik') | Salon Professiona</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <span class="brand-icon"><i class="fas fa-spa"></i></span>
                <span class="brand-text">Salon <strong>Cantik</strong></span>
            </a>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}#home" class="nav-link">Beranda</a></li>
                <li><a href="{{ route('home') }}#about" class="nav-link">Tentang</a></li>
                <li><a href="{{ route('home') }}#services" class="nav-link">Jasa</a></li>
                <li><a href="{{ route('home') }}#location" class="nav-link">Lokasi</a></li>
                <li>
                    @php $bookingOpen = \App\Models\Setting::get('booking_open','1') == '1'; @endphp
                    @if($bookingOpen)
                        <a href="{{ route('booking.create') }}" class="btn-booking-nav">
                            <i class="fas fa-calendar-check"></i> Booking
                        </a>
                    @else
                        <span class="btn-booking-nav btn-booking-closed" title="Pemesanan sedang ditutup">
                            <i class="fas fa-calendar-times"></i> Tutup
                        </span>
                    @endif
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('booking_closed'))
            <div class="alert-banner alert-danger" id="bookingClosedAlert">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('booking_closed') }}
                <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
            </div>
        @endif
        @if(session('success'))
            <div class="alert-banner alert-success" id="successAlert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <i class="fas fa-spa"></i> Salon Cantik
                    </div>
                    <p>Tempat perawatan kecantikan profesional untuk tampil percaya diri setiap hari.</p>
                    <div class="footer-socials">
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-info">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('home') }}#about">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#services">Katalog Jasa</a></li>
                        <li><a href="{{ route('home') }}#location">Lokasi</a></li>
                        <li><a href="{{ route('booking.create') }}">Booking Sekarang</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> {{ \App\Models\Setting::get('salon_phone') }}</li>
                        <li><i class="fas fa-envelope"></i> {{ \App\Models\Setting::get('salon_email') }}</li>
                        <li><i class="fas fa-map-marker-alt"></i> {{ \App\Models\Setting::get('salon_address') }}</li>
                        <li><i class="fas fa-clock"></i> {{ \App\Models\Setting::get('salon_hours') }}</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Salon Cantik. All rights reserved. | <a href="{{ route('admin.login') }}">Admin</a></p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>

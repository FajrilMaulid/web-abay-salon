@extends('layouts.app')

@section('title', $salonName)
@section('meta_description', $salonTagline)

@section('content')

<!-- ─── HERO ──────────────────────────────────────────── -->
<section class="hero" id="home">
    <div class="hero-particles" id="particles"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="hero-badge animate-fade-in">
            @if($bookingOpen)
                <span class="status-indicator status-open">
                    <span class="pulse-dot"></span> Pemesanan Dibuka
                </span>
            @else
                <span class="status-indicator status-closed">
                    <i class="fas fa-ban"></i> Pemesanan Ditutup Hari Ini
                </span>
            @endif
        </div>
        <h1 class="hero-title animate-slide-up">
            Tampil <span class="text-gradient">Cantik</span><br>
            Percaya Diri <span class="text-gradient">Setiap Hari</span>
        </h1>
        <p class="hero-subtitle animate-slide-up delay-1">
            Salon kecantikan profesional dengan layanan terbaik untuk merawat dan memperindah penampilan Anda.
        </p>
        <div class="hero-actions animate-slide-up delay-2">
            @if($bookingOpen)
                <a href="{{ route('booking.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-check"></i> Booking Sekarang
                </a>
                <a href="#services" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-spa"></i> Lihat Jasa
                </a>
            @else
                <div class="booking-closed-hero">
                    <button class="btn btn-disabled btn-lg" disabled id="heroBookingBtn"
                        onclick="showClosedNotification()">
                        <i class="fas fa-calendar-times"></i> Booking Tidak Tersedia
                    </button>
                    <div class="closed-info">
                        <i class="fas fa-info-circle"></i>
                        Jadwal hari ini telah penuh. Silakan hubungi kami untuk booking di hari lain.
                    </div>
                </div>
                <a href="#services" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-spa"></i> Lihat Jasa
                </a>
            @endif
        </div>
        <div class="hero-stats animate-fade-in delay-3">
            <div class="stat-item">
                <strong>500+</strong>
                <span>Pelanggan Puas</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <strong>6+</strong>
                <span>Jenis Layanan</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <strong>5★</strong>
                <span>Rating</span>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <div class="scroll-arrow">
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>
</section>

<!-- Notifikasi Booking Tutup Modal -->
@if(!$bookingOpen)
<div class="modal-overlay" id="closedModal" style="display:none">
    <div class="modal-box">
        <div class="modal-icon">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3>Pemesanan Ditutup</h3>
        <p>Maaf, jadwal pemesanan untuk hari ini telah penuh. Owner/admin sedang menutup sementara sistem pemesanan.</p>
        <p class="modal-contact">Hubungi kami langsung di <strong>{{ $salonPhone }}</strong> untuk informasi lebih lanjut.</p>
        <button onclick="document.getElementById('closedModal').style.display='none'" class="btn btn-primary">Mengerti</button>
    </div>
</div>
@endif

<!-- ─── ABOUT ─────────────────────────────────────────── -->
<section class="section section-about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-wrap reveal">
                <div class="about-image-main">
                    <img src="{{ asset('images/salon-about.jpg') }}" alt="Salon Interior" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?w=600&q=80'">
                </div>
                <div class="about-badge-float">
                    <i class="fas fa-star"></i>
                    <div>
                        <strong>5 Bintang</strong>
                        <small>Rating Terbaik</small>
                    </div>
                </div>
                <div class="about-exp-float">
                    <strong>10+</strong>
                    <small>Tahun Pengalaman</small>
                </div>
            </div>
            <div class="about-content reveal">
                <div class="section-tag">Tentang Kami</div>
                <h2 class="section-title">Kenapa Pilih <span class="text-gradient">Salon Cantik?</span></h2>
                <p class="about-desc">
                    Kami adalah salon kecantikan profesional yang berdedikasi untuk memberikan pengalaman perawatan terbaik.
                    Dengan tenaga ahli berpengalaman dan produk berkualitas, kami hadir untuk membuat Anda tampil memesona.
                </p>
                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                        <div>
                            <h4>Teknisi Profesional</h4>
                            <p>Tim ahli bersertifikat dengan pengalaman bertahun-tahun.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                        <div>
                            <h4>Produk Premium</h4>
                            <p>Menggunakan produk terpilih yang aman dan berkualitas tinggi.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h4>Higienis & Aman</h4>
                            <p>Standar kebersihan ketat untuk kenyamanan dan keamanan Anda.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h4>Tepat Waktu</h4>
                            <p>Sistem booking online untuk menghindari antrian panjang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── SERVICES ─────────────────────────────────────── -->
<section class="section section-services" id="services">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag">Katalog Jasa</div>
            <h2 class="section-title">Layanan <span class="text-gradient">Unggulan</span> Kami</h2>
            <p class="section-desc">Temukan berbagai layanan kecantikan profesional yang kami tawarkan untuk merawat dan memperindah penampilan Anda.</p>
        </div>
        <div class="services-grid">
            @forelse($services as $index => $service)
            <div class="service-card reveal" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="service-img-wrap">
                    @if($service->image)
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                    @else
                        <div class="service-img-placeholder">
                            <i class="fas fa-spa"></i>
                        </div>
                    @endif
                    <div class="service-badge">{{ $service->duration }} menit</div>
                </div>
                <div class="service-body">
                    <h3 class="service-name">{{ $service->name }}</h3>
                    <p class="service-desc">{{ $service->description }}</p>
                    <div class="service-footer">
                        <span class="service-price">{{ $service->formatted_price }}</span>
                        @if($bookingOpen)
                            <a href="{{ route('booking.create') }}?service={{ $service->id }}" class="btn btn-sm btn-primary">
                                Booking <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <span class="badge-closed-sm">Tutup</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-spa"></i>
                <p>Belum ada jasa tersedia.</p>
            </div>
            @endforelse
        </div>
        @if($bookingOpen)
            <div class="services-cta reveal">
                <a href="{{ route('booking.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-check"></i> Booking Sekarang
                </a>
            </div>
        @endif
    </div>
</section>

<!-- ─── TESTIMONIALS ─────────────────────────────────── -->
<section class="section section-testimonials">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag">Testimoni</div>
            <h2 class="section-title">Apa Kata <span class="text-gradient">Pelanggan Kami?</span></h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card reveal">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Pelayanannya sangat memuaskan! Hasilnya melebihi ekspektasi saya. Pasti akan datang lagi!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div>
                        <strong>Sari Dewi</strong>
                        <small>Pelanggan Setia</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Smoothing rambut saya hasilnya luar biasa! Teknisinya ramah dan profesional."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">R</div>
                    <div>
                        <strong>Rina Puspita</strong>
                        <small>Member Premium</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Sistem booking online sangat memudahkan. Tidak perlu antri lama, langsung dilayani!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">A</div>
                    <div>
                        <strong>Anisa Rahma</strong>
                        <small>Pelanggan Baru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── LOCATION ─────────────────────────────────────── -->
<section class="section section-location" id="location">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag">Lokasi Kami</div>
            <h2 class="section-title">Temukan Kami di <span class="text-gradient">Sini</span></h2>
        </div>
        <div class="location-grid">
            <div class="location-info reveal">
                <div class="location-detail">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Alamat</h4>
                        <p>{{ $salonAddress }}</p>
                    </div>
                </div>
                <div class="location-detail">
                    <div class="location-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Telepon / WhatsApp</h4>
                        <p>{{ $salonPhone }}</p>
                    </div>
                </div>
                <div class="location-detail">
                    <div class="location-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4>Jam Operasional</h4>
                        <p>{{ $salonHours }}</p>
                    </div>
                </div>
                <div class="location-detail">
                    <div class="location-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p>{{ \App\Models\Setting::get('salon_email') }}</p>
                    </div>
                </div>
                @if($bookingOpen)
                    <a href="{{ route('booking.create') }}" class="btn btn-primary btn-full mt-20">
                        <i class="fas fa-calendar-check"></i> Booking Sekarang
                    </a>
                @else
                    <div class="closed-location-note">
                        <i class="fas fa-exclamation-circle"></i>
                        Pemesanan online sedang ditutup. Hubungi kami via telepon/WA.
                    </div>
                @endif
            </div>
            <div class="location-map reveal">
                <div class="map-container">
                    @if($mapsEmbed)
                        <iframe
                            src="{{ $mapsEmbed }}"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Salon Cantik">
                        </iframe>
                    @else
                        <div class="map-placeholder">
                            <i class="fas fa-map"></i>
                            <p>Peta belum dikonfigurasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@if($bookingOpen)
<section class="section-cta">
    <div class="container">
        <div class="cta-content reveal">
            <h2>Siap Tampil <span class="text-gradient">Lebih Cantik?</span></h2>
            <p>Booking sekarang dan dapatkan perawatan terbaik dari tim profesional kami.</p>
            <a href="{{ route('booking.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-calendar-check"></i> Booking Sekarang
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
function showClosedNotification() {
    document.getElementById('closedModal').style.display = 'flex';
}
</script>
@endpush

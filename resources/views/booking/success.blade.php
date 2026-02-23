@extends('layouts.app')
@section('title', 'Booking Berhasil!')

@section('content')
<section class="success-page">
    <div class="container">
        <div class="success-card">
            <div class="success-icon-wrap">
                <div class="success-circle">
                    <i class="fas fa-check"></i>
                </div>
                <div class="success-ripple r1"></div>
                <div class="success-ripple r2"></div>
            </div>
            <h1 class="success-title">Booking Berhasil! 🎉</h1>
            <p class="success-subtitle">Terima kasih <strong>{{ $booking->customer_name }}</strong>! Booking Anda telah kami terima dan sedang dalam proses konfirmasi.</p>

            <div class="booking-detail-card">
                <div class="booking-code-badge">
                    <span>Kode Booking</span>
                    <strong>{{ $booking->booking_code }}</strong>
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <i class="fas fa-spa"></i>
                        <div>
                            <small>Jasa</small>
                            <strong>{{ $booking->service->name }}</strong>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <small>Tanggal</small>
                            <strong>{{ $booking->booking_date->format('d F Y') }}</strong>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <small>Jam</small>
                            <strong>{{ $booking->booking_time }}</strong>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <small>Telepon</small>
                            <strong>{{ $booking->phone }}</strong>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-credit-card"></i>
                        <div>
                            <small>Pembayaran</small>
                            <strong>{{ strtoupper($booking->payment_method) }}</strong>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <small>Total</small>
                            <strong class="text-gradient">{{ $booking->formatted_total }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="success-notes">
                <i class="fas fa-info-circle"></i>
                <p>Simpan kode booking Anda. Kami akan menghubungi Anda di <strong>{{ $booking->phone }}</strong> untuk konfirmasi jadwal.</p>
            </div>

            <div class="success-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('booking.create') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i> Booking Lagi
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

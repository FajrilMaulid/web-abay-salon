@extends('layouts.admin')
@section('title', 'Pengaturan Salon')

@section('content')
<div class="page-header">
    <h1 class="page-title">Pengaturan Salon</h1>
</div>

<!-- Booking Toggle Card -->
<div class="settings-toggle-card">
    <div class="settings-toggle-info">
        <h3><i class="fas fa-calendar-check"></i> Status Pemesanan Online</h3>
        <p>Aktifkan atau nonaktifkan fitur pemesanan online. Jika dinonaktifkan, tombol booking di halaman utama akan disabled dan menampilkan notifikasi.</p>
    </div>
    <div class="settings-toggle-control">
        <div class="toggle-status {{ ($settings['booking_open'] ?? '1') == '1' ? 'open' : 'closed' }}" id="bookingStatusBadge">
            {{ ($settings['booking_open'] ?? '1') == '1' ? '🟢 Pemesanan BUKA' : '🔴 Pemesanan TUTUP' }}
        </div>
        <label class="toggle-switch lg">
            <input type="checkbox" id="bookingToggleSettings"
                {{ ($settings['booking_open'] ?? '1') == '1' ? 'checked' : '' }}>
            <span class="toggle-slider"></span>
        </label>
    </div>
</div>

<!-- Salon Info Form -->
<div class="form-card mt-24">
    <h3 class="form-card-title"><i class="fas fa-spa"></i> Informasi Salon</h3>
    <form action="{{ route('admin.settings.update') }}" method="POST" class="admin-form">
        @csrf
        <div class="form-grid-2">
            <div class="form-group">
                <label for="salon_name">Nama Salon *</label>
                <div class="input-wrap"><i class="fas fa-spa input-icon"></i>
                    <input type="text" name="salon_name" id="salon_name" class="form-control"
                        value="{{ $settings['salon_name'] ?? '' }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="salon_phone">Nomor Telepon</label>
                <div class="input-wrap"><i class="fas fa-phone input-icon"></i>
                    <input type="text" name="salon_phone" id="salon_phone" class="form-control"
                        value="{{ $settings['salon_phone'] ?? '' }}">
                </div>
            </div>
            <div class="form-group form-full">
                <label for="salon_tagline">Tagline</label>
                <div class="input-wrap"><i class="fas fa-quote-right input-icon"></i>
                    <input type="text" name="salon_tagline" id="salon_tagline" class="form-control"
                        value="{{ $settings['salon_tagline'] ?? '' }}">
                </div>
            </div>
            <div class="form-group">
                <label for="salon_email">Email</label>
                <div class="input-wrap"><i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="salon_email" id="salon_email" class="form-control"
                        value="{{ $settings['salon_email'] ?? '' }}">
                </div>
            </div>
            <div class="form-group">
                <label for="salon_hours">Jam Operasional</label>
                <div class="input-wrap"><i class="fas fa-clock input-icon"></i>
                    <input type="text" name="salon_hours" id="salon_hours" class="form-control"
                        value="{{ $settings['salon_hours'] ?? '' }}" placeholder="Senin-Sabtu: 09.00-20.00">
                </div>
            </div>
            <div class="form-group form-full">
                <label for="salon_address">Alamat</label>
                <textarea name="salon_address" id="salon_address" class="form-control" rows="2">{{ $settings['salon_address'] ?? '' }}</textarea>
            </div>
            <div class="form-group form-full">
                <label for="maps_embed">Google Maps Embed URL</label>
                <div class="input-wrap"><i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="url" name="maps_embed" id="maps_embed" class="form-control"
                        value="{{ $settings['maps_embed'] ?? '' }}" placeholder="https://www.google.com/maps/embed?...">
                </div>
                <small class="form-hint">Dapatkan URL ini dari Google Maps → Share → Embed a map → Copy URL src="..."</small>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('bookingToggleSettings').addEventListener('change', function() {
    const badge = document.getElementById('bookingStatusBadge');
    fetch('{{ route("admin.settings.toggleBooking") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    }).then(r => r.json()).then(data => {
        if (data.booking_open) {
            badge.textContent = '🟢 Pemesanan BUKA';
            badge.className = 'toggle-status open';
        } else {
            badge.textContent = '🔴 Pemesanan TUTUP';
            badge.className = 'toggle-status closed';
        }
        showAdminToast(data.message, data.booking_open ? 'success' : 'warning');
    });
});
</script>
@endpush

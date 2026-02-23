@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div class="page-actions">
        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Booking Manual
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card stat-blue">
        <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
        <div class="stat-info">
            <span class="stat-label">Booking Hari Ini</span>
            <strong class="stat-value">{{ $todayBookings }}</strong>
        </div>
    </div>
    <div class="stat-card stat-purple">
        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-info">
            <span class="stat-label">Booking Bulan Ini</span>
            <strong class="stat-value">{{ $monthBookings }}</strong>
        </div>
    </div>
    <div class="stat-card stat-green">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pendapatan Hari Ini</span>
            <strong class="stat-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</strong>
        </div>
    </div>
    <div class="stat-card stat-rose">
        <div class="stat-icon"><i class="fas fa-coins"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pendapatan Bulan Ini</span>
            <strong class="stat-value">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</strong>
        </div>
    </div>
    <div class="stat-card stat-yellow">
        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pending Konfirmasi</span>
            <strong class="stat-value">{{ $pendingCount }}</strong>
        </div>
    </div>
    <div class="stat-card stat-toggle">
        <div class="stat-icon"><i class="fas fa-toggle-{{ $bookingOpen ? 'on' : 'off' }}"></i></div>
        <div class="stat-info">
            <span class="stat-label">Status Pemesanan</span>
            <div class="toggle-wrap">
                <label class="toggle-switch">
                    <input type="checkbox" id="bookingToggle" {{ $bookingOpen ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label" id="toggleLabel">{{ $bookingOpen ? 'Buka' : 'Tutup' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-chart-line"></i> Booking 7 Hari Terakhir</h3>
        </div>
        <div class="chart-body">
            <canvas id="bookingChart" height="280"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-chart-bar"></i> Pendapatan 6 Bulan Terakhir</h3>
        </div>
        <div class="chart-body">
            <canvas id="revenueChart" height="280"></canvas>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-list"></i> Booking Terbaru</h3>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Jasa</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td><span class="code-badge">{{ $booking->booking_code }}</span></td>
                    <td>
                        <div class="customer-cell">
                            <div class="customer-avatar">{{ substr($booking->customer_name,0,1) }}</div>
                            <div>
                                <strong>{{ $booking->customer_name }}</strong>
                                <small>{{ $booking->phone }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $booking->service->name ?? '-' }}</td>
                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                    <td>{{ $booking->booking_time }}</td>
                    <td>{{ $booking->formatted_total }}</td>
                    <td>
                        <span class="status-badge status-{{ $booking->status_color }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Booking Chart
const bookingCtx = document.getElementById('bookingChart').getContext('2d');
const bookingGradient = bookingCtx.createLinearGradient(0, 0, 0, 280);
bookingGradient.addColorStop(0, 'rgba(233, 30, 99, 0.4)');
bookingGradient.addColorStop(1, 'rgba(233, 30, 99, 0.01)');

new Chart(bookingCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartDays->values()) !!},
        datasets: [{
            label: 'Jumlah Booking',
            data: {!! json_encode($chartCounts->values()) !!},
            borderColor: '#E91E63',
            backgroundColor: bookingGradient,
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#E91E63',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, color: '#94a3b8' },
                grid: { color: 'rgba(148,163,184,0.1)' }
            },
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
        }
    }
});

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 280);
revenueGradient.addColorStop(0, 'rgba(139, 92, 246, 0.8)');
revenueGradient.addColorStop(1, 'rgba(139, 92, 246, 0.2)');

new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartMonths->values()) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($chartRevenue->values()) !!},
            backgroundColor: revenueGradient,
            borderColor: '#8B5CF6',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#94a3b8',
                    callback: v => 'Rp ' + v.toLocaleString('id-ID')
                },
                grid: { color: 'rgba(148,163,184,0.1)' }
            },
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
        }
    }
});

// Toggle Booking
document.getElementById('bookingToggle').addEventListener('change', function() {
    const label = document.getElementById('toggleLabel');
    fetch('{{ route("admin.settings.toggleBooking") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({})
    }).then(r => r.json()).then(data => {
        label.textContent = data.booking_open ? 'Buka' : 'Tutup';
        showToast(data.message, data.booking_open ? 'success' : 'warning');
    });
});

function showToast(msg, type) {
    const t = document.createElement('div');
    t.className = 'toast toast-' + type;
    t.innerHTML = '<i class="fas fa-info-circle"></i> ' + msg;
    document.body.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
}
</script>
@endpush

@extends('layouts.admin')
@section('title', 'Manajemen Pemesanan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Manajemen Pemesanan</h1>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Manual
    </a>
</div>

<!-- Filter -->
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="filter-form">
        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            @foreach(['pending','confirmed','done','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <input type="date" name="date" class="form-control form-control-sm"
            value="{{ request('date') }}" onchange="this.form.submit()">
        @if(request()->hasAny(['status','date']))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline">Reset</a>
        @endif
    </form>
    <span class="filter-count">{{ $bookings->count() }} booking ditemukan</span>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Jasa</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Bayar</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="booking-row" data-id="{{ $booking->id }}">
                    <td>
                        <span class="code-badge">{{ $booking->booking_code }}</span>
                        @if($booking->is_manual)
                            <span class="badge-manual" title="Dibuat admin">Admin</span>
                        @endif
                    </td>
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
                    <td><span class="payment-badge pay-{{ $booking->payment_method }}">{{ strtoupper($booking->payment_method) }}</span></td>
                    <td>{{ $booking->formatted_total }}</td>
                    <td>
                        <select class="status-select status-{{ $booking->status_color }}"
                            data-id="{{ $booking->id }}"
                            onchange="updateStatus({{ $booking->id }}, this.value, this)">
                            @foreach(['pending','confirmed','done','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $booking->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                            onsubmit="return confirm('Hapus booking ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="empty-table">
                        <i class="fas fa-calendar-times"></i>
                        <p>Belum ada data booking.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(id, status, selectEl) {
    fetch(`/admin/bookings/${id}/status`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ status })
    }).then(r => r.json()).then(data => {
        if (data.success) {
            selectEl.className = 'status-select status-' + getStatusColor(status);
            showAdminToast('Status berhasil diperbarui!', 'success');
        }
    }).catch(() => showAdminToast('Gagal memperbarui status.', 'error'));
}

function getStatusColor(status) {
    const map = { pending: 'warning', confirmed: 'info', done: 'success', cancelled: 'danger' };
    return map[status] || 'secondary';
}
</script>
@endpush

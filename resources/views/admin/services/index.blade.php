@extends('layouts.admin')
@section('title', 'Katalog Jasa')

@section('content')
<div class="page-header">
    <h1 class="page-title">Katalog Jasa</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jasa
    </a>
</div>

<div class="services-admin-grid">
    @forelse($services as $service)
    <div class="service-admin-card {{ !$service->active ? 'inactive' : '' }}">
        <div class="service-admin-img">
            @if($service->image)
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
            @else
                <div class="img-placeholder"><i class="fas fa-spa"></i></div>
            @endif
            <div class="service-status-toggle">
                <label class="toggle-switch sm">
                    <input type="checkbox" {{ $service->active ? 'checked' : '' }}
                        onchange="toggleService({{ $service->id }}, this)">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="service-admin-body">
            <h4>{{ $service->name }}</h4>
            <p>{{ Str::limit($service->description, 80) }}</p>
            <div class="service-admin-meta">
                <span class="price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                <span class="duration"><i class="fas fa-clock"></i> {{ $service->duration }} mnt</span>
            </div>
        </div>
        <div class="service-admin-actions">
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                onsubmit="return confirm('Hapus jasa ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-state full-width">
        <i class="fas fa-spa"></i>
        <p>Belum ada jasa. <a href="{{ route('admin.services.create') }}">Tambah jasa pertama</a></p>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
function toggleService(id, checkbox) {
    fetch(`/admin/services/${id}/toggle`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
    }).then(r => r.json()).then(data => {
        showAdminToast(data.message, 'success');
        checkbox.closest('.service-admin-card').classList.toggle('inactive', !data.active);
    }).catch(() => { checkbox.checked = !checkbox.checked; showAdminToast('Gagal mengubah status.', 'error'); });
}
</script>
@endpush

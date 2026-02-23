@extends('layouts.admin')
@section('title', 'Buat Booking Manual')

@section('content')
<div class="page-header">
    <h1 class="page-title">Buat Booking Manual</h1>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.bookings.store') }}" method="POST" class="admin-form">
        @csrf
        <div class="form-grid-2">
            <div class="form-group">
                <label for="customer_name">Nama Pelanggan *</label>
                <div class="input-wrap"><i class="fas fa-user input-icon"></i>
                    <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                        value="{{ old('customer_name') }}" placeholder="Nama lengkap" required>
                </div>
                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon *</label>
                <div class="input-wrap"><i class="fas fa-phone input-icon"></i>
                    <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                </div>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="service_id">Jasa *</label>
                <div class="input-wrap"><i class="fas fa-spa input-icon"></i>
                    <select name="service_id" id="service_id" class="form-control @error('service_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jasa --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="booking_date">Tanggal Booking *</label>
                <div class="input-wrap"><i class="fas fa-calendar input-icon"></i>
                    <input type="date" name="booking_date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror"
                        value="{{ old('booking_date', date('Y-m-d')) }}" required>
                </div>
                @error('booking_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="booking_time">Jam Booking *</label>
                <div class="input-wrap"><i class="fas fa-clock input-icon"></i>
                    <input type="time" name="booking_time" id="booking_time" class="form-control @error('booking_time') is-invalid @enderror"
                        value="{{ old('booking_time', '09:00') }}" required>
                </div>
                @error('booking_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="payment_method">Metode Pembayaran *</label>
                <div class="input-wrap"><i class="fas fa-credit-card input-icon"></i>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="cash" {{ old('payment_method','cash') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <div class="input-wrap"><i class="fas fa-tag input-icon"></i>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ old('status','pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-full">
                <label for="notes">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"
                    placeholder="Catatan tambahan dari admin...">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Booking
            </button>
        </div>
    </form>
</div>
@endsection

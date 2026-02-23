@extends('layouts.app')
@section('title', 'Booking Online')
@section('meta_description', 'Form booking online Salon Cantik - mudah, cepat, dan tepercaya.')

@section('content')
<section class="booking-page">
    <div class="container">
        <div class="booking-header reveal">
            <div class="section-tag">Reservasi Online</div>
            <h1 class="section-title">Buat <span class="text-gradient">Booking</span> Anda</h1>
            <p>Isi form di bawah ini untuk melakukan reservasi. Kami akan segera mengkonfirmasi booking Anda.</p>
        </div>

        <div class="booking-container">
            <!-- Step indicators -->
            <div class="step-indicators">
                <div class="step-item active" id="step-dot-1">
                    <div class="step-circle">1</div>
                    <span>Data Diri</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item" id="step-dot-2">
                    <div class="step-circle">2</div>
                    <span>Pilih Jasa</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item" id="step-dot-3">
                    <div class="step-circle">3</div>
                    <span>Jadwal</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item" id="step-dot-4">
                    <div class="step-circle">4</div>
                    <span>Pembayaran</span>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" class="booking-form">
                @csrf

                <!-- Step 1: Data Diri -->
                <div class="form-step active" id="step-1">
                    <h3 class="step-title"><i class="fas fa-user"></i> Data Diri Anda</h3>
                    <div class="form-group">
                        <label for="customer_name">Nama Lengkap <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="customer_name" id="customer_name"
                                placeholder="Masukkan nama lengkap Anda"
                                value="{{ old('customer_name') }}"
                                class="form-control @error('customer_name') is-invalid @enderror"
                                required>
                        </div>
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon / WhatsApp <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" name="phone" id="phone"
                                placeholder="Contoh: 08123456789"
                                value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror"
                                required>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="step-nav">
                        <button type="button" class="btn btn-primary btn-next" onclick="nextStep(1)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Pilih Jasa -->
                <div class="form-step" id="step-2">
                    <h3 class="step-title"><i class="fas fa-spa"></i> Pilih Jasa</h3>
                    <div class="services-select-grid">
                        @foreach($services as $service)
                        <label class="service-select-card" for="service_{{ $service->id }}">
                            <input type="radio" name="service_id" id="service_{{ $service->id }}"
                                value="{{ $service->id }}"
                                data-price="{{ $service->price }}"
                                data-duration="{{ $service->duration }}"
                                {{ old('service_id', request('service')) == $service->id ? 'checked' : '' }}
                                required>
                            <div class="service-card-inner">
                                <div class="service-card-icon"><i class="fas fa-spa"></i></div>
                                <div class="service-card-info">
                                    <strong>{{ $service->name }}</strong>
                                    <span>{{ $service->description }}</span>
                                    <div class="service-card-meta">
                                        <span class="price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        <span class="duration"><i class="fas fa-clock"></i> {{ $service->duration }} mnt</span>
                                    </div>
                                </div>
                                <div class="service-check"><i class="fas fa-check-circle"></i></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('service_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="step-nav">
                        <button type="button" class="btn btn-outline btn-prev" onclick="prevStep(2)">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="button" class="btn btn-primary btn-next" onclick="nextStep(2)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Jadwal -->
                <div class="form-step" id="step-3">
                    <h3 class="step-title"><i class="fas fa-calendar-alt"></i> Pilih Jadwal</h3>
                    <div class="form-group">
                        <label for="booking_date">Tanggal Booking <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-calendar input-icon"></i>
                            <input type="date" name="booking_date" id="booking_date"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('booking_date', date('Y-m-d')) }}"
                                class="form-control @error('booking_date') is-invalid @enderror"
                                required>
                        </div>
                        @error('booking_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Pilih Jam <span class="required">*</span></label>
                        <input type="hidden" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required>
                        <div class="time-slots">
                            @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'] as $time)
                                <button type="button" class="time-slot @if(old('booking_time') == $time) selected @endif"
                                    onclick="selectTime('{{ $time }}')" data-time="{{ $time }}">
                                    {{ $time }}
                                </button>
                            @endforeach
                        </div>
                        @error('booking_time')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="step-nav">
                        <button type="button" class="btn btn-outline btn-prev" onclick="prevStep(3)">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="button" class="btn btn-primary btn-next" onclick="nextStep(3)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Pembayaran + Ringkasan -->
                <div class="form-step" id="step-4">
                    <h3 class="step-title"><i class="fas fa-credit-card"></i> Metode Pembayaran</h3>
                    <div class="payment-methods">
                        <label class="payment-card" for="pay_cash">
                            <input type="radio" name="payment_method" id="pay_cash" value="cash"
                                {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} required>
                            <div class="payment-inner">
                                <i class="fas fa-money-bill-wave"></i>
                                <strong>Cash</strong>
                                <span>Bayar langsung di tempat</span>
                            </div>
                        </label>
                        <label class="payment-card" for="pay_transfer">
                            <input type="radio" name="payment_method" id="pay_transfer" value="transfer"
                                {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                            <div class="payment-inner">
                                <i class="fas fa-university"></i>
                                <strong>Transfer Bank</strong>
                                <span>BCA, BRI, Mandiri, BNI</span>
                            </div>
                        </label>
                        <label class="payment-card" for="pay_qris">
                            <input type="radio" name="payment_method" id="pay_qris" value="qris"
                                {{ old('payment_method') == 'qris' ? 'checked' : '' }}>
                            <div class="payment-inner">
                                <i class="fas fa-qrcode"></i>
                                <strong>QRIS</strong>
                                <span>GoPay, OVO, Dana, Shopeepay</span>
                            </div>
                        </label>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h4><i class="fas fa-receipt"></i> Ringkasan Pesanan</h4>
                        <div class="summary-row">
                            <span>Nama</span>
                            <strong id="sum-name">-</strong>
                        </div>
                        <div class="summary-row">
                            <span>Jasa</span>
                            <strong id="sum-service">-</strong>
                        </div>
                        <div class="summary-row">
                            <span>Tanggal</span>
                            <strong id="sum-date">-</strong>
                        </div>
                        <div class="summary-row">
                            <span>Jam</span>
                            <strong id="sum-time">-</strong>
                        </div>
                        <div class="summary-row total-row">
                            <span>Total</span>
                            <strong id="sum-price" class="text-gradient">-</strong>
                        </div>
                    </div>

                    <div class="step-nav">
                        <button type="button" class="btn btn-outline btn-prev" onclick="prevStep(4)">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-primary btn-xl" id="submitBtn">
                            <i class="fas fa-check-circle"></i> Konfirmasi Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 4;

// Handle if there are validation errors - go to relevant step
@if($errors->any())
    @if($errors->has('customer_name') || $errors->has('phone'))
        currentStep = 1;
    @elseif($errors->has('service_id'))
        currentStep = 2;
    @elseif($errors->has('booking_date') || $errors->has('booking_time'))
        currentStep = 3;
    @elseif($errors->has('payment_method'))
        currentStep = 4;
    @endif
    showStep(currentStep);
@endif

function showStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.step-item').forEach(el => el.classList.remove('active', 'done'));
    document.getElementById('step-' + step).classList.add('active');
    for (let i = 1; i <= totalSteps; i++) {
        const dot = document.getElementById('step-dot-' + i);
        if (i < step) dot.classList.add('done');
        if (i === step) dot.classList.add('active');
    }
    if (step === 4) updateSummary();
    window.scrollTo({ top: document.querySelector('.booking-container').offsetTop - 100, behavior: 'smooth' });
}

function nextStep(step) {
    if (!validateStep(step)) return;
    currentStep = step + 1;
    showStep(currentStep);
}

function prevStep(step) {
    currentStep = step - 1;
    showStep(currentStep);
}

function validateStep(step) {
    if (step === 1) {
        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        if (!name) { alert('Nama lengkap wajib diisi!'); return false; }
        if (!phone) { alert('Nomor telepon wajib diisi!'); return false; }
    }
    if (step === 2) {
        const service = document.querySelector('input[name="service_id"]:checked');
        if (!service) { alert('Pilih salah satu jasa terlebih dahulu!'); return false; }
    }
    if (step === 3) {
        const date = document.getElementById('booking_date').value;
        const time = document.getElementById('booking_time').value;
        if (!date) { alert('Pilih tanggal booking!'); return false; }
        if (!time) { alert('Pilih jam booking!'); return false; }
    }
    return true;
}

function selectTime(time) {
    document.getElementById('booking_time').value = time;
    document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
    document.querySelector(`[data-time="${time}"]`).classList.add('selected');
}

function updateSummary() {
    const name = document.getElementById('customer_name').value;
    const serviceEl = document.querySelector('input[name="service_id"]:checked');
    const serviceName = serviceEl ? serviceEl.closest('label').querySelector('strong').textContent : '-';
    const price = serviceEl ? parseInt(serviceEl.dataset.price) : 0;
    const date = document.getElementById('booking_date').value;
    const time = document.getElementById('booking_time').value;

    document.getElementById('sum-name').textContent = name || '-';
    document.getElementById('sum-service').textContent = serviceName;
    document.getElementById('sum-date').textContent = date ? new Date(date).toLocaleDateString('id-ID', {weekday:'long', year:'numeric', month:'long', day:'numeric'}) : '-';
    document.getElementById('sum-time').textContent = time || '-';
    document.getElementById('sum-price').textContent = price ? 'Rp ' + price.toLocaleString('id-ID') : '-';
}

document.getElementById('bookingForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    submitBtn.disabled = true;
});

// Init
showStep(currentStep);
</script>
@endpush

@extends('layouts.admin')
@section('title', 'Export Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Export Data Transaksi</h1>
</div>

<div class="export-container">
    <div class="form-card">
        <div class="export-hero">
            <div class="export-icon"><i class="fas fa-file-excel"></i></div>
            <h3>Export ke Excel</h3>
            <p>Unduh data transaksi dalam format Excel (.xlsx) yang dapat dibuka di Microsoft Excel, Google Sheets, atau aplikasi sejenis.</p>
        </div>
        <form action="{{ route('admin.export.download') }}" method="GET" class="admin-form" target="_blank">
            <div class="form-grid-2">
                <div class="form-group">
                    <label>Periode Export *</label>
                    <div class="period-select">
                        <label class="period-option">
                            <input type="radio" name="period" value="daily" checked>
                            <div class="period-card">
                                <i class="fas fa-calendar-day"></i>
                                <strong>Harian</strong>
                                <span>Export satu hari</span>
                            </div>
                        </label>
                        <label class="period-option">
                            <input type="radio" name="period" value="weekly">
                            <div class="period-card">
                                <i class="fas fa-calendar-week"></i>
                                <strong>Mingguan</strong>
                                <span>Export satu minggu</span>
                            </div>
                        </label>
                        <label class="period-option">
                            <input type="radio" name="period" value="monthly">
                            <div class="period-card">
                                <i class="fas fa-calendar-alt"></i>
                                <strong>Bulanan</strong>
                                <span>Export satu bulan</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="export_date">Pilih Tanggal *</label>
                    <div class="input-wrap"><i class="fas fa-calendar input-icon"></i>
                        <input type="date" name="date" id="export_date" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                    <small class="form-hint">
                        Untuk mingguan, pilih tanggal dalam minggu yang diinginkan.<br>
                        Untuk bulanan, pilih tanggal dalam bulan yang diinginkan.
                    </small>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-download"></i> Download Excel
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Export Cards -->
    <div class="quick-export">
        <h4>Ekspor Cepat</h4>
        <div class="quick-export-grid">
            <a href="{{ route('admin.export.download') }}?period=daily&date={{ date('Y-m-d') }}" target="_blank"
                class="quick-export-card">
                <i class="fas fa-calendar-day"></i>
                <div>
                    <strong>Hari Ini</strong>
                    <small>{{ now()->format('d M Y') }}</small>
                </div>
                <i class="fas fa-download dl-icon"></i>
            </a>
            <a href="{{ route('admin.export.download') }}?period=weekly&date={{ date('Y-m-d') }}" target="_blank"
                class="quick-export-card">
                <i class="fas fa-calendar-week"></i>
                <div>
                    <strong>Minggu Ini</strong>
                    <small>{{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M Y') }}</small>
                </div>
                <i class="fas fa-download dl-icon"></i>
            </a>
            <a href="{{ route('admin.export.download') }}?period=monthly&date={{ date('Y-m-d') }}" target="_blank"
                class="quick-export-card">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <strong>Bulan Ini</strong>
                    <small>{{ now()->format('F Y') }}</small>
                </div>
                <i class="fas fa-download dl-icon"></i>
            </a>
        </div>
    </div>
</div>
@endsection

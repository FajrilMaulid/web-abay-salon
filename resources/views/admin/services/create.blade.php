@extends('layouts.admin')
@section('title', 'Tambah Jasa')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Jasa Baru</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
<div class="form-card">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @include('admin.services._form')
        <div class="form-actions">
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Jasa</button>
        </div>
    </form>
</div>
@endsection

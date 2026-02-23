@extends('layouts.admin')
@section('title', 'Edit Jasa')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Jasa: {{ $service->name }}</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
<div class="form-card">
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')
        @include('admin.services._form', ['service' => $service])
        <div class="form-actions">
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Jasa</button>
        </div>
    </form>
</div>
@endsection

<div class="form-grid-2">
    <div class="form-group">
        <label for="name">Nama Jasa *</label>
        <div class="input-wrap"><i class="fas fa-spa input-icon"></i>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $service->name ?? '') }}" required placeholder="Contoh: Potong Rambut">
        </div>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="price">Harga (Rp) *</label>
        <div class="input-wrap"><i class="fas fa-tag input-icon"></i>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $service->price ?? '') }}" required min="0" placeholder="50000">
        </div>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="duration">Durasi (menit) *</label>
        <div class="input-wrap"><i class="fas fa-clock input-icon"></i>
            <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror"
                value="{{ old('duration', $service->duration ?? 60) }}" required min="1" placeholder="60">
        </div>
        @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="image">Gambar Jasa</label>
        @if(isset($service) && $service->image)
            <div class="current-img">
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                <small>Gambar saat ini. Upload baru untuk mengganti.</small>
            </div>
        @endif
        <div class="input-wrap"><i class="fas fa-image input-icon"></i>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group form-full">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" rows="3"
            placeholder="Deskripsi singkat tentang jasa ini...">{{ old('description', $service->description ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label class="toggle-label-inline">
            <span>Status Aktif</span>
            <label class="toggle-switch">
                <input type="checkbox" name="active" {{ old('active', $service->active ?? true) ? 'checked' : '' }}>
                <span class="toggle-slider"></span>
            </label>
        </label>
    </div>
</div>

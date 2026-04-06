@extends('layouts.admin')
@section('title', isset($sda) ? 'Edit Data SDA' : 'Tambah Data SDA')

@section('sidebar-menu')
@foreach([
    ['admin.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['sda.index','Data SDA','<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
    ['news.index','Berita SDA','<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/>'],
    ['admin.notifications','Laporan Masuk','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
    ['user.index','Kelola User','<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
] as [$route, $label, $icon])
<a href="{{ route($route) }}" class="sidebar-item {{ request()->routeIs($route) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>
    {{ $label }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>{{ isset($sda) ? 'Edit Data SDA' : 'Tambah Data SDA' }}</h1>
        <p>{{ isset($sda) ? 'Perbarui informasi data SDA' : 'Isi formulir untuk menambahkan data SDA baru' }}</p>
    </div>
    <a href="{{ route('sda.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.5rem;align-items:start;">

    {{-- FORM CARD --}}
    <div class="card">
        <div class="card-header"><h3>Informasi Data SDA</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($sda) ? route('sda.update', $sda) : route('sda.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($sda)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label">Judul Data SDA <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Lahan Pertanian Kecamatan Gandus"
                           value="{{ old('title', $sda->title ?? '') }}" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="location" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Kec. Gandus, Palembang"
                           value="{{ old('location', $sda->location ?? '') }}" required>
                    @error('location')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span style="color:var(--danger);">*</span></label>
                    <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $sda->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span style="color:var(--danger);">*</span></label>
                    <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Deskripsikan data SDA secara lengkap..." rows="5" required>{{ old('description', $sda->description ?? '') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Foto / Gambar</label>
                    <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" accept="image/*"
                           id="imgInput" onchange="previewImg(this)">
                    <p style="font-size:12px;color:var(--slate-400);margin-top:.35rem;">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 12 4 10"/></svg>
                        {{ isset($sda) ? 'Simpan Perubahan' : 'Tambah Data SDA' }}
                    </button>
                    <a href="{{ route('sda.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- PREVIEW --}}
    <div class="card">
        <div class="card-header"><h3>Preview Gambar</h3></div>
        <div class="card-body">
            <div id="imgPreview" style="border-radius:12px;overflow:hidden;background:var(--slate-100);height:200px;display:flex;align-items:center;justify-content:center;">
                @if(isset($sda) && $sda->image)
                    <img src="{{ asset('storage/'.$sda->image) }}" id="previewEl" alt="Preview" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div id="placeholder" style="text-align:center;color:var(--slate-400);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 8px;display:block;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p style="font-size:13px;">Belum ada gambar</p>
                    </div>
                    <img id="previewEl" style="width:100%;height:100%;object-fit:cover;display:none;">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('previewEl');
            const ph = document.getElementById('placeholder');
            el.src = e.target.result;
            el.style.display = 'block';
            if(ph) ph.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

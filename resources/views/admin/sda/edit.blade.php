@extends('layouts.admin')
@section('title', 'Edit Data SDA')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Edit Data SDA</h1>
        <p>Perbarui informasi data sumber daya alam</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.sda.show', $sda) }}" class="btn btn-outline">Detail</a>
        <a href="{{ route('admin.sda.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.5rem;align-items:start;">

    <div class="card">
        <div class="card-header">
            <h3>Edit: {{ Str::limit($sda->title, 55) }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sda.update', $sda) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Judul Data SDA <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title"
                           class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           value="{{ old('title', $sda->title) }}" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="location"
                           class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                           value="{{ old('location', $sda->location) }}" required>
                    @error('location')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori SDA <span style="color:var(--danger)">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $sda->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span style="color:var(--danger)">*</span></label>
                    <textarea name="description" rows="5" class="form-control" required>{{ old('description', $sda->description) }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Ganti Foto <span style="color:var(--slate-400);font-weight:400;">(kosongkan jika tidak ingin diganti)</span></label>
                    <input type="file" id="imageInput" name="image" accept="image/*"
                           class="form-control" onchange="previewImage(this)">
                    <p style="font-size:12px;color:var(--slate-400);margin-top:.3rem;">JPG, PNG, WEBP — Maks. 3MB</p>
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:1.75rem;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.sda.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview --}}
    <div style="position:sticky;top:1.5rem;">
        <div class="card">
            <div class="card-header"><h3>Foto Saat Ini</h3></div>
            <div class="card-body">
                <div style="border-radius:12px;overflow:hidden;height:220px;background:var(--slate-100);">
                    @if($sda->image)
                        <img id="previewImg" src="{{ asset('storage/' . $sda->image) }}"
                             alt="{{ $sda->title }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div id="previewImg" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <div style="text-align:center;color:var(--slate-400);">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.5" style="display:block;margin:0 auto .5rem;opacity:.4;">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                <p style="font-size:13px;">Belum ada foto</p>
                            </div>
                        </div>
                    @endif
                </div>
                <p id="newFileInfo" style="display:none;font-size:12px;color:var(--green-700);font-weight:600;margin-top:.65rem;text-align:center;">
                    ✓ Foto baru siap diunggah
                </p>
            </div>
        </div>

        {{-- Info SDA --}}
        <div class="card" style="margin-top:1rem;">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.75rem;">Info</p>
                @foreach([
                    'ID'          => '#' . $sda->id,
                    'Dibuat'      => $sda->created_at->translatedFormat('d F Y'),
                    'Diperbarui'  => $sda->updated_at->translatedFormat('d F Y'),
                ] as $k => $v)
                <div style="display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--slate-50);font-size:13px;">
                    <span style="color:var(--slate-500);">{{ $k }}</span>
                    <span style="font-weight:500;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('previewImg');
            el.outerHTML = `<img id="previewImg" src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            document.getElementById('newFileInfo').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

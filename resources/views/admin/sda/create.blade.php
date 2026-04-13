@extends('layouts.admin')
@section('title', 'Tambah Data SDA')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Tambah Data SDA</h1>
        <p>Isi formulir untuk menambahkan data sumber daya alam baru</p>
    </div>
    <a href="{{ route('admin.sda.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.5rem;align-items:start;">

    {{-- FORM UTAMA --}}
    <div class="card">
        <div class="card-header"><h3>Informasi Data SDA</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sda.store') }}" enctype="multipart/form-data" id="sdaForm">
                @csrf

                {{-- Judul --}}
                <div class="form-group">
                    <label class="form-label">
                        Judul Data SDA <span style="color:var(--danger)">*</span>
                    </label>
                    <input type="text" name="title"
                           class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Sawah Produktif Kecamatan Gandus"
                           value="{{ old('title') }}" required>
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="form-group">
                    <label class="form-label">
                        Lokasi <span style="color:var(--danger)">*</span>
                    </label>
                    <input type="text" name="location"
                           class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Kec. Gandus, Kota Palembang"
                           value="{{ old('location') }}" required>
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="form-group">
                    <label class="form-label">
                        Kategori SDA <span style="color:var(--danger)">*</span>
                    </label>
                    <select name="category_id"
                            class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label class="form-label">
                        Deskripsi <span style="color:var(--danger)">*</span>
                    </label>
                    <textarea name="description" rows="5"
                              class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Jelaskan data SDA secara lengkap: luas wilayah, potensi, kondisi terkini, dll."
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Foto --}}
                <div class="form-group">
                    <label class="form-label">Foto / Gambar</label>

                    {{-- Drop zone --}}
                    <div id="dropZone" onclick="document.getElementById('imageInput').click()"
                         style="border:2px dashed var(--slate-200);border-radius:12px;padding:1.75rem;text-align:center;cursor:pointer;transition:all .2s;background:var(--slate-50);"
                         ondragover="event.preventDefault();this.style.borderColor='var(--green-500)';this.style.background='var(--green-50)';"
                         ondragleave="this.style.borderColor='var(--slate-200)';this.style.background='var(--slate-50)';"
                         ondrop="handleDrop(event)">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="display:block;margin:0 auto .75rem;color:var(--slate-300);">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:14px;font-weight:500;color:var(--slate-600);margin-bottom:.3rem;">
                            Klik atau seret foto ke sini
                        </p>
                        <p style="font-size:12px;color:var(--slate-400);">JPG, PNG, WEBP — Maks. 3MB</p>
                    </div>

                    <input type="file" id="imageInput" name="image" accept="image/*"
                           style="display:none;" onchange="previewImage(this)">

                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div style="display:flex;gap:10px;margin-top:1.75rem;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 12 4 10"/>
                        </svg>
                        Simpan Data SDA
                    </button>
                    <a href="{{ route('admin.sda.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- PREVIEW FOTO --}}
    <div style="position:sticky;top:1.5rem;">
        <div class="card">
            <div class="card-header"><h3>Preview Foto</h3></div>
            <div class="card-body">
                <div id="previewBox"
                     style="border-radius:12px;overflow:hidden;background:var(--slate-100);height:220px;display:flex;align-items:center;justify-content:center;">
                    <div id="previewPlaceholder" style="text-align:center;color:var(--slate-400);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="display:block;margin:0 auto .75rem;opacity:.4;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:13px;">Foto belum dipilih</p>
                    </div>
                    <img id="previewImg" src="" alt=""
                         style="width:100%;height:100%;object-fit:cover;display:none;">
                </div>

                <div id="fileInfo" style="display:none;margin-top:.75rem;padding:.65rem .85rem;background:var(--green-50);border-radius:8px;">
                    <p id="fileName" style="font-size:12.5px;font-weight:600;color:var(--green-800);"></p>
                    <p id="fileSize" style="font-size:11.5px;color:var(--green-600);margin-top:2px;"></p>
                </div>

                <button type="button" id="removeBtn" onclick="removeImage()"
                        style="display:none;width:100%;margin-top:.75rem;padding:8px;border-radius:8px;border:1px solid #fca5a5;background:#fff;color:var(--danger);font-size:13px;font-weight:600;cursor:pointer;">
                    ✕ Hapus Foto
                </button>
            </div>
        </div>

        {{-- Tips --}}
        <div class="card" style="margin-top:1rem;">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.75rem;">Tips Foto</p>
                @foreach([
                    'Gunakan foto dengan resolusi minimal 800×600 px.',
                    'Pastikan foto menggambarkan lokasi SDA secara jelas.',
                    'Hindari foto yang terlalu gelap atau buram.',
                    'Ukuran file maks. 3MB (JPG/PNG/WEBP).',
                ] as $tip)
                <div style="display:flex;gap:8px;margin-bottom:.5rem;">
                    <div style="width:5px;height:5px;border-radius:50%;background:var(--green-500);flex-shrink:0;margin-top:.45rem;"></div>
                    <p style="font-size:12.5px;color:var(--slate-500);line-height:1.55;">{{ $tip }}</p>
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
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewImg').style.display = 'block';
            document.getElementById('previewPlaceholder').style.display = 'none';
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            document.getElementById('fileInfo').style.display = 'block';
            document.getElementById('removeBtn').style.display = 'block';
            // Update drop zone style
            document.getElementById('dropZone').style.borderColor = 'var(--green-500)';
            document.getElementById('dropZone').style.background = 'var(--green-50)';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('previewImg').src = '';
    document.getElementById('previewImg').style.display = 'none';
    document.getElementById('previewPlaceholder').style.display = 'block';
    document.getElementById('fileInfo').style.display = 'none';
    document.getElementById('removeBtn').style.display = 'none';
    document.getElementById('dropZone').style.borderColor = 'var(--slate-200)';
    document.getElementById('dropZone').style.background = 'var(--slate-50)';
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('dropZone').style.borderColor = 'var(--slate-200)';
    document.getElementById('dropZone').style.background = 'var(--slate-50)';
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('imageInput');
        const dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
        previewImage(input);
    }
}
</script>
@endpush

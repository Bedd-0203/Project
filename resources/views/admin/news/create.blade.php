@extends('layouts.admin')
@section('title', 'Tambah Berita')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Tambah Berita Baru</h1>
        <p>Isi formulir untuk menerbitkan berita</p>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.5rem;align-items:start;">

    <div class="card">
        <div class="card-header"><h3>Form Berita</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Judul Berita <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title"
                           class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           placeholder="Tulis judul berita yang menarik..."
                           value="{{ old('title') }}" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Upload Foto --}}
                <div class="form-group">
                    <label class="form-label">Foto Berita</label>

                    <div id="dropZone" onclick="document.getElementById('imageInput').click()"
                         style="border:2px dashed var(--slate-200);border-radius:12px;padding:1.75rem;text-align:center;cursor:pointer;transition:all .2s;background:var(--slate-50);"
                         ondragover="event.preventDefault();this.style.borderColor='var(--green-500)';"
                         ondragleave="this.style.borderColor='var(--slate-200)';"
                         ondrop="handleDrop(event)">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="display:block;margin:0 auto .65rem;color:var(--slate-300);">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:14px;font-weight:500;color:var(--slate-600);margin-bottom:.25rem;">
                            Klik atau seret foto berita ke sini
                        </p>
                        <p style="font-size:12px;color:var(--slate-400);">JPG, PNG, WEBP — Maks. 3MB</p>
                    </div>

                    <input type="file" id="imageInput" name="image" accept="image/*"
                           style="display:none;" onchange="previewImage(this)">
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Isi Berita --}}
                <div class="form-group">
                    <label class="form-label">Isi Berita <span style="color:var(--danger)">*</span></label>
                    <textarea name="content" rows="10"
                              class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                              placeholder="Tulis isi berita secara lengkap dan informatif. Gunakan paragraf yang jelas dan mudah dipahami..."
                              required>{{ old('content') }}</textarea>
                    @error('content')<p class="form-error">{{ $message }}</p>@enderror
                    <p style="font-size:12px;color:var(--slate-400);margin-top:.35rem;">
                        Minimal 50 karakter. Gunakan Enter untuk paragraf baru.
                    </p>
                </div>

                <div style="display:flex;gap:10px;margin-top:1.75rem;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 12 4 10"/>
                        </svg>
                        Terbitkan Berita
                    </button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview --}}
    <div style="position:sticky;top:1.5rem;">
        <div class="card">
            <div class="card-header"><h3>Preview Foto</h3></div>
            <div class="card-body">
                <div id="previewBox"
                     style="border-radius:12px;overflow:hidden;background:var(--slate-100);height:220px;display:flex;align-items:center;justify-content:center;">
                    <div id="previewPlaceholder" style="text-align:center;color:var(--slate-400);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="display:block;margin:0 auto .65rem;opacity:.35;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:13px;">Foto belum dipilih</p>
                    </div>
                    <img id="previewImg" src="" alt=""
                         style="width:100%;height:100%;object-fit:cover;display:none;">
                </div>

                <div id="fileInfo" style="display:none;margin-top:.65rem;padding:.6rem .85rem;background:var(--green-50);border-radius:8px;">
                    <p id="fileName" style="font-size:12.5px;font-weight:600;color:var(--green-800);"></p>
                    <p id="fileSize" style="font-size:11.5px;color:var(--green-600);margin-top:2px;"></p>
                </div>

                <button type="button" id="removeBtn" onclick="removeImage()"
                        style="display:none;width:100%;margin-top:.65rem;padding:8px;border-radius:8px;border:1px solid #fca5a5;background:#fff;color:var(--danger);font-size:13px;font-weight:600;cursor:pointer;">
                    ✕ Hapus Foto
                </button>
            </div>
        </div>

        <div class="card" style="margin-top:1rem;">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.75rem;">Info</p>
                <div style="font-size:13px;color:var(--slate-500);line-height:1.65;">
                    <p>Berita yang diterbitkan akan langsung tampil di halaman <strong>Beranda</strong> dan halaman <strong>Berita</strong> Portal SDA.</p>
                </div>
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
            document.getElementById('fileSize').textContent = (file.size/1024/1024).toFixed(2) + ' MB';
            document.getElementById('fileInfo').style.display = 'block';
            document.getElementById('removeBtn').style.display = 'block';
            document.getElementById('dropZone').style.borderColor = 'var(--green-500)';
        };
        reader.readAsDataURL(file);
    }
}
function removeImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('previewImg').style.display = 'none';
    document.getElementById('previewPlaceholder').style.display = 'block';
    document.getElementById('fileInfo').style.display = 'none';
    document.getElementById('removeBtn').style.display = 'none';
    document.getElementById('dropZone').style.borderColor = 'var(--slate-200)';
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropZone').style.borderColor = 'var(--slate-200)';
    const files = e.dataTransfer.files;
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

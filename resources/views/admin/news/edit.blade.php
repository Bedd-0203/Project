@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div><h1>Edit Berita</h1><p>Perbarui konten berita</p></div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-outline">Detail</a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.5rem;align-items:start;">
    <div class="card">
        <div class="card-header"><h3>Edit: {{ Str::limit($news->title, 55) }}</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Judul Berita <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $news->title) }}" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Ganti Foto
                        <span style="font-weight:400;color:var(--slate-400);">(kosongkan jika tidak ingin diganti)</span>
                    </label>
                    <input type="file" name="image" id="imageInput" accept="image/*"
                           class="form-control" onchange="previewImage(this)">
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Isi Berita <span style="color:var(--danger)">*</span></label>
                    <textarea name="content" rows="10" class="form-control" required>{{ old('content', $news->content) }}</textarea>
                    @error('content')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:1.75rem;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <div style="position:sticky;top:1.5rem;">
        <div class="card">
            <div class="card-header"><h3>Foto Saat Ini</h3></div>
            <div class="card-body">
                <div style="border-radius:12px;overflow:hidden;height:200px;background:var(--slate-100);">
                    @if($news->image)
                        <img id="previewImg" src="{{ asset('storage/' . $news->image) }}" alt=""
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div id="previewImg" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;text-align:center;color:var(--slate-300);">
                            <p style="font-size:13px;">Belum ada foto</p>
                        </div>
                    @endif
                </div>
                <p id="newFileInfo" style="display:none;font-size:12px;color:var(--green-700);font-weight:600;margin-top:.65rem;text-align:center;">
                    ✓ Foto baru siap diunggah
                </p>
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

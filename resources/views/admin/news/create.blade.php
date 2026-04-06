@extends('layouts.admin')
@section('title', isset($news) ? 'Edit Berita' : 'Tambah Berita')

@section('sidebar-menu')
@foreach([['admin.dashboard','Dashboard'],['sda.index','Data SDA'],['news.index','Berita SDA'],['admin.notifications','Laporan Masuk'],['user.index','Kelola User']] as [$r,$l])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>
    {{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>{{ isset($news) ? 'Edit Berita' : 'Tambah Berita Baru' }}</h1>
        <p>{{ isset($news) ? 'Perbarui konten berita' : 'Isi formulir untuk menerbitkan berita baru' }}</p>
    </div>
    <a href="{{ route('news.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div class="card">
    <div class="card-header"><h3>Form Berita</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ isset($news) ? route('news.update', $news) : route('news.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($news)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Judul Berita <span style="color:var(--danger);">*</span></label>
                <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan judul berita yang menarik..."
                       value="{{ old('title', $news->title ?? '') }}" required>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto Berita</label>
                <input type="file" name="image" class="form-control" accept="image/*" id="imgInput" onchange="previewImg(this)">
                @if(isset($news) && $news->image)
                    <div style="margin-top:.75rem;">
                        <p style="font-size:12px;color:var(--slate-400);margin-bottom:.4rem;">Foto saat ini:</p>
                        <img src="{{ asset('storage/'.$news->image) }}" id="previewEl" alt="Preview" style="height:140px;border-radius:10px;object-fit:cover;">
                    </div>
                @else
                    <img id="previewEl" style="height:140px;border-radius:10px;object-fit:cover;margin-top:.75rem;display:none;">
                @endif
                <p style="font-size:12px;color:var(--slate-400);margin-top:.35rem;">Format: JPG, PNG. Maks 2MB.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Isi Berita <span style="color:var(--danger);">*</span></label>
                <textarea name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                          placeholder="Tulis isi berita secara lengkap dan informatif..." rows="10" required>{{ old('content', $news->content ?? '') }}</textarea>
                @error('content')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">
                    {{ isset($news) ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
                </button>
                <a href="{{ route('news.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
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
            el.src = e.target.result;
            el.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

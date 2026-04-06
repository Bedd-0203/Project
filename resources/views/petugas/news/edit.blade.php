@extends('layouts.admin')
@section('title', isset($news) ? 'Edit Berita' : 'Tambah Berita')

@section('sidebar-menu')
@foreach([['petugas.dashboard','Dashboard',''],['petugas.sda.index','Data SDA',''],['petugas.news.index','Berita SDA','']] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>{{ isset($news) ? 'Edit Berita' : 'Tambah Berita' }}</h1></div>
    <a href="{{ route('petugas.news.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="max-width:700px;">
    <div class="card">
        <div class="card-header"><h3>Form Berita</h3></div>
        <div class="card-body">
            <form method="POST"
                  action="{{ isset($news) ? route('petugas.news.update',$news) : route('petugas.news.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($news)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label">Judul Berita <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title',$news->title??'') }}" required placeholder="Judul berita...">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Berita</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                    @if(isset($news) && $news->image)
                        <img src="{{ asset('storage/'.$news->image) }}" id="previewEl" style="height:120px;border-radius:9px;object-fit:cover;margin-top:.6rem;">
                    @else
                        <img id="previewEl" style="height:120px;border-radius:9px;object-fit:cover;margin-top:.6rem;display:none;">
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Isi Berita <span style="color:var(--danger)">*</span></label>
                    <textarea name="content" class="form-control" rows="8" required placeholder="Tulis isi berita...">{{ old('content',$news->content??'') }}</textarea>
                    @error('content')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">{{ isset($news)?'Simpan':'Terbitkan' }}</button>
                    <a href="{{ route('petugas.news.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewImg(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{const el=document.getElementById('previewEl');el.src=e.target.result;el.style.display='block';};r.readAsDataURL(input.files[0]);}}
</script>
@endpush

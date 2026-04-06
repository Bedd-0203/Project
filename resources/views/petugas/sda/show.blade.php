@extends('layouts.admin')
@section('title', isset($sda) ? 'Edit Data SDA' : 'Tambah Data SDA')

@section('sidebar-menu')
@foreach([['petugas.dashboard','Dashboard',''],['petugas.sda.index','Data SDA',''],['petugas.news.index','Berita SDA','']] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>{{ isset($sda) ? 'Edit Data SDA' : 'Tambah Data SDA' }}</h1></div>
    <a href="{{ route('petugas.sda.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="max-width:700px;">
    <div class="card">
        <div class="card-header"><h3>Form Data SDA</h3></div>
        <div class="card-body">
            <form method="POST"
                  action="{{ isset($sda) ? route('petugas.sda.update',$sda) : route('petugas.sda.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($sda)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label">Judul <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title',$sda->title??'') }}" required placeholder="Judul data SDA">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="location" class="form-control" value="{{ old('location',$sda->location??'') }}" required placeholder="Lokasi SDA">
                    @error('location')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span style="color:var(--danger)">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id',$sda->category_id??'')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span style="color:var(--danger)">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required placeholder="Deskripsikan data SDA...">{{ old('description',$sda->description??'') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                    @if(isset($sda) && $sda->image)
                        <img src="{{ asset('storage/'.$sda->image) }}" id="previewEl" style="height:120px;border-radius:9px;object-fit:cover;margin-top:.6rem;">
                    @else
                        <img id="previewEl" style="height:120px;border-radius:9px;object-fit:cover;margin-top:.6rem;display:none;">
                    @endif
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">{{ isset($sda)?'Simpan':'Tambah Data' }}</button>
                    <a href="{{ route('petugas.sda.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewImg(input){
    if(input.files&&input.files[0]){
        const r=new FileReader();
        r.onload=e=>{const el=document.getElementById('previewEl');el.src=e.target.result;el.style.display='block';};
        r.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

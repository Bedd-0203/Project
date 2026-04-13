@extends('layouts.admin')
@section('title', isset($report) ? 'Edit Laporan' : 'Buat Laporan')

@section('sidebar-menu')
@foreach([
    ['masyarakat.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['masyarakat.report.index','Laporan Saya','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>'],
] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        {!! $i !!}
    </svg>
    {{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>{{ isset($report) ? 'Edit Laporan' : 'Buat Laporan Baru' }}</h1>
        <p>Laporkan masalah SDA yang Anda temukan</p>
    </div>

    {{-- ✅ FIX DI SINI --}}
    <a href="{{ route('masyarakat.report.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.5rem;align-items:start;">
    
    <div class="card">
        <div class="card-header">
            <h3>Form Laporan</h3>
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($report) 
                        ? route('masyarakat.report.update',$report) 
                        : route('masyarakat.report.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($report)) @method('PUT') @endif

                {{-- TITLE --}}
                <div class="form-group">
                    <label class="form-label">Judul Laporan *</label>
                    <input type="text" name="title"
                           class="form-control {{ $errors->has('title')?'is-invalid':'' }}"
                           value="{{ old('title',$report->title??'') }}"
                           required>
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group">
                    <label class="form-label">Deskripsi *</label>
                    <textarea name="description"
                              class="form-control {{ $errors->has('description')?'is-invalid':'' }}"
                              rows="5"
                              required>{{ old('description',$report->description??'') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- IMAGE --}}
                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">

                    <img id="previewEl"
                         style="height:120px;margin-top:10px;display:none;border-radius:8px;">
                </div>

                {{-- BUTTON --}}
                <div style="margin-top:20px;display:flex;gap:10px;">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($report) ? 'Update' : 'Kirim' }}
                    </button>

                    {{-- ✅ FIX DI SINI --}}
                    <a href="{{ route('masyarakat.report.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- SIDE INFO --}}
    <div class="card card-body">
        <h4>Panduan</h4>
        <ul style="font-size:13px;color:#666;">
            <li>Gunakan judul jelas</li>
            <li>Isi deskripsi lengkap</li>
            <li>Tambahkan foto jika ada</li>
        </ul>
    </div>

</div>
@endsection

@push('scripts')
<script>
function previewImg(input){
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            const img = document.getElementById('previewEl');
            img.src = e.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
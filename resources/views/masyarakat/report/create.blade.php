@extends('layouts.admin')
@section('title', isset($report) ? 'Edit Laporan' : 'Buat Laporan')

@section('sidebar-menu')
@foreach([
    ['masyarakat.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['report.index','Laporan Saya','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>'],
] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $i !!}</svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>{{ isset($report) ? 'Edit Laporan' : 'Buat Laporan Baru' }}</h1><p>Laporkan masalah SDA yang Anda temukan</p></div>
    <a href="{{ route('report.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.5rem;align-items:start;">
    <div class="card">
        <div class="card-header"><h3>Form Laporan</h3></div>
        <div class="card-body">
            <form method="POST"
                  action="{{ isset($report) ? route('report.update',$report) : route('report.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($report)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label">Judul Laporan <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title')?'is-invalid':'' }}"
                           placeholder="Contoh: Pencemaran sungai di Kec. Ilir Timur"
                           value="{{ old('title',$report->title??'') }}" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi Masalah <span style="color:var(--danger)">*</span></label>
                    <textarea name="description" class="form-control {{ $errors->has('description')?'is-invalid':'' }}"
                              placeholder="Jelaskan masalah secara detail: lokasi, waktu kejadian, dampak yang terlihat..."
                              rows="6" required>{{ old('description',$report->description??'') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Bukti (opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="imgInput" onchange="previewImg(this)">
                    @if(isset($report) && $report->image)
                        <img src="{{ asset('storage/'.$report->image) }}" id="previewEl" style="height:130px;border-radius:9px;object-fit:cover;margin-top:.6rem;">
                    @else
                        <img id="previewEl" style="height:130px;border-radius:9px;object-fit:cover;margin-top:.6rem;display:none;">
                    @endif
                    <p style="font-size:12px;color:var(--slate-400);margin-top:.35rem;">Unggah foto sebagai bukti laporan. Format JPG/PNG, maks 2MB.</p>
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        {{ isset($report) ? 'Simpan Perubahan' : 'Kirim Laporan' }}
                    </button>
                    <a href="{{ route('report.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem;">
        <div class="card card-body">
            <h4 style="font-size:13.5px;font-weight:700;margin-bottom:.85rem;color:var(--slate-700);">Panduan Pelaporan</h4>
            @foreach([
                'Pastikan judul singkat dan jelas menggambarkan masalah.',
                'Cantumkan lokasi spesifik dalam deskripsi (nama jalan, kelurahan, dll).',
                'Sertakan waktu kejadian jika memungkinkan.',
                'Lampirkan foto sebagai bukti agar laporan lebih mudah ditindaklanjuti.',
                'Laporan akan diproses dalam 1-3 hari kerja.',
            ] as $tip)
            <div style="display:flex;gap:9px;align-items:flex-start;margin-bottom:.6rem;">
                <div style="width:6px;height:6px;border-radius:50%;background:var(--green-500);flex-shrink:0;margin-top:.4rem;"></div>
                <p style="font-size:13px;color:var(--slate-500);line-height:1.55;">{{ $tip }}</p>
            </div>
            @endforeach
        </div>

        <div style="background:var(--amber-100);border-radius:12px;padding:1rem 1.15rem;">
            <p style="font-size:12px;font-weight:700;color:#92400e;margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.06em;">Perhatian</p>
            <p style="font-size:13px;color:#78350f;line-height:1.55;">Untuk keadaan darurat yang mengancam nyawa, segera hubungi <strong>112</strong> atau dinas terkait secara langsung.</p>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewImg(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{const el=document.getElementById('previewEl');el.src=e.target.result;el.style.display='block';};r.readAsDataURL(input.files[0]);}}
</script>
@endpush

@extends('layouts.admin')
@section('title', 'Dashboard Masyarakat')

@section('sidebar-menu')
@foreach([
    ['masyarakat.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
    ['masyarakat.report.index','Laporan Saya','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $i !!}</svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>Dashboard</h1>
        <p>Halo, {{ auth()->user()->name }}! Selamat datang di Portal SDA Palembang 👋</p>
    </div>
    <a href="{{ route('masyarakat.report.create') }}" class="btn btn-primary">+ Buat Laporan</a>
</div>

{{-- Stats --}}
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    @foreach([
        ['Total Laporan',$totalLaporan,'blue','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>'],
        ['Menunggu',$laporanPending,'red','<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
        ['Diproses',$laporanProses,'amber','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
        ['Selesai',$laporanSelesai,'green','<polyline points="20 6 9 12 4 10"/>'],
    ] as [$lbl,$val,$cls,$ico])
    <div class="stat-card">
        <div><div class="stat-label">{{ $lbl }}</div><div class="stat-val">{{ $val }}</div></div>
        <div class="stat-icon {{ $cls }}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $ico !!}</svg></div>
    </div>
    @endforeach
</div>

{{-- Quick form --}}
<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:1.25rem;">
    <div class="card">
        <div class="card-header"><h3>Buat Laporan Cepat</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('masyarakat.report.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Judul Laporan</label>
                    <input type="text" name="title" class="form-control" placeholder="Judul singkat laporan..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan masalah yang Anda temukan..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Bukti (opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Kirim Laporan</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Laporan Terakhir</h3>
            <a href="{{ route('masyarakat.report.index') }}" style="font-size:12.5px;color:var(--green-700);font-weight:600;">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Status</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($riwayat as $lap)
                <tr>
                    <td style="font-size:13px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $lap->title }}</td>
                    <td><span class="badge {{ $lap->status==='selesai'?'badge-green':($lap->status==='diproses'?'badge-amber':'badge-red') }}">{{ $lap->status }}</span></td>
                    <td style="font-size:12px;color:var(--slate-400);">{{ $lap->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:2rem;color:var(--slate-400);font-size:13px;">Belum ada laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Info banner --}}
<div style="margin-top:1.25rem;background:var(--green-50);border:1px solid var(--green-200);border-radius:14px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;">
    <div style="width:42px;height:42px;border-radius:50%;background:var(--green-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green-700)">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
    </div>
    <div>
        <p style="font-weight:600;font-size:14px;color:var(--green-800);margin-bottom:.2rem;">Tahukah Anda?</p>
        <p style="font-size:13px;color:var(--green-700);">Laporan Anda membantu pemerintah mengelola sumber daya alam Kota Palembang dengan lebih baik. Terima kasih atas partisipasi Anda!</p>
    </div>
</div>
@endsection
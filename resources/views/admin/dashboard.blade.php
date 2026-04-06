@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('sidebar-menu')
@foreach([
    ['admin.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
    ['admin.sda.index','Data SDA','<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
    ['admin.news.index','Berita SDA','<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/><path d="M18 14h-8"/><path d="M15 18h-5"/>'],
    ['admin.notifications','Laporan Masuk','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
    ['admin.user.index','Kelola User','<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
] as [$route, $label, $icon])
<a href="{{ route($route) }}" class="sidebar-item {{ request()->routeIs($route) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>
    {{ $label }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ auth()->user()->name }} 👋</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.notifications') }}" style="position:relative;padding:8px 16px;border-radius:9px;border:1px solid var(--slate-200);background:#fff;font-size:13.5px;font-weight:500;color:var(--slate-700);display:flex;align-items:center;gap:7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Laporan
            @if($pendingLaporan > 0)
                <span style="position:absolute;top:-4px;right:-4px;background:var(--danger);color:#fff;font-size:10px;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 4px;">{{ $pendingLaporan }}</span>
            @endif
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div><div class="stat-label">Total Data SDA</div><div class="stat-val">{{ $totalSda }}</div></div>
        <div class="stat-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
    </div>
    <div class="stat-card">
        <div><div class="stat-label">Total Berita</div><div class="stat-val">{{ $totalNews }}</div></div>
        <div class="stat-icon amber"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/></svg></div>
    </div>
    <div class="stat-card">
        <div><div class="stat-label">Laporan Masuk</div><div class="stat-val">{{ $totalLaporan }}</div></div>
        <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
    </div>
    <div class="stat-card">
        <div><div class="stat-label">Menunggu Respon</div><div class="stat-val">{{ $pendingLaporan }}</div></div>
        <div class="stat-icon red"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.25rem;margin-bottom:1.5rem;">
    <div class="card">
        <div class="card-header"><h3>Data SDA per Kategori</h3></div>
        <div class="card-body"><canvas id="barChart" style="max-height:220px;"></canvas></div>
    </div>
    <div class="card">
        <div class="card-header"><h3>Distribusi Kategori</h3></div>
        <div class="card-body"><canvas id="pieChart" style="max-height:220px;"></canvas></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
    <div class="card">
        <div class="card-header">
            <h3>Laporan Terbaru</h3>
            <a href="{{ route('admin.notifications') }}" style="font-size:12.5px;color:var(--green-700);font-weight:600;">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Status</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($laporanTerbaru as $lap)
                <tr>
                    <td style="font-size:13px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $lap->title }}</td>
                    <td>
                        <span class="badge {{ $lap->status === 'selesai' ? 'badge-green' : ($lap->status === 'diproses' ? 'badge-amber' : 'badge-red') }}">
                            {{ $lap->status }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:var(--slate-400);">{{ $lap->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--slate-400);font-size:13px;">Belum ada laporan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Berita Terbaru</h3>
            <a href="{{ route('admin.news.index') }}" style="font-size:12.5px;color:var(--green-700);font-weight:600;">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Oleh</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($newsTerbaru as $n)
                <tr>
                    <td style="font-size:13px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $n->title }}</td>
                    <td style="font-size:12.5px;color:var(--slate-500);">{{ $n->user->name ?? '-' }}</td>
                    <td style="font-size:12px;color:var(--slate-400);">{{ $n->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--slate-400);font-size:13px;">Belum ada berita</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
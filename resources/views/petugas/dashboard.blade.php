@extends('layouts.admin')
@section('title', 'Dashboard Petugas')

@section('sidebar-menu')
@foreach([
    ['petugas.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
    ['petugas.sda.index','Data SDA','<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
    ['petugas.news.index','Berita SDA','<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/><path d="M18 14h-8"/><path d="M15 18h-5"/>'],
] as [$route,$label,$icon])
<a href="{{ route($route) }}" class="sidebar-item {{ request()->routeIs($route) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>{{ $label }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>Dashboard Petugas</h1>
        <p>Selamat datang, {{ auth()->user()->name }} 👋</p>
    </div>
    <a href="{{ route('petugas.sda.create') }}" class="btn btn-primary">+ Tambah Data SDA</a>
</div>

<div class="stats-grid" style="grid-template-columns:repeat(2,1fr);">
    <div class="stat-card">
        <div><div class="stat-label">Total Data SDA</div><div class="stat-val">{{ $totalSda }}</div></div>
        <div class="stat-icon green">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
        </div>
    </div>
    <div class="stat-card">
        <div><div class="stat-label">Berita Saya</div><div class="stat-val">{{ $totalNews }}</div></div>
        <div class="stat-icon amber">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/></svg>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
    <div class="card">
        <div class="card-header">
            <h3>Data SDA Terbaru</h3>
            <a href="{{ route('petugas.sda.index') }}" style="font-size:12.5px;color:var(--green-700);font-weight:600;">Kelola</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Kategori</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($sdaTerbaru as $sda)
                <tr>
                    <td style="font-size:13px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $sda->title }}</td>
                    <td><span class="badge badge-green" style="font-size:10.5px;">{{ $sda->category->name }}</span></td>
                    <td style="font-size:12px;color:var(--slate-400);">{{ $sda->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--slate-400);font-size:13px;padding:1.5rem;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Berita Saya</h3>
            <a href="{{ route('petugas.news.index') }}" style="font-size:12.5px;color:var(--green-700);font-weight:600;">Kelola</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($newsTerbaru as $news)
                <tr>
                    <td style="font-size:13px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $news->title }}</td>
                    <td style="font-size:12px;color:var(--slate-400);">{{ $news->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center;color:var(--slate-400);font-size:13px;padding:1.5rem;">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

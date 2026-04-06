@extends('layouts.admin')
@section('title', 'Kelola Data SDA')

@section('sidebar-menu')
@foreach([
    ['admin.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['admin.sda.index','Data SDA','<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
    ['admin.news.index','Berita SDA','<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/>'],
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
        <h1>Data SDA</h1>
        <p>Kelola seluruh data sumber daya alam</p>
    </div>
    <a href="{{ route('admin.sda.create') }}" class="btn btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Data SDA
    </a>
</div>

<form method="GET" style="background:#fff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;border:1px solid var(--slate-100);display:flex;gap:10px;align-items:center;">
    <div style="flex:1;display:flex;align-items:center;gap:9px;background:var(--slate-50);border-radius:8px;padding:8px 13px;">
        <input type="text" name="q" value="{{ request('q') }}" style="border:none;background:none;width:100%;">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Cari</button>

    @if(request('q') || request('category_id'))
        <a href="{{ route('admin.sda.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>
@endsection
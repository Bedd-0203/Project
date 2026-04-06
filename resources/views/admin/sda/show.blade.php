@extends('layouts.admin')
@section('title', $sda->title)

@section('sidebar-menu')
@foreach([['admin.dashboard','Dashboard',''],['sda.index','Data SDA',''],['news.index','Berita SDA',''],['admin.notifications','Laporan Masuk',''],['user.index','Kelola User','']] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>
    {{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Detail Data SDA</h1><p>{{ $sda->category->name }}</p></div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('sda.edit', $sda) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('sda.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.5rem;align-items:start;">
    <div class="card">
        <div style="height:280px;overflow:hidden;">
            @if($sda->image)
                <img src="{{ asset('storage/'.$sda->image) }}" alt="{{ $sda->title }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="width:100%;height:100%;background:var(--green-50);display:flex;align-items:center;justify-content:center;color:var(--green-300);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
            @endif
        </div>
        <div class="card-body">
            <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:1rem;">{{ $sda->title }}</h2>
            <p style="font-size:14.5px;color:var(--slate-600);line-height:1.8;white-space:pre-line;">{{ $sda->description }}</p>
        </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="card card-body">
            <p style="font-size:11.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--slate-400);margin-bottom:.75rem;">Informasi</p>
            @foreach(['Kategori' => $sda->category->name, 'Lokasi' => $sda->location, 'Ditambahkan' => $sda->created_at->translatedFormat('d F Y'), 'Diperbarui' => $sda->updated_at->translatedFormat('d F Y')] as $key => $val)
            <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--slate-50);font-size:13.5px;">
                <span style="color:var(--slate-500);">{{ $key }}</span>
                <span style="font-weight:500;">{{ $val }}</span>
            </div>
            @endforeach
        </div>
        <div class="card card-body">
            <p style="font-size:11.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--slate-400);margin-bottom:.75rem;">Aksi</p>
            <a href="{{ route('sda.edit', $sda) }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:.5rem;">Edit Data SDA</a>
            <form method="POST" action="{{ route('sda.destroy', $sda) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">Hapus Data</button>
            </form>
        </div>
    </div>
</div>
@endsection

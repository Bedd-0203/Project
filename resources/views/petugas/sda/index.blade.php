@extends('layouts.admin')
@section('title', 'Data SDA — Petugas')

@section('sidebar-menu')
@foreach([
    ['petugas.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['petugas.sda.index','Data SDA','<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
    ['petugas.news.index','Berita SDA','<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/>'],
] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $i !!}</svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Data SDA</h1><p>Kelola data sumber daya alam</p></div>
    <a href="{{ route('petugas.sda.create') }}" class="btn btn-primary">+ Tambah Data SDA</a>
</div>

<form method="GET" style="background:#fff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;border:1px solid var(--slate-100);display:flex;gap:10px;">
    <div style="flex:1;display:flex;align-items:center;gap:9px;background:var(--slate-50);border-radius:8px;padding:8px 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--slate-400)"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" placeholder="Cari data SDA..." value="{{ request('q') }}" style="border:none;background:none;font-size:13.5px;outline:none;width:100%;font-family:'DM Sans',sans-serif;">
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if(request('q'))<a href="{{ route('petugas.sda.index') }}" class="btn btn-outline btn-sm">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead><tr><th>No</th><th>Judul</th><th>Lokasi</th><th>Kategori</th><th>Tanggal</th><th width="150">Aksi</th></tr></thead>
        <tbody>
            @forelse($sdas as $i => $sda)
            <tr>
                <td style="color:var(--slate-400);">{{ $sdas->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--green-50);">
                            @if($sda->image)
                                <img src="{{ asset('storage/'.$sda->image) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                            @endif
                        </div>
                        <span style="font-size:13.5px;font-weight:500;">{{ Str::limit($sda->title,45) }}</span>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--slate-500);">{{ $sda->location }}</td>
                <td><span class="badge badge-green">{{ $sda->category->name }}</span></td>
                <td style="font-size:12px;color:var(--slate-400);">{{ $sda->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('petugas.sda.edit',$sda) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('petugas.sda.destroy',$sda) }}" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">Belum ada data SDA.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($sdas->hasPages())<div class="pagination">{{ $sdas->links() }}</div>@endif
</div>
@endsection

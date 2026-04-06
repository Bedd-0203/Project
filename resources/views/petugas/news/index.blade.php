@extends('layouts.admin')
@section('title', 'Berita SDA — Petugas')

@section('sidebar-menu')
@foreach([['petugas.dashboard','Dashboard',''],['petugas.sda.index','Data SDA',''],['petugas.news.index','Berita SDA','']] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Berita SDA</h1><p>Berita yang Anda kelola</p></div>
    <a href="{{ route('petugas.news.create') }}" class="btn btn-primary">+ Tambah Berita</a>
</div>

<form method="GET" style="background:#fff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;border:1px solid var(--slate-100);display:flex;gap:10px;">
    <div style="flex:1;display:flex;align-items:center;gap:9px;background:var(--slate-50);border-radius:8px;padding:8px 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--slate-400)"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}" style="border:none;background:none;font-size:13.5px;outline:none;width:100%;font-family:'DM Sans',sans-serif;">
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
</form>

<div class="card">
    <table>
        <thead><tr><th>No</th><th>Judul</th><th>Tanggal</th><th width="130">Aksi</th></tr></thead>
        <tbody>
            @forelse($news as $i => $item)
            <tr>
                <td style="color:var(--slate-400);">{{ $news->firstItem()+$i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:44px;height:36px;border-radius:6px;overflow:hidden;flex-shrink:0;background:var(--slate-100);">
                            @if($item->image)<img src="{{ asset('storage/'.$item->image) }}" alt="" style="width:100%;height:100%;object-fit:cover;">@endif
                        </div>
                        <span style="font-size:13.5px;font-weight:500;">{{ Str::limit($item->title,55) }}</span>
                    </div>
                </td>
                <td style="font-size:12px;color:var(--slate-400);">{{ $item->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('petugas.news.edit',$item) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('petugas.news.destroy',$item) }}" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:3rem;color:var(--slate-400);">Belum ada berita.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($news->hasPages())<div class="pagination">{{ $news->links() }}</div>@endif
</div>
@endsection

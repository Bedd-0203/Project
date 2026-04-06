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
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Data SDA
    </a>
</div>

{{-- Search --}}
<form method="GET" style="background:#fff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;border:1px solid var(--slate-100);display:flex;gap:10px;align-items:center;">
    <div style="flex:1;display:flex;align-items:center;gap:9px;background:var(--slate-50);border-radius:8px;padding:8px 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--slate-400);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" placeholder="Cari data SDA..." value="{{ request('q') }}" style="border:none;background:none;font-size:13.5px;outline:none;color:var(--slate-900);font-family:'DM Sans',sans-serif;width:100%;">
    </div>
    <select name="category_id" style="padding:8px 13px;border-radius:8px;border:1px solid var(--slate-200);font-size:13.5px;color:var(--slate-700);background:#fff;outline:none;" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if(request('q') || request('category_id'))
        <a href="{{ route('admin.sda.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

<div class="card">
    <div class="card-header">
        <h3>Total: {{ $sdas->total() }} Data SDA</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Judul</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sdas as $i => $sda)
            <tr>
                <td style="color:var(--slate-400);">{{ $sdas->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if($sda->image)
                            <img src="{{ asset('storage/'.$sda->image) }}" alt="" style="width:38px;height:38px;border-radius:8px;object-fit:cover;flex-shrink:0;">
                        @else
                            <div style="width:38px;height:38px;border-radius:8px;background:var(--green-100);flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green-700);"><ellipse cx="12" cy="5" rx="9" ry="3"/></svg>
                            </div>
                        @endif
                        <div>
                            <p style="font-weight:600;font-size:13.5px;color:var(--slate-900);">{{ Str::limit($sda->title, 45) }}</p>
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--slate-500);">{{ $sda->location }}</td>
                <td><span class="badge badge-green">{{ $sda->category->name }}</span></td>
                <td style="font-size:12.5px;color:var(--slate-400);">{{ $sda->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.sda.show', $sda) }}" class="btn btn-outline btn-sm">Detail</a>
                        <a href="{{ route('admin.sda.edit', $sda) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.sda.destroy', $sda) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">Tidak ada data SDA.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($sdas->hasPages())
    <div class="pagination">{{ $sdas->links() }}</div>
    @endif
</div>
@endsection
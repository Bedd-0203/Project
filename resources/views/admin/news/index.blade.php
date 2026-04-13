@extends('layouts.admin')
@section('title', 'Kelola Berita SDA')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Berita SDA</h1>
        <p>Kelola berita dan informasi publik Portal SDA</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Berita
    </a>
</div>

<form method="GET" class="search-bar">
    <div class="search-input-wrap">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             style="color:var(--slate-400);flex-shrink:0;">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" placeholder="Cari judul atau isi berita..." value="{{ request('q') }}">
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if(request('q'))
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

<div class="card">
    <div class="card-header">
        <h3>Total: <strong>{{ $news->total() }}</strong> Berita</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Foto</th>
                <th>Judul Berita</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $i => $item)
            <tr>
                <td style="color:var(--slate-400);font-size:13px;">{{ $news->firstItem() + $i }}</td>

                <td>
                    <div style="width:60px;height:48px;border-radius:8px;overflow:hidden;background:var(--slate-100);">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.5" style="color:var(--slate-300);">
                                    <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </td>

                <td>
                    <p style="font-size:13.5px;font-weight:600;color:var(--slate-900);">
                        {{ Str::limit($item->title, 55) }}
                    </p>
                    <p style="font-size:12px;color:var(--slate-400);margin-top:2px;">
                        {{ Str::limit($item->content, 60) }}
                    </p>
                </td>

                <td style="font-size:13px;color:var(--slate-500);">
                    {{ $item->user->name ?? '-' }}
                </td>

                <td style="font-size:12.5px;color:var(--slate-400);">
                    {{ $item->created_at->format('d/m/Y') }}
                </td>

                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.news.show', $item) }}" class="btn btn-outline btn-sm">Detail</a>
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $item) }}"
                              onsubmit="return confirm('Yakin hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">
                    <p style="font-weight:500;margin-bottom:.35rem;">Belum ada berita</p>
                    <p style="font-size:13px;">Klik tombol <strong>Tambah Berita</strong> untuk menambahkan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($news->hasPages())
        <div style="padding:1rem 1.25rem;">{{ $news->links() }}</div>
    @endif
</div>

@endsection

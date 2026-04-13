@extends('layouts.admin')
@section('title', 'Kelola Data SDA')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Data SDA</h1>
        <p>Kelola seluruh data sumber daya alam Kota Palembang</p>
    </div>
    <a href="{{ route('admin.sda.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Data SDA
    </a>
</div>

{{-- Search & Filter --}}
<form method="GET" class="search-bar">
    <div class="search-input-wrap">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             style="color:var(--slate-400);flex-shrink:0;">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" placeholder="Cari judul atau lokasi..." value="{{ request('q') }}">
    </div>
    <select name="category_id" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if(request('q') || request('category_id'))
        <a href="{{ route('admin.sda.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

<div class="card">
    <div class="card-header">
        <h3>Total: <strong>{{ $sdas->total() }}</strong> Data SDA</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Foto</th>
                <th>Judul & Lokasi</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sdas as $i => $sda)
            <tr>
                <td style="color:var(--slate-400);font-size:13px;">{{ $sdas->firstItem() + $i }}</td>

                {{-- Foto --}}
                <td>
                    <div style="width:60px;height:48px;border-radius:8px;overflow:hidden;background:var(--slate-100);flex-shrink:0;">
                        @if($sda->image)
                            <img src="{{ asset('storage/' . $sda->image) }}"
                                 alt="{{ $sda->title }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.5" style="color:var(--slate-300);">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </td>

                {{-- Judul & Lokasi --}}
                <td>
                    <p style="font-size:13.5px;font-weight:600;color:var(--slate-900);margin-bottom:2px;">
                        {{ Str::limit($sda->title, 50) }}
                    </p>
                    <p style="font-size:12px;color:var(--slate-400);display:flex;align-items:center;gap:4px;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $sda->location }}
                    </p>
                </td>

                {{-- Kategori --}}
                <td>
                    <span class="badge badge-green" style="font-size:11px;">
                        {{ $sda->category->name ?? '-' }}
                    </span>
                </td>

                {{-- Tanggal --}}
                <td style="font-size:12.5px;color:var(--slate-400);">
                    {{ $sda->created_at->format('d/m/Y') }}
                </td>

                {{-- Aksi --}}
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.sda.show', $sda) }}" class="btn btn-outline btn-sm">
                            Detail
                        </a>
                        <a href="{{ route('admin.sda.edit', $sda) }}" class="btn btn-outline btn-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.sda.destroy', $sda) }}"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" style="display:block;margin:0 auto .75rem;opacity:.35;">
                        <ellipse cx="12" cy="5" rx="9" ry="3"/>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                    </svg>
                    <p style="font-weight:500;margin-bottom:.35rem;">Belum ada data SDA</p>
                    <p style="font-size:13px;">Klik tombol <strong>Tambah Data SDA</strong> untuk menambahkan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($sdas->hasPages())
        <div style="padding:1rem 1.25rem;">{{ $sdas->links() }}</div>
    @endif
</div>

@endsection

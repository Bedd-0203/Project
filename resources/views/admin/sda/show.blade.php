@extends('layouts.admin')
@section('title', $sda->title)
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>Detail Data SDA</h1>
        <p>{{ $sda->category->name }}</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.sda.edit', $sda) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.sda.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;align-items:start;">

    {{-- Konten utama --}}
    <div class="card">
        {{-- Foto --}}
        <div style="height:300px;border-radius:14px 14px 0 0;overflow:hidden;background:var(--slate-100);">
            @if($sda->image)
                <img src="{{ asset('storage/' . $sda->image) }}" alt="{{ $sda->title }}"
                     style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <div style="text-align:center;color:var(--slate-300);">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1" style="display:block;margin:0 auto .75rem;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:14px;">Belum ada foto</p>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:1.1rem;">
                <span class="badge badge-green">{{ $sda->category->name }}</span>
                <span style="font-size:12.5px;color:var(--slate-400);display:flex;align-items:center;gap:4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $sda->location }}
                </span>
                <span style="font-size:12.5px;color:var(--slate-400);">
                    {{ $sda->created_at->translatedFormat('d F Y') }}
                </span>
            </div>

            <h2 style="font-size:1.5rem;font-weight:900;margin-bottom:1.1rem;line-height:1.25;">
                {{ $sda->title }}
            </h2>
            <p style="font-size:15px;color:var(--slate-600);line-height:1.85;white-space:pre-line;">
                {{ $sda->description }}
            </p>
        </div>
    </div>

    {{-- Sidebar info + aksi --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">
        <div class="card">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.85rem;">
                    Informasi
                </p>
                @foreach([
                    'ID Data'    => '#' . $sda->id,
                    'Kategori'   => $sda->category->name,
                    'Lokasi'     => $sda->location,
                    'Dibuat'     => $sda->created_at->translatedFormat('d F Y'),
                    'Diperbarui' => $sda->updated_at->translatedFormat('d F Y'),
                ] as $k => $v)
                <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:.6rem 0;border-bottom:1px solid var(--slate-50);font-size:13.5px;gap:.5rem;">
                    <span style="color:var(--slate-500);flex-shrink:0;">{{ $k }}</span>
                    <span style="font-weight:500;text-align:right;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.85rem;">Aksi</p>
                <a href="{{ route('admin.sda.edit', $sda) }}" class="btn btn-primary"
                   style="width:100%;justify-content:center;margin-bottom:.6rem;">
                    ✏️ Edit Data SDA
                </a>
                <form method="POST" action="{{ route('admin.sda.destroy', $sda) }}"
                      onsubmit="return confirm('Yakin hapus data ini? Tindakan tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                        🗑 Hapus Data SDA
                    </button>
                </form>
            </div>
        </div>

        {{-- Lihat di beranda --}}
        <div style="background:var(--green-50);border:1px solid var(--green-200);border-radius:12px;padding:1rem;">
            <p style="font-size:13px;font-weight:600;color:var(--green-800);margin-bottom:.35rem;">Tampil di Beranda</p>
            <p style="font-size:12.5px;color:var(--green-700);line-height:1.6;">
                Data ini otomatis tampil di halaman beranda sebagai Data SDA Terbaru.
            </p>
            <a href="{{ url('/detail-sda/' . $sda->id) }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--green-700);margin-top:.65rem;">
                Lihat di Publik →
            </a>
        </div>
    </div>
</div>

@endsection

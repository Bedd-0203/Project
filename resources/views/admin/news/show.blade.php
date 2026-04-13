@extends('layouts.admin')
@section('title', $news->title)
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div><h1>Detail Berita</h1></div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;align-items:start;">
    <div class="card">
        @if($news->image)
        <div style="height:300px;border-radius:14px 14px 0 0;overflow:hidden;">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                 style="width:100%;height:100%;object-fit:cover;">
        </div>
        @endif
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:1.1rem;">
                <span class="badge badge-blue">Berita</span>
                <span style="font-size:12.5px;color:var(--slate-400);">
                    {{ $news->created_at->translatedFormat('d F Y') }}
                </span>
                <span style="font-size:12.5px;color:var(--slate-400);">
                    oleh {{ $news->user->name ?? '-' }}
                </span>
            </div>
            <h2 style="font-size:1.5rem;font-weight:900;margin-bottom:1.1rem;line-height:1.25;">{{ $news->title }}</h2>
            <div style="font-size:15px;color:var(--slate-600);line-height:1.85;white-space:pre-line;">{{ $news->content }}</div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem;">
        <div class="card">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.85rem;">Informasi</p>
                @foreach(['ID'=>'#'.$news->id,'Penulis'=>$news->user->name??'-','Dibuat'=>$news->created_at->translatedFormat('d F Y'),'Diperbarui'=>$news->updated_at->translatedFormat('d F Y')] as $k=>$v)
                <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--slate-50);font-size:13.5px;">
                    <span style="color:var(--slate-500);">{{ $k }}</span>
                    <span style="font-weight:500;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:.6rem;">✏️ Edit Berita</a>
                <form method="POST" action="{{ route('admin.news.destroy', $news) }}" onsubmit="return confirm('Hapus berita ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">🗑 Hapus Berita</button>
                </form>
            </div>
        </div>
        <div style="background:var(--green-50);border:1px solid var(--green-200);border-radius:12px;padding:1rem;">
            <p style="font-size:13px;font-weight:600;color:var(--green-800);margin-bottom:.35rem;">Tampil di Beranda</p>
            <p style="font-size:12.5px;color:var(--green-700);line-height:1.6;">Berita ini otomatis tampil di halaman beranda sebagai Berita Terkini.</p>
            <a href="{{ url('/detail-news/' . $news->id) }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--green-700);margin-top:.65rem;">
               Lihat di Publik →
            </a>
        </div>
    </div>
</div>

@endsection

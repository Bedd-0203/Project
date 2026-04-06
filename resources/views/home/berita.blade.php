@extends('layouts.app')
@section('title', 'Berita SDA')

@section('content')
<div style="background:var(--slate-50);border-bottom:1px solid var(--slate-100);padding:3rem 1.5rem 2rem;">
    <div style="max-width:1200px;margin:0 auto;">
        <div style="display:flex;align-items:center;gap:10px;font-size:11.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--green-700);margin-bottom:.75rem;">
            <span style="width:24px;height:2px;background:var(--slate-400);display:block;"></span>Informasi
        </div>
        <h1 style="font-size:2.2rem;font-weight:900;margin-bottom:.5rem;">Berita SDA</h1>
        <p style="color:var(--slate-500);">Berita dan informasi terkini seputar sumber daya alam Kota Palembang.</p>
    </div>
</div>

<div style="max-width:1200px;margin:0 auto;padding:2rem 1.5rem 5rem;">
    {{-- Search --}}
    <form method="GET" style="background:#fff;border-radius:14px;padding:1.25rem;margin-bottom:2rem;border:1px solid var(--slate-100);box-shadow:0 2px 8px rgba(0,0,0,.04);">
        <div style="display:flex;gap:12px;align-items:center;">
            <div style="flex:1;display:flex;align-items:center;gap:10px;background:var(--slate-100);border-radius:10px;padding:10px 16px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--slate-400);flex-shrink:0;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}"
                    style="border:none;background:none;font-size:14px;color:var(--slate-900);width:100%;outline:none;font-family:'DM Sans',sans-serif;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if(request('q'))<a href="/news" class="btn btn-outline btn-sm">Reset</a>@endif
        </div>
    </form>

    @if($news->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
            @foreach($news as $item)
            <a href="/detail-news/{{ $item->id }}" style="background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--slate-100);transition:all .2s;display:block;color:inherit;">
                <div style="height:185px;overflow:hidden;position:relative;background:var(--slate-100);">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                    @else
                        <img src="https://images.unsplash.com/photo-1504701954957-2010ec3bcec1?w=500&q=70" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                    @endif
                    <div style="position:absolute;top:10px;left:10px;background:rgba(255,255,255,.9);color:var(--green-700);padding:3px 11px;border-radius:20px;font-size:11px;font-weight:600;">Berita</div>
                </div>
                <div style="padding:1.1rem;">
                    <div style="font-size:12px;color:var(--slate-400);margin-bottom:.4rem;">{{ $item->created_at->translatedFormat('d F Y') }}</div>
                    <h4 style="font-size:14.5px;font-weight:600;line-height:1.4;margin-bottom:.4rem;font-family:'DM Sans',sans-serif;">{{ $item->title }}</h4>
                    <p style="font-size:12.5px;color:var(--slate-500);line-height:1.6;">{{ Str::limit($item->content, 90) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:2.5rem;">{{ $news->links() }}</div>
    @else
        <div style="text-align:center;padding:4rem;color:var(--slate-400);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;opacity:.4;"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2z"/></svg>
            <p>Tidak ada berita ditemukan.</p>
        </div>
    @endif
</div>
@endsection

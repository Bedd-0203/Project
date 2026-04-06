@extends('layouts.app')
@section('title', $news->title)

@section('content')
<div style="max-width:860px;margin:0 auto;padding:2.5rem 1.5rem 5rem;">

    <a href="/news" style="display:inline-flex;align-items:center;gap:7px;color:var(--green-700);font-size:13.5px;font-weight:600;margin-bottom:1.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Berita
    </a>

    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem;align-items:center;">
        <span style="background:var(--green-100);color:var(--green-800);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;">Berita</span>
        <span style="font-size:13px;color:var(--slate-500);">{{ $news->created_at->translatedFormat('d F Y') }}</span>
        @if($news->user)
            <span style="font-size:13px;color:var(--slate-500);">oleh {{ $news->user->name }}</span>
        @endif
    </div>

    <h1 style="font-size:2.1rem;font-weight:900;line-height:1.25;margin-bottom:1.75rem;">{{ $news->title }}</h1>

    @if($news->image)
    <div style="border-radius:16px;overflow:hidden;margin-bottom:2rem;">
        <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" style="width:100%;max-height:420px;object-fit:cover;">
    </div>
    @endif

    <div style="font-size:15.5px;color:var(--slate-600);line-height:1.9;white-space:pre-line;">{{ $news->content }}</div>

    {{-- Latest news sidebar --}}
    @if($latest->count() > 0)
    <div style="margin-top:3.5rem;border-top:1px solid var(--slate-100);padding-top:2.5rem;">
        <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:1.5rem;">Berita Lainnya</h3>
        <div style="display:flex;flex-direction:column;gap:.75rem;">
            @foreach($latest as $item)
            <a href="/detail-news/{{ $item->id }}" style="display:flex;gap:1rem;align-items:flex-start;padding:.85rem;border-radius:12px;border:1px solid var(--slate-100);background:#fff;transition:all .2s;color:inherit;">
                <div style="width:70px;height:60px;border-radius:8px;overflow:hidden;flex-shrink:0;">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1504701954957-2010ec3bcec1?w=200&q=60' }}"
                         alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div>
                    <p style="font-size:13.5px;font-weight:600;line-height:1.35;color:var(--slate-900);margin-bottom:.25rem;">{{ $item->title }}</p>
                    <p style="font-size:12px;color:var(--slate-400);">{{ $item->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

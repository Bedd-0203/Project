@extends('layouts.app')
@section('title', $sda->title)

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:2.5rem 1.5rem 5rem;">

    {{-- Back --}}
    <a href="/sda" style="display:inline-flex;align-items:center;gap:7px;color:var(--green-700);font-size:13.5px;font-weight:600;margin-bottom:1.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Data SDA
    </a>

    {{-- Image --}}
    <div style="border-radius:18px;overflow:hidden;height:380px;margin-bottom:2rem;background:var(--slate-100);">
        @if($sda->image)
            <img src="{{ asset('storage/' . $sda->image) }}" alt="{{ $sda->title }}" style="width:100%;height:100%;object-fit:cover;">
        @else
            <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=900&q=80" alt="{{ $sda->title }}" style="width:100%;height:100%;object-fit:cover;">
        @endif
    </div>

    {{-- Meta --}}
    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;align-items:center;">
        <span style="background:var(--green-100);color:var(--green-800);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;">{{ $sda->category->name }}</span>
        <span style="font-size:13px;color:var(--slate-500);display:flex;align-items:center;gap:5px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $sda->location }}
        </span>
        <span style="font-size:13px;color:var(--slate-500);">{{ $sda->created_at->translatedFormat('d F Y') }}</span>
    </div>

    {{-- Title --}}
    <h1 style="font-size:2rem;font-weight:900;margin-bottom:1.25rem;line-height:1.25;">{{ $sda->title }}</h1>

    {{-- Content --}}
    <div style="font-size:15px;color:var(--slate-600);line-height:1.85;white-space:pre-line;">{{ $sda->description }}</div>

    {{-- Related --}}
    @if($related->count() > 0)
    <div style="margin-top:3.5rem;border-top:1px solid var(--slate-100);padding-top:2.5rem;">
        <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem;">Data SDA Terkait</h3>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
            @foreach($related as $item)
            <a href="/detail-sda/{{ $item->id }}" style="background:#fff;border-radius:12px;overflow:hidden;border:1px solid var(--slate-100);display:block;transition:all .2s;">
                <div style="height:120px;overflow:hidden;">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&q=70' }}"
                         alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="padding:.85rem;">
                    <p style="font-size:13px;font-weight:600;line-height:1.35;color:var(--slate-900);">{{ $item->title }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.admin')
@section('title', $news->title)

@section('sidebar-menu')
@foreach([['admin.dashboard','Dashboard'],['sda.index','Data SDA'],['news.index','Berita SDA'],['admin.notifications','Laporan Masuk'],['user.index','Kelola User']] as [$r,$l])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Detail Berita</h1></div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('news.edit',$news) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('news.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>
<div style="max-width:800px;">
    <div class="card">
        @if($news->image)
        <div style="height:280px;overflow:hidden;">
            <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" style="width:100%;height:100%;object-fit:cover;">
        </div>
        @endif
        <div class="card-body">
            <div style="display:flex;gap:.75rem;margin-bottom:1rem;align-items:center;">
                <span class="badge badge-blue">Berita</span>
                <span style="font-size:12.5px;color:var(--slate-400);">{{ $news->created_at->translatedFormat('d F Y') }}</span>
                <span style="font-size:12.5px;color:var(--slate-400);">oleh {{ $news->user->name ?? '-' }}</span>
            </div>
            <h2 style="font-size:1.5rem;font-weight:900;margin-bottom:1.25rem;">{{ $news->title }}</h2>
            <div style="font-size:15px;color:var(--slate-600);line-height:1.85;white-space:pre-line;">{{ $news->content }}</div>
        </div>
    </div>
</div>
@endsection

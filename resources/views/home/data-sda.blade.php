@extends('layouts.app')
@section('title', 'Data Sumber Daya Alam')

@push('styles')
<style>
.page-hero{background:var(--slate-50);border-bottom:1px solid var(--slate-100);padding:3rem 1.5rem 2rem;}
.page-hero-inner{max-width:1200px;margin:0 auto;}
.eyebrow{display:flex;align-items:center;gap:10px;font-size:11.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--green-700);margin-bottom:.75rem;}
.eyebrow::before{content:'';width:24px;height:2px;background:var(--slate-400);}
.page-hero h1{font-size:2.2rem;font-weight:900;margin-bottom:.5rem;}
.page-hero p{color:var(--slate-500);font-size:.95rem;}
.page-body{max-width:1200px;margin:0 auto;padding:2rem 1.5rem 5rem;}
.search-bar{background:#fff;border-radius:14px;padding:1.25rem;margin-bottom:2rem;border:1px solid var(--slate-100);box-shadow:0 2px 8px rgba(0,0,0,.04);}
.search-row{display:flex;gap:12px;align-items:center;flex-wrap:wrap;}
.search-input-wrap{flex:1;display:flex;align-items:center;gap:10px;background:var(--slate-100);border-radius:10px;padding:10px 16px;min-width:220px;}
.search-input-wrap input{border:none;background:none;font-size:14px;color:var(--slate-900);width:100%;outline:none;}
.search-input-wrap input::placeholder{color:var(--slate-400);}
.filter-sel{padding:10px 14px;border-radius:10px;border:1px solid var(--slate-200);font-size:13.5px;color:var(--slate-700);background:#fff;outline:none;cursor:pointer;}
.data-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}
.d-card{background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--slate-100);transition:all .2s;display:block;color:inherit;}
.d-card:hover{box-shadow:0 10px 32px rgba(0,0,0,.08);transform:translateY(-3px);}
.d-card-img{height:165px;position:relative;overflow:hidden;background:var(--slate-100);}
.d-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .35s;}
.d-card:hover .d-card-img img{transform:scale(1.07);}
.d-badge{position:absolute;top:10px;left:10px;background:var(--green-700);color:#fff;padding:3px 11px;border-radius:20px;font-size:11px;font-weight:600;}
.d-body{padding:1.1rem 1.15rem;}
.d-body h4{font-size:14.5px;font-weight:600;line-height:1.35;margin-bottom:.35rem;font-family:'DM Sans',sans-serif;}
.d-body p{font-size:12.5px;color:var(--slate-500);line-height:1.55;margin-bottom:.7rem;}
.d-meta{display:flex;align-items:center;gap:7px;font-size:12px;color:var(--slate-400);}
.empty-state{text-align:center;padding:4rem 2rem;color:var(--slate-400);}
.empty-state svg{display:block;margin:0 auto 1rem;opacity:.35;}
@media(max-width:768px){.data-grid{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="page-hero-inner">
        <div class="eyebrow">Database</div>
        <h1>Data Sumber Daya Alam</h1>
        <p>Eksplorasi data sumber daya alam Kota Palembang secara lengkap dan transparan.</p>
    </div>
</div>

<div class="page-body">
    {{-- Search & Filter --}}
    <form method="GET" class="search-bar">
        <div class="search-row">
            <div class="search-input-wrap">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--slate-400);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" placeholder="Cari data SDA..." value="{{ request('q') }}">
            </div>
            <select name="category" class="filter-sel" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if(request('q') || request('category'))
                <a href="/sda" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </div>
    </form>

    {{-- Results count --}}
    <p style="font-size:13px;color:var(--slate-500);margin-bottom:1.25rem;">
        Menampilkan <strong>{{ $sdas->total() }}</strong> data SDA
        @if(request('q')) untuk "<strong>{{ request('q') }}</strong>" @endif
    </p>

    {{-- Grid --}}
    @if($sdas->count() > 0)
        <div class="data-grid">
            @foreach($sdas as $sda)
            <a href="/detail-sda/{{ $sda->id }}" class="d-card">
                <div class="d-card-img">
                    @if($sda->image)
                        <img src="{{ asset('storage/' . $sda->image) }}" alt="{{ $sda->title }}" loading="lazy">
                    @else
                        <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=500&q=70" alt="{{ $sda->title }}" loading="lazy">
                    @endif
                    <div class="d-badge">{{ $sda->category->name }}</div>
                </div>
                <div class="d-body">
                    <h4>{{ $sda->title }}</h4>
                    <p>{{ Str::limit($sda->description, 85) }}</p>
                    <div class="d-meta">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $sda->location }}
                        <span style="width:3px;height:3px;border-radius:50%;background:var(--slate-200);display:inline-block;"></span>
                        {{ $sda->created_at->year }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="margin-top:2.5rem;">
            {{ $sdas->links() }}
        </div>
    @else
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
            <p style="font-size:15px;font-weight:500;margin-bottom:.35rem;">Tidak ada data ditemukan</p>
            <p style="font-size:13px;">Coba ubah kata kunci atau filter kategori Anda.</p>
        </div>
    @endif
</div>
@endsection

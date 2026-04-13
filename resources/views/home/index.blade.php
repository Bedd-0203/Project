@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
/* ─── HERO ────────────────────────────────────────────────── */
.hero {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a1f14;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=1600&q=85');
    background-size: cover;
    background-position: center 40%;
    opacity: .50;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,
        rgba(4,30,16,.92) 0%,
        rgba(10,60,35,.55) 50%,
        rgba(0,0,0,.25) 100%);
}
.hero-content {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 1.5rem 10rem;
    width: 100%;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    padding: 5px 16px;
    border-radius: 20px;
    font-size: 11.5px;
    color: var(--green-200);
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
}
.hero-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--green-400);
    display: block;
}
.hero h1 {
    font-size: clamp(2.8rem, 5.5vw, 5rem);
    color: #fff;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: .5rem;
    max-width: 720px;
}
.hero h1 span { color: var(--green-300); }
.hero p {
    color: rgba(255,255,255,.72);
    max-width: 530px;
    font-size: 1.05rem;
    margin: 1.25rem 0 2.25rem;
    line-height: 1.8;
}
.hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }

.btn-hero-primary {
    padding: 13px 30px;
    border-radius: 11px;
    font-size: 15px;
    font-weight: 700;
    color: var(--green-900);
    cursor: pointer;
    border: none;
    background: var(--green-300);
    transition: all .25s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Sans', sans-serif;
}
.btn-hero-primary:hover { background: #fff; transform: translateY(-1px); }
.btn-hero-outline {
    padding: 13px 26px;
    border-radius: 11px;
    font-size: 15px;
    font-weight: 500;
    color: #fff;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.08);
    transition: all .25s;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.btn-hero-outline:hover { background: rgba(255,255,255,.18); color: #fff; }

/* Stats bar */
.hero-stats {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(255,255,255,.06);
    backdrop-filter: blur(16px);
    border-top: 1px solid rgba(255,255,255,.1);
}
.hero-stats-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.4rem 1.5rem;
    display: flex;
    gap: 0;
}
.hero-stat {
    flex: 1;
    padding: 0 2rem 0 0;
    border-right: 1px solid rgba(255,255,255,.12);
    margin-right: 2rem;
}
.hero-stat:last-child { border-right: none; margin-right: 0; }
.hero-stat-num {
    font-size: 1.75rem;
    font-weight: 900;
    color: var(--green-300);
    font-family: 'Playfair Display', serif;
    line-height: 1;
}
.hero-stat-lbl {
    font-size: 12px;
    color: rgba(255,255,255,.5);
    margin-top: 4px;
}

/* ─── SECTIONS ─────────────────────────────────────────────── */
.section { padding: 5rem 1.5rem; }
.section-inner { max-width: 1200px; margin: 0 auto; }
.eyebrow {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--green-700);
    margin-bottom: .9rem;
}
.eyebrow::before { content: ''; width: 28px; height: 2px; background: var(--green-500); }
.sec-title {
    font-size: clamp(1.8rem, 3vw, 2.4rem);
    font-weight: 900;
    margin-bottom: .6rem;
    color: var(--slate-900);
}
.sec-sub {
    color: var(--slate-500);
    max-width: 540px;
    line-height: 1.8;
    font-size: .95rem;
}
.sec-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2.75rem;
    gap: 1rem;
    flex-wrap: wrap;
}

/* ─── CATEGORY CARDS (3 cards) ──────────────────────────────── */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}
.cat-card {
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    min-height: 360px;
    cursor: pointer;
    transition: transform .35s cubic-bezier(.25,.8,.25,1), box-shadow .35s;
    text-decoration: none;
    display: block;
}
.cat-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.18); }
.cat-card-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transition: transform .5s ease;
}
.cat-card:hover .cat-card-bg { transform: scale(1.07); }
.cat-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top,
        rgba(4,30,16,.92) 0%,
        rgba(4,30,16,.55) 45%,
        rgba(0,0,0,.08) 100%);
}
.cat-card-body {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 2rem;
}
.cat-card-number {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--green-300);
    margin-bottom: .5rem;
    opacity: .8;
}
.cat-card-icon {
    width: 44px; height: 44px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    backdrop-filter: blur(4px);
}
.cat-card h3 {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: .5rem;
    line-height: 1.25;
}
.cat-card p {
    color: rgba(255,255,255,.68);
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 1.1rem;
}
.cat-card-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--green-300);
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .02em;
    transition: gap .2s;
}
.cat-card:hover .cat-card-link { gap: 11px; }
.cat-count-badge {
    position: absolute;
    top: 1.1rem; right: 1.1rem;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    color: #fff;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
}

/* ─── DATA SDA CARDS ────────────────────────────────────────── */
.bg-slate { background: var(--slate-50); }
.data-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
.d-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--slate-100);
    transition: all .25s;
    display: block;
    color: inherit;
    text-decoration: none;
}
.d-card:hover {
    box-shadow: 0 12px 36px rgba(0,0,0,.09);
    transform: translateY(-4px);
    border-color: var(--green-200);
}
.d-card-img {
    height: 170px;
    position: relative;
    overflow: hidden;
    background: var(--slate-100);
}
.d-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .4s;
}
.d-card:hover .d-card-img img { transform: scale(1.08); }
.d-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: var(--green-700);
    color: #fff;
    padding: 3px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.d-body { padding: 1.15rem; }
.d-body h4 {
    font-size: 14.5px;
    font-weight: 600;
    line-height: 1.35;
    margin-bottom: .35rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--slate-900);
}
.d-body p {
    font-size: 12.5px;
    color: var(--slate-500);
    line-height: 1.6;
    margin-bottom: .75rem;
}
.d-meta {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    color: var(--slate-400);
}
.d-meta-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--slate-300);
    display: inline-block;
}

/* ─── NEWS CARDS ─────────────────────────────────────────────── */
.news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
.n-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--slate-100);
    transition: all .25s;
    display: block;
    color: inherit;
    text-decoration: none;
}
.n-card:hover {
    box-shadow: 0 12px 36px rgba(0,0,0,.09);
    transform: translateY(-4px);
    border-color: var(--green-200);
}
.n-card-img {
    height: 200px;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid var(--slate-100);
}

.n-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .6s ease, filter .4s ease;
}

/* Efek zoom + gelap dikit */
.n-card:hover .n-card-img img {
    transform: scale(1.12);
    filter: brightness(0.85);
}

/* Overlay gradient biar elegan */
.n-card-img::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,0.55),
        rgba(0,0,0,0.15),
        transparent
    );
}

/* Tag berita jadi lebih modern */
.n-tag {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(6px);
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .05em;
}
.n-body { padding: 1.15rem; }
.n-date { font-size: 12px; color: var(--slate-400); margin-bottom: .4rem; }
.n-body h4 {
    font-size: 14.5px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: .4rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--slate-900);
}
.n-body p { font-size: 12.5px; color: var(--slate-500); line-height: 1.6; }

/* ─── CTA BANNER ─────────────────────────────────────────────── */
.cta-banner {
    background: var(--green-900);
    border-radius: 20px;
    padding: 3.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
    flex-wrap: wrap;
}
.cta-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.cta-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,.03);
}
.cta-text h2 { color: #fff; font-size: 1.75rem; font-weight: 900; margin-bottom: .5rem; }
.cta-text p  { color: rgba(255,255,255,.6); font-size: .95rem; max-width: 420px; line-height: 1.7; }

@media (max-width: 900px) {
    .cat-grid { grid-template-columns: 1fr; }
    .data-grid, .news-grid { grid-template-columns: 1fr; }
    .hero-stats-inner { gap: 1.5rem; }
    .hero-stat { padding-right: 1.5rem; margin-right: 1.5rem; }
    .cta-banner { padding: 2rem; }
    .sec-header { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

{{-- ══════════════ HERO ══════════════ --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">Portal Informasi Resmi</div>
        <h1>Sumber Daya Alam<br><span>Kota Palembang</span></h1>
        <p>Portal informasi dan manajemen sumber daya alam untuk pengelolaan yang berkelanjutan dan transparan bagi seluruh masyarakat Kota Palembang di tepi Sungai Musi.</p>
        <div class="hero-cta">
            <a href="/sda" class="btn-hero-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                </svg>
                Jelajahi Data SDA
            </a>
            <a href="/news" class="btn-hero-outline">Berita Terbaru →</a>
        </div>
    </div>

    <div class="hero-stats">
        <div class="hero-stats-inner">
            <div class="hero-stat">
                <div class="hero-stat-num">{{ $totalSda }}+</div>
                <div class="hero-stat-lbl">Data SDA Terdaftar</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">3</div>
                <div class="hero-stat-lbl">Kategori Utama</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">{{ $totalKategori }}</div>
                <div class="hero-stat-lbl">Bidang Dikelola</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">24/7</div>
                <div class="hero-stat-lbl">Akses Publik Terbuka</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ KATEGORI SDA (FIX 3) ══════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <div class="eyebrow">Kategori SDA</div>
                <h2 class="sec-title">Kategori Sumber Daya Alam</h2>
                <p class="sec-sub">Tiga bidang utama pengelolaan SDA Kota Palembang</p>
            </div>
        </div>

        @php
        $fixedCategories = [
    [
        'name' => 'Pertanian, Kehutanan, Sungai & Perikanan',
        'desc' => 'Pengelolaan hasil pertanian, hutan, sungai Musi, dan perikanan di wilayah Palembang.',
        'img'  => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200&q=90',
        'icon' => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
        'link' => '/sda?category=1'
    ],
    [
        'name' => 'Pertambangan & Lingkungan Hidup',
        'desc' => 'Pengelolaan sumber daya tambang serta pelestarian lingkungan hidup.',
        'img'  => 'https://images.unsplash.com/photo-1581091870622-1e7e0e0a1f0d?w=1200&q=90',
        'icon' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
        'link' => '/sda?category=2'
    ],
    [
        'name' => 'Energi & Air',
        'desc' => 'Pengelolaan energi serta sumber daya air untuk kebutuhan masyarakat.',
        'img'  => 'https://images.unsplash.com/photo-1509395176047-4a66953fd231?w=1200&q=90',
        'icon' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'link' => '/sda?category=3'
    ],
];
        @endphp

        <div class="cat-grid">
            @foreach($fixedCategories as $index => $cat)
            <a href="{{ $cat['link'] }}" class="cat-card">
                <div class="cat-card-bg" style="background-image:url('{{ $cat['img'] }}');"></div>
                <div class="cat-card-overlay"></div>

                <div class="cat-count-badge">Kategori</div>

                <div class="cat-card-body">
                    <div class="cat-card-number">Kategori {{ $index + 1 }}</div>

                    <div class="cat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            {!! $cat['icon'] !!}
                        </svg>
                    </div>

                    <h3>{{ $cat['name'] }}</h3>
                    <p>{{ $cat['desc'] }}</p>

                    <div class="cat-card-link">
                        Lihat Data
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════ DATA SDA TERBARU (FIX FINAL SESUAI PERMINTAAN) ══════════════ --}}
<section class="section bg-slate" style="padding-top:4rem;padding-bottom:4rem;">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <div class="eyebrow">Database</div>
                <h2 class="sec-title">Data SDA Terbaru</h2>
                <p class="sec-sub">Data sumber daya alam terkini yang terdaftar di Portal SDA Kota Palembang</p>
            </div>
            <a href="/sda"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:9px;background:var(--green-700);color:#fff;font-size:13.5px;font-weight:600;">
                Lihat Semua →
            </a>
        </div>

        {{-- 🔥 IMAGE SMART SESUAI KATEGORI --}}
        @php
        function getSdaImage($category) {
    $category = strtolower($category);

    if (str_contains($category, 'sungai')) {
        return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=90';
    }

    if (str_contains($category, 'pertanian')) {
        return 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1200&q=90';
    }

    if (str_contains($category, 'hutan') || str_contains($category, 'kehutanan')) {
        return 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=1200&q=90';
    }

    if (str_contains($category, 'tambang') || str_contains($category, 'lingkungan')) {
        return 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&q=90';
    }

    if (str_contains($category, 'energi') || str_contains($category, 'air')) {
        return 'https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?w=1200&q=90';
    }

    return 'https://images.unsplash.com/photo-1470770903676-69b98201ea1c?w=1200&q=90';
}
        @endphp

        @if($latestSda->count() > 0)
        <div class="data-grid">

            @foreach($latestSda as $sda)
            @php
                $catName = $sda->category->name ?? 'SDA';
                $imgUrl = $sda->image 
                    ? asset('storage/'.$sda->image) 
                    : getSdaImage($catName);
            @endphp

            <a href="/detail-sda/{{ $sda->id }}" class="d-card">

                {{-- 🔥 GAMBAR --}}
                <div class="d-card-img" style="position:relative;">
                    <img src="{{ $imgUrl }}" alt="{{ $sda->title }}" loading="lazy">

                    {{-- overlay --}}
                    <div style="
                        position:absolute;
                        inset:0;
                        background:linear-gradient(to top, rgba(0,0,0,.5), transparent);
                    "></div>

                    {{-- badge --}}
                    <div style="
                        position:absolute;
                        top:12px;
                        left:12px;
                        background:rgba(0,0,0,.6);
                        backdrop-filter:blur(6px);
                        color:#fff;
                        padding:5px 12px;
                        border-radius:20px;
                        font-size:11px;
                        font-weight:600;
                    ">
                        {{ $catName }}
                    </div>
                </div>

                {{-- BODY --}}
                <div class="d-body">
                    <h4 style="font-size:15px;font-weight:700;">
                        {{ $sda->title }}
                    </h4>

                    <p style="margin-top:4px;">
                        {{ Str::limit($sda->description, 90) }}
                    </p>

                    <div class="d-meta" style="margin-top:8px;">
                        📍 {{ $sda->location }}
                        <span class="d-meta-dot"></span>
                        {{ $sda->created_at->year }}
                    </div>
                </div>

            </a>
            @endforeach

        </div>
        @else
        <div style="text-align:center;padding:3rem;color:var(--slate-400);">
            <p>Belum ada data SDA. 
                <a href="{{ route('login') }}" style="color:var(--green-700);">
                    Masuk
                </a> untuk menambahkan.
            </p>
        </div>
        @endif

    </div>
</section>

{{-- ══════════════ BERITA TERKINI (PREMIUM UI) ══════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <div class="eyebrow">Informasi</div>
                <h2 class="sec-title">Berita Terkini</h2>
                <p class="sec-sub">Kabar terbaru seputar pengelolaan sumber daya alam Kota Palembang</p>
            </div>
            <a href="/news"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:9px;background:var(--green-700);color:#fff;font-size:13.5px;font-weight:600;">
                Lihat Semua →
            </a>
        </div>

        {{-- 🔥 FUNCTION GAMBAR OTOMATIS --}}
        @php
        function getNewsImage($text) {
    $text = strtolower($text);

    if (str_contains($text, 'sungai') || str_contains($text, 'air')) {
        return 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1200&q=90';
    }

    if (str_contains($text, 'energi') || str_contains($text, 'listrik')) {
        return 'https://images.unsplash.com/photo-1509395176047-4a66953fd231?w=1200&q=90';
    }

    if (str_contains($text, 'tambang') || str_contains($text, 'mineral')) {
        return 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&q=90';
    }

    if (str_contains($text, 'hutan') || str_contains($text, 'lingkungan')) {
        return 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=1200&q=90';
    }

    if (str_contains($text, 'pertanian') || str_contains($text, 'sawah')) {
        return 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1200&q=90';
    }

    return 'https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?w=1200&q=90';
}
        @endphp

        @if($latestNews->count() > 0)
        <div class="news-grid">

            @foreach($latestNews as $news)
            @php
                $imgUrl = $news->image 
                    ? asset('storage/'.$news->image) 
                    : getNewsImage($news->title . ' ' . $news->content);
            @endphp

            <a href="/detail-news/{{ $news->id }}" class="n-card">

                {{-- 🔥 GAMBAR --}}
                <div class="n-card-img" style="position:relative;overflow:hidden;">
                    <img src="{{ $imgUrl }}" alt="{{ $news->title }}" loading="lazy">

                    {{-- overlay gradient --}}
                    <div style="
                        position:absolute;
                        inset:0;
                        background:linear-gradient(to top, rgba(0,0,0,.6), transparent);
                    "></div>

                    {{-- label + tanggal --}}
                    <div style="
                        position:absolute;
                        bottom:12px;
                        left:12px;
                        color:#fff;
                        z-index:2;
                    ">
                        <div style="
                            background:rgba(0,0,0,.6);
                            backdrop-filter:blur(6px);
                            padding:4px 10px;
                            border-radius:20px;
                            font-size:11px;
                            margin-bottom:6px;
                            display:inline-block;
                        ">
                            Berita
                        </div>

                        <div style="font-size:12px;opacity:.9;">
                            {{ $news->created_at->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>

                {{-- 🔥 BODY --}}
                <div class="n-body">
                    <h4 style="font-size:15px;font-weight:700;">
                        {{ $news->title }}
                    </h4>

                    <p style="margin-top:4px;">
                        {{ Str::limit($news->content, 100) }}
                    </p>
                </div>

            </a>
            @endforeach

        </div>

        @else
        <div style="text-align:center;padding:3rem;color:var(--slate-400);">
            <p>Belum ada berita tersedia.</p>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════ CTA BANNER ══════════════ --}}
<section class="section" style="padding-top:0;padding-bottom:5rem;">
    <div class="section-inner">
        <div class="cta-banner">
            <div class="cta-text">
                <h2>Temukan Masalah SDA?<br>Laporkan Sekarang</h2>
                <p>Bantu pemerintah mengelola sumber daya alam Kota Palembang dengan lebih baik. Setiap laporan Anda sangat berarti untuk kelestarian alam bersama.</p>
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap;position:relative;">
                <a href="{{ route('login') }}" style="padding:13px 28px;border-radius:11px;font-size:15px;font-weight:700;background:var(--green-300);color:var(--green-900);display:inline-flex;align-items:center;gap:8px;transition:all .25s;font-family:'DM Sans',sans-serif;" onmouseover="this.style.background='#fff'" onmouseout="this.style.background='var(--green-300)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Buat Laporan
                </a>
                <a href="/sda" style="padding:13px 24px;border-radius:11px;font-size:15px;font-weight:500;border:1px solid rgba(255,255,255,.3);color:#fff;background:rgba(255,255,255,.08);display:inline-flex;align-items:center;transition:all .25s;font-family:'DM Sans',sans-serif;" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                    Jelajahi Data
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Fade-in on scroll
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.08 });

document.querySelectorAll('.cat-card, .d-card, .n-card').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = `opacity .5s ease ${i * 0.07}s, transform .5s ease ${i * 0.07}s`;
    observer.observe(el);
});
</script>
@endpush

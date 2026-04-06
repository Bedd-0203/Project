<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal SDA') — Kota Palembang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        /* ── ROOT VARIABLES ── */
        :root {
            --green-900:#063d2a; --green-800:#0a5238; --green-700:#0f6e4d;
            --green-600:#148a60; --green-500:#1aaa76; --green-400:#3ec48f;
            --green-300:#7ddbb2; --green-200:#b8edd5; --green-100:#e0f5ec; --green-50:#f2faf6;
            --slate-900:#0f172a; --slate-800:#1e293b; --slate-700:#334155;
            --slate-600:#475569; --slate-500:#64748b; --slate-400:#94a3b8;
            --slate-300:#cbd5e1; --slate-200:#e2e8f0; --slate-100:#f1f5f9; --slate-50:#f8fafc;
            --amber-500:#d97706; --amber-100:#fef3c7;
            --danger:#dc2626; --danger-light:#fee2e2;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'DM Sans', sans-serif; color: var(--slate-900); background: #fff; line-height: 1.65; font-size: 15px; }
        h1,h2,h3,h4 { font-family: 'Playfair Display', serif; line-height: 1.2; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }
        input, select, textarea, button { font-family: inherit; }

        /* ── SHARED BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 8px;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer; border: none; transition: all .2s;
            font-family: 'DM Sans', sans-serif; line-height: 1;
        }
        .btn-primary { background: var(--green-700); color: #fff; }
        .btn-primary:hover { background: var(--green-800); color: #fff; }
        .btn-outline { background: #fff; color: var(--slate-700); border: 1px solid var(--slate-200); }
        .btn-outline:hover { background: var(--slate-50); }
        .btn-sm { padding: 5px 12px; font-size: 12.5px; }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,.97);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--slate-100);
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            height: 64px;
            gap: 1.5rem;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0; cursor: pointer;
        }
        .nav-brand-icon {
            width: 36px; height: 36px;
            background: var(--green-700);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-brand-text strong {
            font-size: 13px; font-weight: 700;
            color: var(--slate-900); display: block;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-brand-text span {
            font-size: 10px; color: var(--slate-400);
            letter-spacing: .07em; text-transform: uppercase;
        }
        .nav-links { display: flex; gap: 4px; flex: 1; }
        .nav-link {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            color: var(--slate-500);
            transition: all .2s;
            white-space: nowrap;
        }
        .nav-link:hover { color: var(--slate-900); background: var(--slate-100); }
        .nav-link.active { color: var(--green-800); background: var(--green-100); }
        .nav-actions { display: flex; gap: 8px; margin-left: auto; flex-shrink: 0; }
        .nav-btn-ghost {
            padding: 7px 16px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            color: var(--slate-700); cursor: pointer;
            border: 1px solid var(--slate-200);
            background: none; transition: all .2s;
            white-space: nowrap;
        }
        .nav-btn-ghost:hover { background: var(--slate-50); }
        .nav-btn-primary {
            padding: 7px 18px; border-radius: 8px;
            font-size: 13.5px; font-weight: 700;
            color: #fff; cursor: pointer;
            border: none; background: var(--green-700);
            transition: all .2s; white-space: nowrap;
        }
        .nav-btn-primary:hover { background: var(--green-800); }

        /* ── FLASH ── */
        .flash {
            padding: 12px 1.5rem;
            font-size: 14px;
            font-weight: 500;
        }
        .flash-success { background: #dcfce7; color: #15803d; border-left: 4px solid var(--green-500); }
        .flash-error   { background: var(--danger-light); color: #991b1b; border-left: 4px solid var(--danger); }

        /* ── FOOTER ── */
        .footer {
            background: var(--slate-900);
            color: #fff;
            padding: 4rem 1.5rem 2rem;
        }
        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 3rem;
        }
        .footer-brand p {
            font-size: 13px;
            color: rgba(255,255,255,.5);
            margin-top: .75rem;
            line-height: 1.75;
            max-width: 300px;
        }
        .footer-col h4 {
            font-size: 11.5px; font-weight: 700;
            color: rgba(255,255,255,.35);
            text-transform: uppercase; letter-spacing: .09em;
            margin-bottom: 1rem;
            font-family: 'DM Sans', sans-serif;
        }
        .footer-col a {
            display: block; font-size: 13px;
            color: rgba(255,255,255,.55);
            margin-bottom: .5rem; transition: color .2s;
        }
        .footer-col a:hover { color: var(--green-300); }
        .footer-bottom {
            max-width: 1200px; margin: 2rem auto 0;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,.08);
            text-align: center;
            font-size: 12px;
            color: rgba(255,255,255,.25);
        }

        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<header class="navbar">
    <div class="nav-inner">
        <a href="{{ url('/') }}" class="nav-brand">
            <div class="nav-brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                    <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                </svg>
            </div>
            <div class="nav-brand-text">
                <strong>Portal SDA</strong>
                <span>Kota Palembang</span>
            </div>
        </a>

        <nav class="nav-links">
            <a href="{{ url('/') }}"    class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ url('/sda') }}"  class="nav-link {{ request()->is('sda*') ? 'active' : '' }}">Data SDA</a>
            <a href="{{ url('/news') }}" class="nav-link {{ request()->is('news*') ? 'active' : '' }}">Berita</a>
        </nav>

        <div class="nav-actions">
            @auth
                @php
                $dashRoute = match(auth()->user()->role) {
                    'admin'      => route('admin.dashboard'),
                    'petugas'    => route('petugas.dashboard'),
                    'masyarakat' => route('masyarakat.dashboard'),
                    default      => url('/'),
                };
                @endphp
                <a href="{{ $dashRoute }}" class="nav-btn-ghost">
                    👤 {{ Str::limit(auth()->user()->name, 18) }}
                </a>
                <a href="{{ route('logout') }}" class="nav-btn-ghost" style="color:var(--danger);border-color:#fca5a5;">Keluar</a>
            @else
                <a href="{{ route('login') }}" class="nav-btn-ghost">Masuk</a>
                <a href="{{ route('login') }}" class="nav-btn-primary">Daftar</a>
            @endauth
        </div>
    </div>
</header>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash flash-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error">✕ {{ session('error') }}</div>
@endif

{{-- Page Content --}}
@yield('content')

{{-- ═══ FOOTER ═══ --}}
<footer class="footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:.75rem;">
                <div style="width:32px;height:32px;background:var(--green-700);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                    </svg>
                </div>
                <div>
                    <strong style="font-size:13px;color:#fff;display:block;font-family:'DM Sans',sans-serif;">Portal SDA</strong>
                    <span style="font-size:10px;color:var(--green-300);letter-spacing:.07em;text-transform:uppercase;">Kota Palembang</span>
                </div>
            </div>
            <p>Portal informasi dan manajemen sumber daya alam untuk pengelolaan yang berkelanjutan dan transparan bagi seluruh masyarakat Kota Palembang di tepi Sungai Musi.</p>
        </div>
        <div class="footer-col">
            <h4>Navigasi</h4>
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ url('/sda') }}">Data SDA</a>
            <a href="{{ url('/news') }}">Berita</a>
            <a href="{{ route('login') }}">Masuk</a>
        </div>
        <div class="footer-col">
            <h4>Kontak</h4>
            <a href="#">Jl. POM IX No.1, Palembang</a>
            <a href="#">(0711) 123-456</a>
            <a href="#">sda@palembang.go.id</a>
            <a href="#">Senin – Jumat, 08.00–16.00</a>
        </div>
    </div>
    <div class="footer-bottom">
        © {{ date('Y') }} Portal SDA Kota Palembang — Dinas Pengelolaan Sumber Daya Alam. Hak cipta dilindungi.
    </div>
</footer>

@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Portal SDA Palembang</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{--green-900:#063d2a;--green-800:#0a5238;--green-700:#0f6e4d;--green-300:#7ddbb2;--green-100:#e0f5ec;--slate-900:#0f172a;--slate-700:#334155;--slate-500:#64748b;--slate-300:#cbd5e1;--slate-200:#e2e8f0;--slate-100:#f1f5f9;--danger:#dc2626;}
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'DM Sans',sans-serif;display:flex;min-height:100vh;background:#fff;}
        h1,h2,h3{font-family:'Playfair Display',serif;}

        .left{flex:1;background:var(--green-900);display:flex;flex-direction:column;justify-content:center;padding:3.5rem;position:relative;overflow:hidden;}
        .left-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1540206395-68808572332f?w=900&q=70')center/cover;opacity:.12;}
        .left-content{position:relative;}
        .brand{display:flex;align-items:center;gap:10px;margin-bottom:2.5rem;}
        .brand-icon{width:36px;height:36px;background:var(--green-700);border-radius:10px;display:flex;align-items:center;justify-content:center;}
        .left h2{font-size:2.3rem;color:#fff;font-weight:900;line-height:1.2;margin-bottom:1rem;}
        .left p{color:rgba(255,255,255,.62);font-size:.95rem;line-height:1.8;max-width:380px;}
        .feat-list{margin-top:2rem;display:flex;flex-direction:column;gap:.6rem;}
        .feat-item{display:flex;align-items:center;gap:10px;font-size:13.5px;color:rgba(255,255,255,.65);}
        .feat-dot{width:6px;height:6px;border-radius:50%;background:var(--green-300);flex-shrink:0;}

        .right{width:480px;display:flex;align-items:center;justify-content:center;padding:2.5rem;background:#fff;}
        .form-wrap{width:100%;max-width:380px;}
        .form-wrap h3{font-size:1.7rem;font-weight:900;color:var(--slate-900);margin-bottom:.35rem;}
        .form-wrap .sub{font-size:14px;color:var(--slate-500);margin-bottom:2rem;}
        .form-group{margin-bottom:1rem;}
        .form-label{display:block;font-size:13px;font-weight:600;color:var(--slate-700);margin-bottom:.4rem;}
        .form-input{width:100%;padding:10px 14px;border-radius:10px;border:1.5px solid var(--slate-200);font-size:14px;color:var(--slate-900);outline:none;transition:border-color .2s;font-family:'DM Sans',sans-serif;}
        .form-input:focus{border-color:var(--green-700);box-shadow:0 0 0 3px var(--green-100);}
        .form-input.is-invalid{border-color:var(--danger);}
        .error-msg{font-size:12px;color:var(--danger);margin-top:.3rem;}
        .btn-submit{width:100%;padding:12px;border-radius:10px;font-size:15px;font-weight:700;color:#fff;background:var(--green-700);border:none;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;margin-top:.5rem;}
        .btn-submit:hover{background:var(--green-800);}
        .remember-row{display:flex;align-items:center;justify-content:space-between;margin:1rem 0 .25rem;}
        .remember-row label{display:flex;align-items:center;gap:7px;font-size:13px;color:var(--slate-600);cursor:pointer;}
        @media(max-width:768px){.left{display:none;}.right{width:100%;}}
    </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left">
    <div class="left-bg"></div>
    <div class="left-content">
        <div class="brand">
            <div class="brand-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/></svg>
            </div>
            <div>
                <strong style="font-size:13px;color:#fff;display:block;">Portal SDA</strong>
                <span style="font-size:10px;color:var(--green-300);letter-spacing:.07em;text-transform:uppercase;">Kota Palembang</span>
            </div>
        </div>

        <h2>Kelola Sumber Daya Alam Dengan Mudah</h2>
        <p>Sistem informasi terpadu untuk pengelolaan sumber daya alam Kota Palembang yang transparan dan berkelanjutan.</p>

        <div class="feat-list">
            @foreach(['Data SDA real-time & transparan', 'Laporan masyarakat terintegrasi', 'Manajemen berita & informasi', 'Akses multi-role (Admin, Petugas, Masyarakat)'] as $feat)
            <div class="feat-item"><div class="feat-dot"></div>{{ $feat }}</div>
            @endforeach
        </div>
    </div>
</div>

{{-- RIGHT PANEL (FORM) --}}
<div class="right">
    <div class="form-wrap">
        <h3>Selamat Datang</h3>
        <p class="sub">Masuk ke akun Portal SDA Anda</p>

        {{-- Global error --}}
        @if($errors->any())
        <div style="background:#fee2e2;border-left:4px solid var(--danger);padding:11px 14px;border-radius:8px;font-size:13.5px;color:#991b1b;margin-bottom:1.25rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       placeholder="email@contoh.com" value="{{ old('email') }}" required autofocus>
                @error('email')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="••••••••" required>
                @error('password')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <p style="text-align:center;font-size:13px;color:var(--slate-500);margin-top:1.5rem;">
            Belum punya akun?
            <span style="color:var(--green-700);font-weight:600;cursor:pointer;" onclick="alert('Hubungi administrator untuk pendaftaran.')">Hubungi Admin</span>
        </p>

        <p style="text-align:center;margin-top:2rem;">
            <a href="/" style="font-size:13px;color:var(--slate-400);">← Kembali ke Beranda</a>
        </p>
    </div>
</div>

</body>
</html>

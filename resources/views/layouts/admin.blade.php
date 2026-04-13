<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Portal SDA</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root {
            --green-900:#063d2a;--green-800:#0a5238;--green-700:#0f6e4d;
            --green-600:#148a60;--green-500:#1aaa76;--green-300:#7ddbb2;
            --green-100:#e0f5ec;--green-50:#f2faf6;
            --slate-900:#0f172a;--slate-700:#334155;--slate-600:#475569;
            --slate-500:#64748b;--slate-400:#94a3b8;--slate-300:#cbd5e1;
            --slate-200:#e2e8f0;--slate-100:#f1f5f9;--slate-50:#f8fafc;
            --amber-500:#d97706;--amber-100:#fef3c7;
            --danger:#dc2626;--sidebar-w:240px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'DM Sans',sans-serif;color:var(--slate-900);background:var(--slate-100);line-height:1.65;font-size:15px;display:flex;min-height:100vh;}
        h1,h2,h3,h4{font-family:'Playfair Display',serif;line-height:1.2;}
        a{text-decoration:none;color:inherit;}

        /* SIDEBAR */
        .sidebar{width:var(--sidebar-w);background:#fff;border-right:1px solid var(--slate-100);display:flex;flex-direction:column;position:fixed;top:0;bottom:0;overflow-y:auto;z-index:50;}
        .sidebar-brand{padding:1.1rem 1.25rem;border-bottom:1px solid var(--slate-100);display:flex;align-items:center;gap:10px;}
        .sidebar-brand-icon{width:32px;height:32px;background:var(--green-700);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .sidebar-brand-text strong{font-size:12.5px;font-weight:700;display:block;font-family:'DM Sans',sans-serif;}
        .sidebar-brand-text span{font-size:10px;color:var(--green-600);text-transform:uppercase;letter-spacing:.06em;}
        .sidebar-section{padding:.6rem 0;}
        .sidebar-label{font-size:10.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--slate-400);padding:.5rem 1.25rem .25rem;}
        .sidebar-item{display:flex;align-items:center;gap:10px;padding:9px 1.25rem;font-size:13.5px;font-weight:500;color:var(--slate-500);cursor:pointer;border:none;background:none;width:100%;text-align:left;transition:all .15s;}
        .sidebar-item:hover{color:var(--slate-900);background:var(--slate-50);}
        .sidebar-item.active{color:var(--green-800);background:var(--green-50);font-weight:600;border-right:2px solid var(--green-600);}
        .sidebar-item svg{width:15px;height:15px;flex-shrink:0;}
        .sidebar-divider{height:1px;background:var(--slate-100);margin:.5rem 0;}
        .sidebar-item.danger{color:var(--danger);}
        .sidebar-item.danger:hover{background:#fff5f5;}

        /* MAIN */
        .admin-main{margin-left:var(--sidebar-w);flex:1;padding:2rem 2.5rem;min-height:100vh;}

        /* TOPBAR */
        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;}
        .topbar h1{font-size:1.7rem;font-weight:800;}
        .topbar p{font-size:13.5px;color:var(--slate-500);margin-top:3px;}

        /* CARDS & TABLES */
        .card{background:#fff;border-radius:14px;border:1px solid var(--slate-100);}
        .card-header{padding:1rem 1.25rem;border-bottom:1px solid var(--slate-100);display:flex;justify-content:space-between;align-items:center;}
        .card-header h3{font-size:14px;font-weight:600;font-family:'DM Sans',sans-serif;}
        .card-body{padding:1.25rem;}
        table{width:100%;border-collapse:collapse;}
        th{font-size:11.5px;font-weight:700;color:var(--slate-400);text-align:left;padding:.65rem 1.25rem;background:var(--slate-50);letter-spacing:.05em;text-transform:uppercase;}
        td{font-size:13.5px;padding:.8rem 1.25rem;border-bottom:1px solid var(--slate-50);color:var(--slate-700);vertical-align:middle;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:var(--slate-50);}

        /* STATS */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;}
        .stat-card{background:#fff;border-radius:12px;padding:1.1rem 1.25rem;border:1px solid var(--slate-100);display:flex;justify-content:space-between;align-items:center;}
        .stat-label{font-size:12px;color:var(--slate-500);margin-bottom:.3rem;font-weight:500;}
        .stat-val{font-size:1.7rem;font-weight:800;font-family:'Playfair Display',serif;line-height:1;}
        .stat-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;}
        .stat-icon.green{background:var(--green-100);color:var(--green-700);}
        .stat-icon.amber{background:var(--amber-100);color:var(--amber-500);}
        .stat-icon.blue{background:#dbeafe;color:#1d4ed8;}
        .stat-icon.red{background:#fee2e2;color:#dc2626;}

        /* BADGES */
        .badge{display:inline-flex;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;letter-spacing:.02em;}
        .badge-green{background:var(--green-100);color:var(--green-800);}
        .badge-amber{background:var(--amber-100);color:#92400e;}
        .badge-red{background:#fee2e2;color:#991b1b;}
        .badge-blue{background:#dbeafe;color:#1e40af;}
        .badge-gray{background:var(--slate-100);color:var(--slate-600);}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;transition:all .2s;font-family:'DM Sans',sans-serif;line-height:1;}
        .btn-primary{background:var(--green-700);color:#fff;}
        .btn-primary:hover{background:var(--green-800);}
        .btn-outline{background:#fff;color:var(--slate-700);border:1px solid var(--slate-200);}
        .btn-outline:hover{background:var(--slate-50);}
        .btn-danger{background:#fff;color:var(--danger);border:1px solid #fca5a5;}
        .btn-danger:hover{background:#fff5f5;}
        .btn-sm{padding:5px 12px;font-size:12.5px;}

        /* FORMS */
        .form-group{margin-bottom:1.1rem;}
        .form-label{display:block;font-size:13px;font-weight:600;color:var(--slate-700);margin-bottom:.4rem;}
        .form-control{width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid var(--slate-200);font-size:14px;color:var(--slate-900);outline:none;transition:border-color .2s;background:#fff;}
        .form-control:focus{border-color:var(--green-500);}
        .form-control::placeholder{color:var(--slate-400);}
        textarea.form-control{resize:vertical;min-height:100px;}
        .form-error{font-size:12px;color:var(--danger);margin-top:.3rem;}

        /* ALERT */
        .alert{padding:12px 16px;border-radius:10px;font-size:13.5px;margin-bottom:1.25rem;}
        .alert-success{background:#dcfce7;color:#15803d;border-left:4px solid var(--green-500);}
        .alert-danger{background:#fee2e2;color:#991b1b;border-left:4px solid var(--danger);}

        /* PAGINATION */
        .pagination{display:flex;gap:4px;align-items:center;justify-content:center;padding:1.25rem;}
        .pagination a,.pagination span{padding:6px 12px;border-radius:7px;font-size:13px;border:1px solid var(--slate-200);color:var(--slate-600);}
        .pagination .active span{background:var(--green-700);color:#fff;border-color:var(--green-700);}
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/></svg>
        </div>
        <div class="sidebar-brand-text">
            <strong>Portal SDA</strong>
            <span>{{ ucfirst(auth()->user()->role ?? 'Panel') }}</span>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-label">Menu Utama</div>
        @yield('sidebar-menu')
    </div>

    <div class="sidebar-divider"></div>
    <div style="padding:.5rem 0 1rem;">
        <a href="{{ url('/') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Ke Beranda
        </a>
        <a href="{{ route('logout') }}" class="sidebar-item danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Keluar
        </a>
    </div>
</aside>

{{-- ===== MAIN ===== --}}
<main class="admin-main">

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">✕ {{ session('error') }}</div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>
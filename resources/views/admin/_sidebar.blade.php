{{-- ═══ SIDEBAR ADMIN ═══ --}}
<style>
.sidebar-admin {
    width: 240px;
    min-height: 100vh;
    background: linear-gradient(180deg, #0f6e4d, #063d2a);
    color: #fff;
    position: fixed;
    top: 64px; /* menyesuaikan navbar */
    left: 0;
    padding: 20px 15px;
}

.sidebar-admin h3 {
    font-size: 14px;
    margin-bottom: 20px;
    opacity: 0.8;
}

.sidebar-admin a {
    display: block;
    padding: 10px 12px;
    border-radius: 8px;
    color: #e2e8f0;
    font-size: 14px;
    margin-bottom: 6px;
    transition: 0.2s;
}

.sidebar-admin a:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.sidebar-admin a.active {
    background: #1aaa76;
    color: #fff;
    font-weight: 600;
}

/* biar konten tidak ketutup sidebar */
.admin-content {
    margin-left: 260px;
    padding: 20px;
}

@media(max-width:768px){
    .sidebar-admin {
        position: relative;
        width: 100%;
        top: 0;
    }

    .admin-content {
        margin-left: 0;
    }
}
</style>

<div class="sidebar-admin">
    <h3>⚙️ ADMIN PANEL</h3>

    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        📊 Dashboard
    </a>

    <a href="{{ url('/admin/sda') }}"
       class="{{ request()->is('admin/sda*') ? 'active' : '' }}">
        🌿 Data SDA
    </a>

    <a href="{{ url('/admin/news') }}"
       class="{{ request()->is('admin/news*') ? 'active' : '' }}">
        📰 Berita SDA
    </a>

    <a href="{{ url('/admin/user') }}"
       class="{{ request()->is('admin/user*') ? 'active' : '' }}">
        👥 Kelola User
    </a>

    <hr style="border-color: rgba(255,255,255,0.1); margin:15px 0;">

    <a href="{{ url('/') }}">
        ⬅️ Kembali ke Website
    </a>
</div>
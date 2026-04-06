@extends('layouts.admin')
@section('title', 'Kelola User')

@section('sidebar-menu')
@foreach([['admin.dashboard','Dashboard'],['admin.sda.index','Data SDA'],['admin.news.index','Berita SDA'],['admin.notifications','Laporan Masuk'],['admin.user.index','Kelola User']] as [$r,$l])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>
    {{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Kelola User</h1><p>Manajemen pengguna sistem Portal SDA</p></div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah User
    </a>
</div>

<form method="GET" style="background:#fff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;border:1px solid var(--slate-100);display:flex;gap:10px;">
    <div style="flex:1;display:flex;align-items:center;gap:9px;background:var(--slate-50);border-radius:8px;padding:8px 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--slate-400);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}" style="border:none;background:none;font-size:13.5px;outline:none;color:var(--slate-900);font-family:'DM Sans',sans-serif;width:100%;">
    </div>
    <select name="role" style="padding:8px 13px;border-radius:8px;border:1px solid var(--slate-200);font-size:13.5px;color:var(--slate-700);background:#fff;outline:none;" onchange="this.form.submit()">
        <option value="">Semua Role</option>
        @foreach(['admin','petugas','masyarakat'] as $r)
            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
</form>

<div class="card">
    <div class="card-header"><h3>Total: {{ $users->total() }} User</h3></div>
    <table>
        <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th width="130">Aksi</th></tr></thead>
        <tbody>
            @forelse($users as $i => $u)
            <tr>
                <td style="color:var(--slate-400);">{{ $users->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:var(--green-100);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--green-800);flex-shrink:0;">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <span style="font-weight:500;font-size:13.5px;">{{ $u->name }}</span>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--slate-500);">{{ $u->email }}</td>
                <td>
                    <span class="badge {{ $u->role === 'admin' ? 'badge-red' : ($u->role === 'petugas' ? 'badge-blue' : 'badge-green') }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td style="font-size:12.5px;color:var(--slate-400);">{{ $u->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.user.edit', $u) }}" class="btn btn-outline btn-sm">Edit</a>
                        @if($u->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.user.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">Tidak ada user.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())<div class="pagination">{{ $users->links() }}</div>@endif
</div>
@endsection
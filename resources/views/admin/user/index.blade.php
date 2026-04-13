@extends('layouts.admin')
@section('title', 'Kelola User')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div><h1>Kelola User</h1><p>Manajemen pengguna sistem Portal SDA</p></div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah User
    </a>
</div>

<form method="GET" class="search-bar">
    <div class="search-input-wrap">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             style="color:var(--slate-400);flex-shrink:0;">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}">
    </div>
    <select name="role" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">Semua Role</option>
        @foreach(['admin'=>'Admin','petugas'=>'Petugas','masyarakat'=>'Masyarakat'] as $val=>$lbl)
            <option value="{{ $val }}" {{ request('role') === $val ? 'selected':'' }}>{{ $lbl }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if(request('q') || request('role'))
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

{{-- Stat ringkas --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.25rem;">
    @foreach(['admin'=>['Admin','badge-red'],'petugas'=>['Petugas','badge-blue'],'masyarakat'=>['Masyarakat','badge-green']] as $r=>[$lbl,$cls])
    <div class="card" style="padding:1rem 1.25rem;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <p style="font-size:12px;color:var(--slate-500);margin-bottom:.3rem;">{{ $lbl }}</p>
            <p style="font-size:1.5rem;font-weight:800;font-family:'Playfair Display',serif;">
                {{ \App\Models\User::where('role',$r)->count() }}
            </p>
        </div>
        <span class="badge {{ $cls }}">{{ ucfirst($r) }}</span>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h3>Total: <strong>{{ $users->total() }}</strong> Pengguna</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bergabung</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $u)
            <tr>
                <td style="color:var(--slate-400);font-size:13px;">{{ $users->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;
                            background:{{ $u->role==='admin'?'#fee2e2':($u->role==='petugas'?'#dbeafe':'var(--green-100)') }};
                            color:{{ $u->role==='admin'?'#991b1b':($u->role==='petugas'?'#1e40af':'var(--green-800)') }};">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <p style="font-size:13.5px;font-weight:600;color:var(--slate-900);">{{ $u->name }}</p>
                            @if($u->id === auth()->id())
                                <span style="font-size:11px;color:var(--green-600);font-weight:600;">● Anda</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--slate-500);">{{ $u->email }}</td>
                <td>
                    <span class="badge {{ $u->role==='admin'?'badge-red':($u->role==='petugas'?'badge-blue':'badge-green') }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td style="font-size:12.5px;color:var(--slate-400);">{{ $u->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.user.show', $u) }}" class="btn btn-outline btn-sm">Detail</a>
                        <a href="{{ route('admin.user.edit', $u) }}" class="btn btn-outline btn-sm">Edit</a>
                        @if($u->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.user.destroy', $u) }}"
                              onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--slate-400);">Belum ada user.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())<div style="padding:1rem 1.25rem;">{{ $users->links() }}</div>@endif
</div>

@endsection

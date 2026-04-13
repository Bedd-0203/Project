@extends('layouts.admin')
@section('title', $user->name)
@section('sidebar-menu') @include('admin._sidebar') @endsection
@section('content')
<div class="topbar">
    <div><h1>Detail User</h1></div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>
<div style="max-width:700px;">
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--slate-100);">
                <div style="width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;flex-shrink:0;
                    background:{{ $user->role==='admin'?'#fee2e2':($user->role==='petugas'?'#dbeafe':'var(--green-100)') }};
                    color:{{ $user->role==='admin'?'#991b1b':($user->role==='petugas'?'#1e40af':'var(--green-800)') }};">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:.3rem;">{{ $user->name }}</h2>
                    <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
                        <span class="badge {{ $user->role==='admin'?'badge-red':($user->role==='petugas'?'badge-blue':'badge-green') }}">{{ ucfirst($user->role) }}</span>
                        <span style="font-size:13px;color:var(--slate-500);">{{ $user->email }}</span>
                        @if($user->id===auth()->id())<span style="font-size:12px;color:var(--green-600);font-weight:600;">● Akun Anda</span>@endif
                    </div>
                </div>
            </div>
            @foreach(['ID Pengguna'=>'#'.$user->id,'Nama Lengkap'=>$user->name,'Email'=>$user->email,'Role'=>ucfirst($user->role),'Total Laporan'=>$user->reports_count.' laporan','Total Berita'=>$user->news_count.' berita','Bergabung'=>$user->created_at->translatedFormat('d F Y, H:i')] as $k=>$v)
            <div style="display:flex;justify-content:space-between;padding:.65rem 0;border-bottom:1px solid var(--slate-50);font-size:13.5px;">
                <span style="color:var(--slate-500);">{{ $k }}</span>
                <span style="font-weight:500;">{{ $v }}</span>
            </div>
            @endforeach
            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-primary">Edit User</a>
                @if($user->id!==auth()->id())
                <form method="POST" action="{{ route('admin.user.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus User</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

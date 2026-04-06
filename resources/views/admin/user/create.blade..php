@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')

@section('sidebar-menu')
@foreach([['admin.dashboard','Dashboard'],['sda.index','Data SDA'],['news.index','Berita SDA'],['admin.notifications','Laporan Masuk'],['user.index','Kelola User']] as [$r,$l])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><circle cx="12" cy="12" r="9"/></svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>{{ isset($user) ? 'Edit User' : 'Tambah User Baru' }}</h1><p>{{ isset($user) ? 'Perbarui data pengguna' : 'Buat akun pengguna baru' }}</p></div>
    <a href="{{ route('user.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="max-width:600px;">
    <div class="card">
        <div class="card-header"><h3>Data Pengguna</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                           placeholder="Nama lengkap pengguna" value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}"
                           placeholder="email@contoh.com" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role <span style="color:var(--danger)">*</span></label>
                    <select name="role" class="form-control" required>
                        @foreach(['admin'=>'Admin','petugas'=>'Petugas','masyarakat'=>'Masyarakat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('role', $user->role ?? '') === $val ? 'selected':'' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }} <span style="color:var(--danger)">{{ isset($user) ? '' : '*' }}</span></label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}"
                           placeholder="Min. 8 karakter" {{ isset($user) ? '' : 'required' }}>
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Simpan Perubahan' : 'Buat Akun' }}</button>
                    <a href="{{ route('user.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

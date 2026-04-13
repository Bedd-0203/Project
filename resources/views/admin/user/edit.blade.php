@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')
@section('sidebar-menu') @include('admin._sidebar') @endsection

@section('content')

<div class="topbar">
    <div>
        <h1>{{ isset($user) ? 'Edit User' : 'Tambah User Baru' }}</h1>
        <p>{{ isset($user) ? 'Perbarui data pengguna sistem' : 'Buat akun pengguna baru' }}</p>
    </div>
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.5rem;align-items:start;max-width:900px;">

    <div class="card">
        <div class="card-header">
            <h3>{{ isset($user) ? 'Form Edit: ' . $user->name : 'Data Pengguna Baru' }}</h3>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ isset($user) ? route('admin.user.update', $user) : route('admin.user.store') }}">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="Nama lengkap pengguna"
                           value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email"
                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           placeholder="email@contoh.com"
                           value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label class="form-label">Role / Jabatan <span style="color:var(--danger)">*</span></label>
                    <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach(['admin'=>'Admin — Akses penuh sistem','petugas'=>'Petugas — Kelola SDA & Berita','masyarakat'=>'Masyarakat — Buat laporan'] as $val => $lbl)
                            <option value="{{ $val }}"
                                {{ old('role', $user->role ?? '') === $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">
                        Password
                        @if(isset($user))
                            <span style="font-weight:400;color:var(--slate-400);">(kosongkan jika tidak diubah)</span>
                        @else
                            <span style="color:var(--danger)">*</span>
                        @endif
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="passwordInput"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Minimal 8 karakter"
                               {{ isset($user) ? '' : 'required' }}>
                        <button type="button" onclick="togglePwd('passwordInput', this)"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--slate-400);font-size:12px;">
                            👁
                        </button>
                    </div>
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label class="form-label">
                        Konfirmasi Password
                        @if(!isset($user))<span style="color:var(--danger)">*</span>@endif
                    </label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password"
                           {{ isset($user) ? '' : 'required' }}>
                </div>

                <div style="display:flex;gap:10px;margin-top:1.75rem;">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($user) ? 'Simpan Perubahan' : 'Buat Akun' }}
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info panel --}}
    <div style="position:sticky;top:1.5rem;">
        <div class="card">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.85rem;">Panduan Role</p>
                @foreach([
                    ['Admin','badge-red','Akses penuh: kelola semua data, user, dan laporan.'],
                    ['Petugas','badge-blue','Dapat menambah dan mengedit Data SDA & Berita.'],
                    ['Masyarakat','badge-green','Dapat membuat laporan dan melihat data publik.'],
                ] as [$r,$cls,$desc])
                <div style="display:flex;gap:.75rem;margin-bottom:.85rem;align-items:flex-start;">
                    <span class="badge {{ $cls }}" style="flex-shrink:0;margin-top:1px;">{{ $r }}</span>
                    <p style="font-size:12.5px;color:var(--slate-500);line-height:1.55;">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>

        @if(isset($user))
        <div class="card" style="margin-top:1rem;">
            <div class="card-body">
                <p style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--slate-400);margin-bottom:.85rem;">Info Akun</p>
                @foreach(['ID'=>'#'.$user->id,'Bergabung'=>$user->created_at->translatedFormat('d F Y'),'Diperbarui'=>$user->updated_at->translatedFormat('d F Y')] as $k=>$v)
                <div style="display:flex;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid var(--slate-50);font-size:13px;">
                    <span style="color:var(--slate-500);">{{ $k }}</span>
                    <span style="font-weight:500;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text'; btn.textContent = '🙈';
    } else {
        input.type = 'password'; btn.textContent = '👁';
    }
}
</script>
@endpush

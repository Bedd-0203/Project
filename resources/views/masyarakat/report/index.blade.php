@extends('layouts.admin')
@section('title', 'Laporan Saya')

@section('sidebar-menu')
@foreach([
    ['masyarakat.dashboard','Dashboard','<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
    ['masyarakat.report.index','Laporan Saya','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
] as [$r,$l,$i])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active':'' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $i !!}</svg>{{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div><h1>Laporan Saya</h1><p>Riwayat dan status laporan yang Anda kirimkan</p></div>
    <a href="{{ route('masyarakat.report.create') }}" class="btn btn-primary">+ Buat Laporan</a>
</div>

@if($reports->count() > 0)
    <div style="display:flex;flex-direction:column;gap:1rem;">
        @foreach($reports as $lap)
        <div class="card" style="border-left:4px solid {{ $lap->status==='selesai'?'var(--green-500)':($lap->status==='diproses'?'var(--amber-500)':'var(--danger)') }};">
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem;">
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;margin-bottom:.2rem;">{{ $lap->title }}</h3>
                        <p style="font-size:12px;color:var(--slate-400);">{{ $lap->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        <span class="badge {{ $lap->status==='selesai'?'badge-green':($lap->status==='diproses'?'badge-amber':'badge-red') }}">
                            {{ ucfirst($lap->status) }}
                        </span>
                        @if($lap->status === 'pending')
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('masyarakat.report.edit',$lap) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form method="POST" action="{{ route('masyarakat.report.destroy',$lap) }}" onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                <p style="font-size:14px;color:var(--slate-600);line-height:1.7;margin-bottom:{{ $lap->image || $lap->response ? '.85rem' : '0' }};">{{ $lap->description }}</p>

                @if($lap->image)
                <div style="margin-bottom:.85rem;">
                    <img src="{{ asset('storage/'.$lap->image) }}" alt="Bukti" style="max-height:160px;border-radius:10px;object-fit:cover;">
                </div>
                @endif

                @if($lap->response)
                <div style="background:var(--green-50);border:1px solid var(--green-200);border-radius:9px;padding:.85rem 1rem;font-size:13.5px;color:var(--green-800);">
                    <strong style="display:block;margin-bottom:.25rem;font-size:12px;text-transform:uppercase;letter-spacing:.06em;">Respon Admin</strong>
                    {{ $lap->response }}
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top:1.5rem;">{{ $reports->links() }}</div>
@else
    <div style="text-align:center;padding:4rem 2rem;background:#fff;border-radius:14px;border:1px solid var(--slate-100);">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;color:var(--slate-300);">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
        </svg>
        <p style="font-weight:600;font-size:15px;color:var(--slate-600);margin-bottom:.5rem;">Belum ada laporan</p>
        <p style="font-size:13px;color:var(--slate-400);margin-bottom:1.5rem;">Buat laporan pertama Anda jika menemukan masalah terkait SDA.</p>
        <a href="{{ route('masyarakat.report.create') }}" class="btn btn-primary">Buat Laporan Sekarang</a>
    </div>
@endif
@endsection
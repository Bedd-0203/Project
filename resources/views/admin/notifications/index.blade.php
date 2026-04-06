@extends('layouts.admin')
@section('title', 'Laporan Masuk')

@section('sidebar-menu')
@foreach([
    ['admin.dashboard','Dashboard'],
    ['admin.sda.index','Data SDA'],
    ['admin.news.index','Berita SDA'],
    ['admin.notifications','Laporan Masuk'],
    ['admin.user.index','Kelola User']
] as [$r,$l])
<a href="{{ route($r) }}" class="sidebar-item {{ request()->routeIs($r) ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
        <circle cx="12" cy="12" r="9"/>
    </svg>
    {{ $l }}
</a>
@endforeach
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1>Laporan Masuk</h1>
        <p>{{ $pendingCount ?? 0 }} laporan menunggu respon</p>
    </div>
</div>

<div style="display:flex;flex-direction:column;gap:1rem;">
    @forelse($notifications as $lap)
    <div class="card" style="border-left:4px solid {{ $lap->status === 'selesai' ? 'var(--green-500)' : ($lap->status === 'diproses' ? 'var(--amber-500)' : 'var(--danger)') }};">
        <div class="card-body">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem;">
                <div>
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:.25rem;">
                        {{ $lap->title }}
                    </h3>

                    <div style="display:flex;align-items:center;gap:.75rem;font-size:12.5px;color:var(--slate-400);">
                        <span>{{ $lap->user->name ?? 'Anonim' }}</span>
                        <span>·</span>
                        <span>{{ $lap->created_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                </div>

                <span class="badge {{ $lap->status === 'selesai' ? 'badge-green' : ($lap->status === 'diproses' ? 'badge-amber' : 'badge-red') }}">
                    {{ ucfirst($lap->status) }}
                </span>
            </div>

            <p style="font-size:14px;color:var(--slate-600);line-height:1.7;margin-bottom:1rem;">
                {{ $lap->description }}
            </p>

            @if($lap->image)
            <div style="margin-bottom:1rem;">
                <img src="{{ asset('storage/'.$lap->image) }}" alt="Bukti laporan"
                     style="max-height:180px;border-radius:10px;object-fit:cover;">
            </div>
            @endif

            @if($lap->response)
            <div style="background:var(--green-50);border:1px solid var(--green-200);border-radius:9px;padding:.85rem 1rem;margin-bottom:1rem;font-size:13.5px;color:var(--green-800);">
                <strong style="display:block;margin-bottom:.25rem;">Respon Admin:</strong>
                {{ $lap->response }}
            </div>
            @endif

            @if($lap->status !== 'selesai')
            <form method="POST" action="{{ route('admin.notifications') }}" style="display:flex;gap:.75rem;align-items:flex-start;flex-wrap:wrap;">
                @csrf
                <input type="hidden" name="report_id" value="{{ $lap->id }}">

                <textarea name="response" rows="2" placeholder="Tulis respon Anda..." required
                    style="flex:1;padding:9px 13px;border-radius:9px;border:1.5px solid var(--slate-200);font-size:13.5px;resize:none;outline:none;font-family:'DM Sans',sans-serif;min-width:200px;transition:border-color .2s;"
                    onfocus="this.style.borderColor='var(--green-500)'"
                    onblur="this.style.borderColor='var(--slate-200)'">{{ $lap->response }}</textarea>

                <div style="display:flex;flex-direction:column;gap:.5rem;">
                    <button type="submit" name="action" value="proses" class="btn btn-primary btn-sm">
                        Tandai Diproses
                    </button>
                    <button type="submit" name="action" value="selesai" class="btn btn-outline btn-sm"
                        style="border-color:var(--green-300);color:var(--green-700);">
                        Tandai Selesai
                    </button>
                </div>
            </form>
            @endif

        </div>
    </div>
    @empty
    <div style="text-align:center;padding:4rem;color:var(--slate-400);">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
             style="margin:0 auto 1rem;display:block;opacity:.4;">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        </svg>
        <p style="font-weight:500;">Tidak ada laporan masuk.</p>
    </div>
    @endforelse
</div>

@if(isset($notifications) && method_exists($notifications, 'hasPages') && $notifications->hasPages())
<div style="margin-top:1.5rem;">
    {{ $notifications->links() }}
</div>
@endif
@endsection
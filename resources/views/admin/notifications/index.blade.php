@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Notifikasi</h2>

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR ALERT --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM KIRIM NOTIFIKASI --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Kirim Notifikasi</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="Judul notifikasi" required>
                </div>

                <div class="mb-3">
                    <label>Pesan</label>
                    <textarea name="message" class="form-control" rows="4" placeholder="Isi pesan..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Kirim Notifikasi
                </button>
            </form>
        </div>
    </div>

    {{-- LIST NOTIFIKASI --}}
    <div class="card">
        <div class="card-header">
            <strong>Daftar Notifikasi</strong>
        </div>

        <div class="card-body">

            @if(isset($notifications) && count($notifications) > 0)

                @foreach($notifications as $notif)
                    <div class="border rounded p-3 mb-3">
                        <h5 class="mb-1">
                            {{ $notif['title'] }}
                        </h5>

                        <p class="mb-1">
                            {{ $notif['message'] }}
                        </p>
                    </div>
                @endforeach

            @else
                <p class="text-muted mb-0">Belum ada notifikasi.</p>
            @endif

        </div>
    </div>

</div>
@endsection
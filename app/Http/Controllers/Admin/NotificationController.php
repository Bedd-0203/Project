<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // contoh data dummy
        $notifications = [
            ['title' => 'Laporan Baru', 'message' => 'Ada laporan masuk'],
            ['title' => 'Update Sistem', 'message' => 'Sistem diperbarui'],
        ];

        return view('admin.notifications.index', compact('notifications'));
    }

    public function store(Request $request)
    {
        // contoh proses simpan (dummy)
        // nanti bisa kamu hubungkan ke database

        return redirect()->route('admin.notifications')
            ->with('success', 'Notifikasi berhasil dikirim');
    }
}
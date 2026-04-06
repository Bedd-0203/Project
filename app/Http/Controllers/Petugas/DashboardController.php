<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Sda;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hanya tampilkan data SDA & berita milik petugas yang sedang login
        $totalSda  = Sda::count();
        $totalNews = News::where('user_id', $userId)->count();

        $sdaTerbaru   = Sda::with('category')->latest()->take(5)->get();
        $newsTerbaru  = News::where('user_id', $userId)->latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'totalSda',
            'totalNews',
            'sdaTerbaru',
            'newsTerbaru'
        ));
    }
}

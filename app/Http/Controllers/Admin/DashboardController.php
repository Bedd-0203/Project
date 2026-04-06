<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sda;
use App\Models\News;
use App\Models\Report;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Statistik ringkas ──
        $totalSda     = Sda::count();
        $totalNews    = News::count();
        $totalLaporan = Report::count();
        $pendingLaporan = Report::where('status', 'pending')->count();

        // ── Data untuk chart: jumlah SDA per kategori ──
        $sdaPerKategori = Category::withCount('sdas')->get()
            ->map(fn($c) => ['label' => $c->name, 'value' => $c->sdas_count]);

        // ── Laporan terbaru ──
        $laporanTerbaru = Report::with('user')->latest()->take(5)->get();

        // ── Berita terbaru ──
        $newsTerbaru = News::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSda',
            'totalNews',
            'totalLaporan',
            'pendingLaporan',
            'sdaPerKategori',
            'laporanTerbaru',
            'newsTerbaru'
        ));
    }
}

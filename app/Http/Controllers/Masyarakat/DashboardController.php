<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalLaporan   = Report::where('user_id', $userId)->count();
        $laporanPending = Report::where('user_id', $userId)->where('status', 'pending')->count();
        $laporanProses  = Report::where('user_id', $userId)->where('status', 'diproses')->count();
        $laporanSelesai = Report::where('user_id', $userId)->where('status', 'selesai')->count();
        $riwayat        = Report::where('user_id', $userId)->latest()->take(5)->get();

        return view('masyarakat.dashboard', compact(
            'totalLaporan',
            'laporanPending',
            'laporanProses',
            'laporanSelesai',
            'riwayat'
        ));
    }
}

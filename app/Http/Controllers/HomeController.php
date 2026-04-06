<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sda;
use App\Models\News;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function index()
    {
        // Ambil 3 kategori saja (sudah sesuai seeder), hitung jumlah SDA tiap kategori
        $categories = Category::withCount('sdas')->get();

        // Data SDA terbaru — maksimal 6
        $latestSda = Sda::with('category')->latest()->take(6)->get();

        // Berita terbaru — maksimal 3
        $latestNews = News::with('user')->latest()->take(3)->get();

        $totalSda      = Sda::count();
        $totalKategori = Category::count();

        return view('home.index', compact(
            'categories',
            'latestSda',
            'latestNews',
            'totalSda',
            'totalKategori'
        ));
    }

    /**
     * Halaman Data SDA publik — dengan search & filter kategori
     */
    public function dataSda(Request $request)
    {
        $query = Sda::with('category');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title',    'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('location', 'like', "%$q%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $sdas       = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('home.data-sda', compact('sdas', 'categories'));
    }

    /**
     * Detail satu data SDA
     */
    public function detailSda($id)
    {
        $sda     = Sda::with('category')->findOrFail($id);
        $related = Sda::where('category_id', $sda->category_id)
                      ->where('id', '!=', $id)
                      ->latest()
                      ->take(3)
                      ->get();

        return view('home.detail-sda', compact('sda', 'related'));
    }

    /**
     * Halaman Berita publik
     */
    public function berita(Request $request)
    {
        $query = News::with('user');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title',   'like', "%$q%")
                        ->orWhere('content', 'like', "%$q%");
            });
        }

        $news = $query->latest()->paginate(9)->withQueryString();

        return view('home.berita', compact('news'));
    }

    /**
     * Detail satu berita
     */
    public function detailNews($id)
    {
        $news   = News::with('user')->findOrFail($id);
        $latest = News::where('id', '!=', $id)->latest()->take(4)->get();

        return view('home.detail-news', compact('news', 'latest'));
    }
}

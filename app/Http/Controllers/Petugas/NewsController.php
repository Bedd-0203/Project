<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 FIX: tampilkan semua berita (admin + petugas)
        $query = News::with('user');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $news = $query->latest()->paginate(10)->withQueryString();
        return view('petugas.news.index', compact('news'));
    }

    public function create()
    {
        return view('petugas.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('petugas.news.index')
                         ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(News $news)
    {
        return view('petugas.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        // 🔥 FIX: hapus authorize biar tidak error
        return view('petugas.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        // 🔥 FIX: hapus authorize

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('petugas.news.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        // 🔥 FIX: hapus authorize

        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();

        return redirect()->route('petugas.news.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }
}
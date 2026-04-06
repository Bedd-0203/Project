<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Sda;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SdaController extends Controller
{
    public function index(Request $request)
    {
        $query = Sda::with('category');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $sdas       = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('petugas.sda.index', compact('sdas', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('petugas.sda.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sda', 'public');
        }

        Sda::create($validated);

        return redirect()->route('petugas.sda.index')
                         ->with('success', 'Data SDA berhasil ditambahkan.');
    }

    public function show(Sda $sda)
    {
        return view('petugas.sda.show', compact('sda'));
    }

    public function edit(Sda $sda)
    {
        $categories = Category::all();
        return view('petugas.sda.edit', compact('sda', 'categories'));
    }

    public function update(Request $request, Sda $sda)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($sda->image) Storage::disk('public')->delete($sda->image);
            $validated['image'] = $request->file('image')->store('sda', 'public');
        }

        $sda->update($validated);

        return redirect()->route('petugas.sda.index')
                         ->with('success', 'Data SDA berhasil diperbarui.');
    }

    public function destroy(Sda $sda)
    {
        if ($sda->image) Storage::disk('public')->delete($sda->image);
        $sda->delete();

        return redirect()->route('petugas.sda.index')
                         ->with('success', 'Data SDA berhasil dihapus.');
    }
}

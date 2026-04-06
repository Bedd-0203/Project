<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sda;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SdaController extends Controller
{
    /**
     * Daftar semua data SDA (dengan filter & search)
     */
    public function index(Request $request)
    {
        $query = Sda::with('category');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $sdas       = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.sda.index', compact('sdas', 'categories'));
    }

    /**
     * Form tambah data SDA
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sda.create', compact('categories'));
    }

    /**
     * Simpan data SDA baru
     */
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

        return redirect()->route('sda.index')
                         ->with('success', 'Data SDA berhasil ditambahkan.');
    }

    /**
     * Tampil detail satu data SDA (admin view)
     */
    public function show(Sda $sda)
    {
        $sda->load('category');
        return view('admin.sda.show', compact('sda'));
    }

    /**
     * Form edit data SDA
     */
    public function edit(Sda $sda)
    {
        $categories = Category::all();
        return view('admin.sda.edit', compact('sda', 'categories'));
    }

    /**
     * Update data SDA
     */
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
            // Hapus gambar lama jika ada
            if ($sda->image) {
                Storage::disk('public')->delete($sda->image);
            }
            $validated['image'] = $request->file('image')->store('sda', 'public');
        }

        $sda->update($validated);

        return redirect()->route('sda.index')
                         ->with('success', 'Data SDA berhasil diperbarui.');
    }

    /**
     * Hapus data SDA
     */
    public function destroy(Sda $sda)
    {
        if ($sda->image) {
            Storage::disk('public')->delete($sda->image);
        }

        $sda->delete();

        return redirect()->route('sda.index')
                         ->with('success', 'Data SDA berhasil dihapus.');
    }
}

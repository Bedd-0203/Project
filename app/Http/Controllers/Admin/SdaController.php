<?php

namespace App\Http\Controllers\Admin;

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
            $q = $request->q;
            $query->where(function ($b) use ($q) {
                $b->where('title', 'like', "%$q%")
                  ->orWhere('location', 'like', "%$q%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $sdas       = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.sda.index', compact('sdas', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sda.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
        ], [
            'title.required'       => 'Judul wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'location.required'    => 'Lokasi wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'image.image'          => 'File harus berupa gambar.',
            'image.max'            => 'Ukuran gambar maksimal 3MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('sda', 'public');
        }

        Sda::create($validated);

        return redirect()->route('admin.sda.index')
            ->with('success', 'Data SDA berhasil ditambahkan.');
    }

    public function show(Sda $sda)
    {
        $sda->load('category');
        return view('admin.sda.show', compact('sda'));
    }

    public function edit(Sda $sda)
    {
        $categories = Category::all();
        return view('admin.sda.edit', compact('sda', 'categories'));
    }

    public function update(Request $request, Sda $sda)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($sda->image) {
                Storage::disk('public')->delete($sda->image);
            }
            $validated['image'] = $request->file('image')
                ->store('sda', 'public');
        }

        $sda->update($validated);

        return redirect()->route('admin.sda.index')
            ->with('success', 'Data SDA berhasil diperbarui.');
    }

    public function destroy(Sda $sda)
    {
        if ($sda->image) {
            Storage::disk('public')->delete($sda->image);
        }

        $sda->delete();

        return redirect()->route('admin.sda.index')
            ->with('success', 'Data SDA berhasil dihapus.');
    }
}

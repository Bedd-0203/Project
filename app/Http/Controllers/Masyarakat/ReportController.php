<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Daftar laporan milik user yang login
     */
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                         ->latest()
                         ->paginate(10);

        return view('masyarakat.report.index', compact('reports'));
    }

    /**
     * Form buat laporan baru
     */
    public function create()
    {
        return view('masyarakat.report.create');
    }

    /**
     * Simpan laporan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        Report::create($validated);

        return redirect()->route('report.index')
                         ->with('success', 'Laporan berhasil dikirim. Kami akan segera menindaklanjuti.');
    }

    /**
     * Detail laporan (hanya milik sendiri)
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);
        return view('masyarakat.report.show', compact('report'));
    }

    /**
     * Form edit laporan (hanya jika masih pending)
     */
    public function edit(Report $report)
    {
        $this->authorize('update', $report);

        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        return view('masyarakat.report.edit', compact('report'));
    }

    /**
     * Update laporan
     */
    public function update(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($report->image) Storage::disk('public')->delete($report->image);
            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        $report->update($validated);

        return redirect()->route('report.index')
                         ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan (hanya jika masih pending)
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        if ($report->image) Storage::disk('public')->delete($report->image);
        $report->delete();

        return redirect()->route('report.index')
                         ->with('success', 'Laporan berhasil dihapus.');
    }
}

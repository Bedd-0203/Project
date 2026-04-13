<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

   public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('masyarakat.report.index', compact('reports'));
    }

    public function create()
    {
        return view('masyarakat.report.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        Report::create($validated);

        return redirect()->route('masyarakat.report.index')
            ->with('success', 'Laporan berhasil dikirim');
    }

    public function show(Report $report)
    {
        if ($report->user_id != Auth::id()) {
            abort(403);
        }

        return view('masyarakat.report.show', compact('report'));
    }

    public function edit(Report $report)
    {
        if ($report->user_id != Auth::id()) {
            abort(403);
        }

        if ($report->status !== 'pending') {
            return back()->with('error', 'Tidak bisa edit, sudah diproses');
        }

        return view('masyarakat.report.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        if ($report->user_id != Auth::id()) {
            abort(403);
        }

        if ($report->status !== 'pending') {
            return back()->with('error', 'Tidak bisa update');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($report->image) {
                Storage::disk('public')->delete($report->image);
            }

            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        $report->update($validated);

        return redirect()->route('masyarakat.report.index')
            ->with('success', 'Laporan berhasil diupdate');
    }

    public function destroy(Report $report)
    {
        if ($report->user_id != Auth::id()) {
            abort(403);
        }

        if ($report->status !== 'pending') {
            return back()->with('error', 'Tidak bisa hapus');
        }

        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return back()->with('success', 'Laporan dihapus');
    }
}
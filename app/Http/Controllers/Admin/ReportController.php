<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Tampilkan semua laporan
     */
    public function index()
    {
        $reports = Report::with('user')
                         ->latest()
                         ->paginate(10);

        return view('admin.report.index', compact('reports'));
    }

    /**
     * Detail laporan
     */
    public function show(Report $report)
    {
        return view('admin.report.show', compact('report'));
    }

    /**
     * Form edit (untuk ubah status & jawaban)
     */
    public function edit(Report $report)
    {
        return view('admin.report.edit', compact('report'));
    }

    /**
     * Update status & jawaban
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status'   => 'required|in:pending,diproses,selesai',
            'response' => 'nullable|string'
        ]);

        $report->update([
            'status'   => $request->status,
            'response' => $request->response
        ]);

        return redirect()->route('admin.reports.index')
                         ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Hapus laporan
     */
    public function destroy(Report $report)
    {
        if ($report->image) {
            \Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return back()->with('success', 'Laporan berhasil dihapus');
    }
}
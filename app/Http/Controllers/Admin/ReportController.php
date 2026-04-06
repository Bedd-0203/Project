<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index', [
            'reports' => Report::latest()->paginate(10)
        ]);
    }

    public function show(Report $report)
    {
        return view('admin.report.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success','Laporan dihapus');
    }
}
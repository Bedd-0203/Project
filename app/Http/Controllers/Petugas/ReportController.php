<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('petugas.report.index', [
            'reports' => Report::latest()->get()
        ]);
    }

    public function update(Request $request, Report $report)
    {
        $report->update([
            'status' => $request->status,
            'response' => $request->response
        ]);

        return back();
    }
}
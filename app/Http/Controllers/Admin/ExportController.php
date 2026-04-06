<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ExportController extends Controller
{
    public function export()
    {
        $reports = Report::all();

        $filename = "laporan_sda.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, ['Judul', 'Deskripsi', 'Status']);

        foreach ($reports as $r) {
            fputcsv($handle, [$r->title, $r->description, $r->status]);
        }

        fclose($handle);

        return response()->download($filename);
    }
}
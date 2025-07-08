<?php

namespace App\Http\Controllers;

use App\Exports\CatatanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Catatan;


class ExportDataController extends Controller
{
   public function exportExcel()
   {
    return Excel::download (new CatatanExport, 'catatan.xlsx');
   }
   public function exportPDF()
   {
    $catatan = catatan::all();
    $pdf = Pdf::loadview('catatan_pdf', compact('catatans'));
    return $pdf->download('catatan.pdf');
   }
}
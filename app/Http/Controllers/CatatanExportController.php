<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CatatanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Catatan;

class CatatanExportController extends Controller
{
   public function exportExcel()
   {
    return Excel::download(new CatatanExport, 'laporan_catatan.xlsx');
   }

   public function exportPDF()
   {
    $catatan =Catatan::all();
    $pdf = pdf::loadview('pages.catatans.pdf',compact ('catatans'));
    return $pdf->download('laporan_catatan.pdf');
   }
}
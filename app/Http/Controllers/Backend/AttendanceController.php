<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
      //index
public function index(Request $request)
{
    $attendances = Attendance::with('user')
        ->when($request->input('name'), function ($query, $name) {
            $query->whereHas('user', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        })
        ->when($request->input('status'), function ($query, $status) {
            $query->where('status', $status);
        })
        ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        })
        ->when($request->input('filter') === 'weekly', function ($query) {
            $query->whereBetween('date', [
                now()->startOfWeek(), now()->endOfWeek()
            ]);
        })
        ->when($request->input('filter') === 'monthly', function ($query) {
            $query->whereMonth('date', now()->month)
                  ->whereYear('date', now()->year);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('pages.absensi.index', compact('attendances'));
}
public function rekapKeterlambatan(Request $request)
{
    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end   = $request->end_date ?? now()->endOfMonth()->toDateString();

    $rekap = Attendance::select('user_id')
        ->selectRaw("COUNT(*) as total_absen")
        ->selectRaw("SUM(CASE WHEN time_in > '08:00:00' THEN 1 ELSE 0 END) as total_terlambat")
        ->whereBetween('date', [$start, $end])
        ->groupBy('user_id')
        ->with('user') 
        ->get();

    return view('pages.absensi.rekap_keterlambatan', compact('rekap', 'start', 'end'));
}


public function cetakPerUser($userId)
{
    $laporan = Attendance::where('user_id', $userId)->get();
    $pdf = Pdf::loadView('laporan.absensi_per_user', compact('laporan'));
    return $pdf->download('laporan_absensi_per_user.pdf');
}

public function cetakMingguan($userId, $startDate, $endDate)
{
    $laporan = Attendance::where('user_id', $userId)
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

    $pdf = Pdf::loadView('laporan.absensi_mingguan', compact('laporan'));
    return $pdf->download('laporan_absensi_mingguan.pdf');
}

public function cetakBulanan($userId, $bulan, $tahun)
{
    $laporan = Attendance::where('user_id', $userId)
        ->whereMonth('date', $bulan)
        ->whereYear('date', $tahun)
        ->get();

    $pdf = Pdf::loadView('laporan.absensi_bulanan', compact('laporan'));
    return $pdf->download('laporan_absensi_bulanan.pdf');
}


 public function ExportPDF()
    {
        $rekapPerHari =Attendance::select(
            DB::raw('date'),
            DB::raw('COUNT(*) as total_absen')
        )
        ->groupby('date')
        ->get();
        
    $pdf = Pdf::loadView('laporan.rekap_absensi_pdf', compact('rekapPerHari'));
        return $pdf->download('rekap_absensi.pdf');

}
}
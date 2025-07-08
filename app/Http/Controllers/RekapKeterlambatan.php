<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class RekapKeterlambatan extends Controller
{

public function rekapKeterlambatan(Request $request)
{
    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end   = $request->end_date ?? now()->endOfMonth()->toDateString();

    $rekap = Attendance::select('user_id')
        ->selectRaw("COUNT(*) as total_absen")
        ->selectRaw("SUM(CASE WHEN check_in_time > '08:00:00' THEN 1 ELSE 0 END) as total_terlambat")
        ->whereBetween('date', [$start, $end])
        ->groupBy('user_id')
        ->with('user') 
        ->get();

    return view('pages.absensi.rekap_keterlambatan', compact('rekap', 'start', 'end'));
}

}
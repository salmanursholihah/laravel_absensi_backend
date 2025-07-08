<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;


class RekapAttendanceController extends Controller
{

public function index()
{
    $users = User::all();
}

    public function ExportPDF()
    {
        $rekapPerHari =Attendance::select(
            DB::raw('date'),
            DB::raw('COUNT(*) as total_absen')
        )
        ->groupby('date')
        ->get();

        
         
////laporan per user
        $laporanUser = Attendance::where('user_id',$user_Id)
        ->groupBy('date','asc')
        ->get();
        
        ///laporan mingguan
      
        $startDate = carbon::perse('tanggalawal');
        $endDate = carbon::perse('tanggal akhir');
        
        $laporanMingguan = Attendance::whereBetween('date', [$startDate,$endDate])
        ->groupBy('date','asc')
        ->get();



        ///laporan bulanan
        $bulan = 6;  // Juni
$tahun = 2025;

$laporanBulanan = Attendance::whereMonth('date', $bulan)
    ->whereYear('date', $tahun)
    ->orderBy('date', 'asc')
    ->get();


    $pdf = Pdf::loadView('rekap_absensi_pdf', compact('rekapPerHari'));
        return $pdf->download('rekap_absensi.pdf');
    }
    /**
     * Display a listing of the resource.
     */
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
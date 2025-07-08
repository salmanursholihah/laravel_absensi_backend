<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Permissions;

class PermissionController extends Controller
{
    //index
    // public function index(Request $request)
    // {
    //     $permissions = Permission::with('user')
    //         ->when($request->input('name'), function ($query, $name) {
    //             $query->whereHas('user', function ($query) use ($name) {
    //                 $query->where('name', 'like', '%' . $name . '%');
    //             });
    //         })->orderBy('id', 'desc')->paginate(10);
    //     return view('pages.permission.index', compact('permissions'));
    // }

    public function index(Request $request)
{

    $users = User::all();
    $permissions = Permission::with('user')
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

        return view('pages.permission.index', compact('permissions','users'));
}


    //view
    public function show($id)
    {
        $permission = Permission::with('user')->find($id);
        return view('pages.permission.show', compact('permission'));
    }

    //edit
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('pages.permission.edit', compact('permission'));
    }

    //update
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->is_approved = $request->is_approved;
        $str = $request->is_approved == 1 ? 'Disetujui' : 'Ditolak';
        $permission->save();
        $this->sendNotificationToUser($permission->user_id, 'Status Izin anda adalah ' . $str);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    // // send notification to user
    // public function sendNotificationToUser($userId, $message)
    // {
    //     // Dapatkan FCM token user dari tabel 'users'

    //     $user = User::find($userId);
    //     $token = $user->fcm_token;

    //     // Kirim notifikasi ke perangkat Android
    //     $messaging = app('firebase.messaging');
    //     $notification = Notification::create('Status Izin', $message);

    //     $message = CloudMessage::withTarget('token', $token)
    //         ->withNotification($notification);

    //     $messaging->send($message);
    // }

    // public function sendNotificationToUser($userId, $message)
    // {
    //     $user = User::find($userId);

    //     if (!$user || !$user->fcm_token) {
    //         // Log::warning("FCM token tidak tersedia untuk user ID: $userId");
    //         return; // atau bisa lempar exception jika perlu
    //     }

    //     $token = $user->fcm_token;

    //     $messaging = app('firebase.messaging');
    //     $notification = Notification::create('Status Izin', $message);

    //     $message = CloudMessage::withTarget('token', $token)
    //         ->withNotification($notification);

    //     $messaging->send($message);
    // }


    public function sendNotificationToUser($userId, $message)
    {
        try {
            // Dapatkan FCM token user dari tabel 'users'
            $user = User::find($userId);

            // Cek apakah user ditemukan
            if (!$user) {
                // \Log::error("User dengan ID {$userId} tidak ditemukan");
                return false;
            }

            // Cek apakah token FCM tersedia
            if (empty($user->fcm_token)) {
                // \Log::error("FCM token untuk user ID {$userId} kosong atau tidak tersedia");
                return false;
            }

            $token = $user->fcm_token;

            // Kirim notifikasi ke perangkat Android
            $messaging = app('firebase.messaging');
            $notification = Notification::create('Status Izin', $message);

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);

            $result = $messaging->send($message);
            // \Log::info("Notifikasi berhasil dikirim ke user ID {$userId}");
            return $result;
        } catch (\Exception $e) {
            // \Log::error("Error saat mengirim notifikasi: " . $e->getMessage());
            return false;
        }
    }

// public function cetakBulanan($userId, $bulan, $tahun)
// {
//     $laporan = Permission::where('user_id', $userId)
//         ->whereMonth('date', $bulan)
//         ->whereYear('date', $tahun)
//         ->get();

//     $pdf = Pdf::loadView('laporan.absensi_bulanan', compact('laporan'));
//     return $pdf->download('laporan_absensi_bulanan.pdf');
// }

// public function ExportPDF()
// {
//     $rekap = Permission::select(
//         DB::raw('date'),
//         DB::raw('COUNT(*) as total_absen')
//     )

//     ->groupby('date')
//     ->get();

//     $pdf = Pdf::loadView('laporan.rekap_izin_pdf', compact('laporan.izin'));
//     return $pdf->download('rekap_izin.pdf');
// }
//    public function exportExcel()
//    {
//     return Excel::download(new Permission, 'laporan_catatan.xlsx');
//    }

// //    public function exportPermission()
// //    {
// //     $catatan =PermissionController::all();
// //     $pdf = pdf::loadview('pages.catatans.pdf',compact ('catatans'));
// //     return $pdf->download('laporan_catatan.pdf');
// //    }
    public function exportExcel()
    {
        return Excel::download(new Permissions, 'laporan_permission.xlsx');
    }

    public function exportPDF()
    {
        $permissions = Permission::all();
        $pdf = Pdf::loadView('pages.permission.pdf', compact('permissions'));
        return $pdf->download('laporan_permission.pdf');
    }

  public function exportPerbulan(Request $request)
{
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));

    $permissions = Permission::whereMonth('date_permission', $month)
                             ->whereYear('date_permission', $year)
                             ->get();

    $pdf = Pdf::loadView('pages.permission.export', compact('permissions', 'month', 'year'));

    return $pdf->download("permission_{$month}_{$year}.pdf");
}


public function exportPerUser(Request $request)
{
    $id = $request->user_id ?? auth()->id();
    $user = User::findOrFail($id);

    $permissions = permission::where('user_id', $user->id)->get();

    if ($permissions->isEmpty()) {
        // INI BENAR, karena route() akan panggil index()
        return redirect()->route('permissions.index')->with('error', 'Data tidak ditemukan.');
    }

    $pdf = Pdf::loadView('pages.permission.export_user', compact('permissions', 'user'));

    return $pdf->download("permission_{$user->name}.pdf");
}


}
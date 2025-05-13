<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PermissionController extends Controller
{
    //index
    public function index(Request $request)
    {
        $permissions = Permission::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.permission.index', compact('permissions'));
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
}

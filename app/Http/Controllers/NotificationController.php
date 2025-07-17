<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{

public function index()
{
    $user = Auth::user();

    // Semua notif
    $notifications = $user->notifications;

    // Atau hanya unread:
    $unreadNotifications = $user->unreadNotifications;

    return view('user.notifications.index', compact('notifications', 'unreadNotifications'));
}
public function markAsRead($id)
{
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
}

}
<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index() {
        $notifications = Auth::user()->notifications;
        return view('pages.users.notifikasi', compact('notifications'));
    }
public function markAsRead($id) {
    $notifications = auth()->user()->notifications()->findOrFail($id);
    $notifications->markAsRead();
    return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
}



}
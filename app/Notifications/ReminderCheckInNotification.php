<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReminderCheckInNotification extends Notification
{
    use Queueable;

    public function via($notifiable) { return ['database']; }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Reminder Absen Masuk',
            'message' => 'Waktu absen masuk sudah tiba. Silakan absen sekarang!',
        ];
    }
}
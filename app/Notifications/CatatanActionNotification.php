<?php

// namespace App\Notifications;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Notifications\Notification;

// class CatatanActionNotification extends Notification
// {
//     use Queueable;

//     /**
//      * Create a new notification instance.
//      */
//     public function __construct()
//     {
//         //
//     }

//     /**
//      * Get the notification's delivery channels.
//      *
//      * @return array<int, string>
//      */
//     public function via(object $notifiable): array
//     {
//         return ['database'];
//     }

//     /**
//      * Get the mail representation of the notification.
//      */
//     public function toMail(object $notifiable): MailMessage
//     {
//         return (new MailMessage)
//                     ->line('The introduction to the notification.')
//                     ->action('Notification Action', url('/'))
//                     ->line('Thank you for using our application!');
//     }

//     /**
//      * Get the array representation of the notification.
//      *
//      * @return array<string, mixed>
//      */
//     public function toArray(object $notifiable): array
//     {
//         return [
//             //
//         ];
//     }

//     public function toDatabase($notifiable )
//     {
//         return [
//             'title' => "Catatan {$this->action}",
//             'message' => "Catatan '{$this->catatan->title}' telah {$this->action} oleh " . auth()->user()->name,
//             'catatan_id' => $this->catatan->id,
//         ];
//     }
// }

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CatatanActionNotification extends Notification
{
    use Queueable;

    protected $catatan;
    protected $action;

    public function __construct($catatan, $action)
    {
        $this->catatan = $catatan;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Catatan {$this->action}",
            'message' => "Catatan '{$this->catatan->title}' telah {$this->action} oleh " . auth()->user()->name,
            'catatan_id' => $this->catatan->id,
        ];
    }
}
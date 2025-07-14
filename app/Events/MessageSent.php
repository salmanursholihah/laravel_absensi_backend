<?php

// namespace App\Events;

// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// class MessageSent implements ShouldBroadcast
// {
//     use InteractsWithSockets;

//     public $message;

//     public function __construct($message)
//     {
//         $this->message = $message;
//     }

//     public function broadcastOn()
//     {
//         return new PrivateChannel('chat.' . $this->message->receiver_id);
//     }

//     public function broadcastWith()
//     {
//         return [
//             'id' => $this->message->id,
//             'sender_id' => $this->message->sender_id,
//             'receiver_id' => $this->message->receiver_id,
//             'body' => $this->message->body,
//             'created_at' => $this->message->created_at->toDateTimeString(),
//         ];
//     }
// }



// namespace App\Events;

// use App\Models\Message;
// use Illuminate\Broadcasting\Channel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// class MessageSent implements ShouldBroadcast
// {
//     public $message;

//     public function __construct(Message $message)
//     {
//         $this->message = $message;
//     }

//     public function broadcastOn()
//     {
//         return new Channel('chat.' . $this->message->receiver_id);
//     }

//     public function broadcastWith()
//     {
//         return [
//             'sender_id' => $this->message->sender_id,
//             'body' => $this->message->body,
//         ];
//     }
// }

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . min($this->message->sender_id, $this->message->receiver_id) . '_' . max($this->message->sender_id, $this->message->receiver_id));
    }


    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'body' => $this->message->body,
        ];
    }
}
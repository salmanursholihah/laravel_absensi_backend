<?php
// namespace App\Http\Controllers;

// use App\Models\Message;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Events\MessageSent;

// class MessageController extends Controller
// {
//  public function index($receiverId)
// {
//     $messages = Message::where(function ($query) use ($receiverId) {
//         $query->where('sender_id', Auth::id())
//               ->where('receiver_id', $receiverId);
//     })->orWhere(function ($query) use ($receiverId) {
//         $query->where('sender_id', $receiverId)
//               ->where('receiver_id', Auth::id());
//     })
//     ->orderBy('created_at','asc')
//     ->get();

//     return view('public.messages.index', [
//         'messages' => $messages,
//         'receiverId' => $receiverId
//     ]);
// }



// // public function store(Request $request)
// // {
// //     $request->validate([
// //         'receiver_id' => 'required|exists:users,id',
// //         'body' => 'required|string', // atau 'body'
// //     ]);

// //     $message = Message::create([
// //         'sender_id' => auth()->id(),
// //         'receiver_id' => $request->receiver_id,
// //         'body' => $request->body,
// //     ]);

// //     broadcast(new MessageSent($message))->toOthers();
// //     return back();

// // }
// public function store(Request $request)
// {
//     $request->validate([
//         'receiver_id' => 'required|exists:users,id',
//         'body' => 'required|string',
//     ]);

//     $message = Message::create([
//         'sender_id' => auth()->id(),
//         'receiver_id' => $request->receiver_id,
//         'body' => $request->body, // ✅ HARUS body
//     ]);

//     broadcast(new MessageSent($message))->toOthers();
//     return back();
// }


// public function showmessages($receiverId)
// {
//     $messages = message::where('receiver_id', $receiverId)->get();
//     return view('messages.index', compact('messages'));
// }


// }<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index($receiverId)
    {
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return view('messages.index', [
            'messages' => $messages,
            'receiverId' => $receiverId,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return back();
    }
}
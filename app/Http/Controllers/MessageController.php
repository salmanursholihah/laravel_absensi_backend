<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models\User;

class MessageController extends Controller
{
    public function index() {
        $users = \App\Models\User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message]);
    }
    public function chatWith($receiverId)
{
    $receiver = User::findOrFail($receiverId);

    $messages = Message::where(function ($q) use ($receiverId) {
        $q->where('sender_id', Auth::id())
          ->where('receiver_id', $receiverId);
    })->orWhere(function ($q) use ($receiverId) {
        $q->where('sender_id', $receiverId)
          ->where('receiver_id', Auth::id());
    })->orderBy('created_at')->get();

    return view('chat.show', compact('receiver', 'messages'));
}


/// bagaimana cara agar saat kita memilih user langsung masuk kalaman chat/{receiverid} dan mengirim pesan dari sana tidak dari halaman chat.index


}
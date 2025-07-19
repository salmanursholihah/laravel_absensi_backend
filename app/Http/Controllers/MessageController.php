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
        'content' => 'nullable|string',
        'attachments.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $message = new Message();
    $message->sender_id = auth()->id();
    $message->receiver_id = $request->receiver_id;
    $message->content = $request->content;

    $filenames = [];

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/message_attachments', $filename);
            $filenames[] = $filename;
        }
        $message->attachment = json_encode($filenames);
    }

    $message->save();

    return response()->json(['success' => true]);
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
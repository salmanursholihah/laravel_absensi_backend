<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
//     public function index()
//     {
//         // List semua user KECUALI diri sendiri
//         $users = User::where('id', '!=', Auth::id())->get();
//         return view('chat.index', compact('users'));
//     }

//     public function chatWith($receiverId)
//     {
//         $receiver = User::findOrFail($receiverId);

//         $messages = Message::where(function ($q) use ($receiverId) {
//             $q->where('sender_id', Auth::id())
//               ->where('receiver_id', $receiverId);
//         })->orWhere(function ($q) use ($receiverId) {
//             $q->where('sender_id', $receiverId)
//               ->where('receiver_id', Auth::id());
//         })->orderBy('created_at')->get();

//         return view('chat.show', compact('receiver', 'messages'));
//     }

//     public function send(Request $request)
//     {
//         $request->validate([
//             'receiver_id' => 'required|exists:users,id',
//             'content' => 'nullable|string',
//             'attachments.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         $message = new Message();
//         $message->sender_id = Auth::id();
//         $message->receiver_id = $request->receiver_id;
//         $message->content = $request->content;

//         $filenames = [];
//         if ($request->hasFile('attachments')) {
//             foreach ($request->file('attachments') as $file) {
//                 $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
//                 $file->storeAs('public/message_attachments', $filename);
//                 $filenames[] = $filename;
//             }
//             $message->attachment = json_encode($filenames);
//         }

//         $message->save();

//         return response()->json(['success' => true]);
//     }

public function indexAdmin() {
    $users = User::where('id', '!=', Auth::id())->get();
    return view('pages.chat.index', compact('users'));
}

public function indexUser() {
    $admins = User::where('role', 'admin')->get();
    return view('chat.index', compact('admins'));
}


public function chatWithAdmin($receiverId) {
    $receiver = User::findOrFail($receiverId);

    $messages = Message::where(function ($q) use ($receiverId) {
        $q->where('sender_id', Auth::id())
          ->where('receiver_id', $receiverId);
    })->orWhere(function ($q) use ($receiverId) {
        $q->where('sender_id', $receiverId)
          ->where('receiver_id', Auth::id());
    })->orderBy('created_at')->get();

    return view('pages.chat.show', compact('receiver', 'messages'));
}

public function chatWithUser($receiverId) {
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

public function send(Request $request) {
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'content' => 'nullable|string',
    ]);

    $message = new Message();
    $message->sender_id = Auth::id();
    $message->receiver_id = $request->receiver_id;
    $message->content = $request->content;
    $message->save();

    return response()->json(['success' => true]);

}
}




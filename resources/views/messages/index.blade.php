@extends('layouts.app')

@section('content')

<h1>Chat</h1>

<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <h5>Obrolan dengan User</h5>
        </div>
        <div class="card-body" id="messages" style="max-height: 400px; overflow-y: auto;">
            @foreach ($messages as $message)
            <div class="mb-2">
                <strong>{{ $message->sender_id == Auth::id() ? 'Saya' : 'User' }}:</strong>
                {{ $message->body }}
            </div>
            @endforeach
        </div>
        <div class="card-footer">
            <form method="POST" action="{{ route('messages.store') }}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                <div class="input-group">
                    <textarea name="body" class="form-control" rows="1" placeholder="Tulis pesan..."></textarea>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>

</div>
<h2>Chat dengan User ID: {{ $userId }}</h2>

<div class="chat-box">
    @foreach ($messages as $msg)
    <div>
        <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
    </div>
    @endforeach
</div>

<form action="{{ route('messages.store') }}" method="POST">
    @csrf
    <input type="hidden" name="receiver_id" value="{{ $userId }}">
    <textarea name="message"></textarea>
    <button type="submit">Balas</button>
</form>
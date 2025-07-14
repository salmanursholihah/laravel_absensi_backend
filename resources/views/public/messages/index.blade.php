<!-- <h2>Pesan</h2>

<div class="chat-box">
    @foreach ($messages as $msg)
    <div>
        <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
    </div>
    @endforeach
</div>

<form action="{{ route('messages.store') }}" method="POST">
    @csrf
    <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
    <textarea name="message"></textarea>
    <button type="submit">Kirim</button>
</form> -->

@foreach ($messages as $msg)
<div>
    <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
</div>
@endforeach

<form action="{{ route('messages.store') }}" method="POST">
    @csrf
    <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
    <textarea name="message"></textarea>
    <button type="submit">Kirim</button>
</form>
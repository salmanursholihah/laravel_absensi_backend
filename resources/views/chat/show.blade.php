<h3>Chat dengan: {{ $receiver->name }}</h3>

<div id="chat-box" style="border:1px solid #ccc; height:300px; overflow-y:scroll; padding:10px;">
    @foreach ($messages as $message)
    <div style="text-align: {{ $message->sender_id == Auth::id() ? 'right' : 'left' }}">
        <b>{{ $message->sender_id == Auth::id() ? 'Saya' : $receiver->name }}:</b>
        {{ $message->content }}
    </div>
    @endforeach
</div>

<textarea id="message"></textarea>
<button type="button" id="send">Send</button>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const receiverId = @json($receiver->id);

document.getElementById('send').addEventListener('click', function() {
    const message = document.getElementById('message').value;

    if (message.trim() === '') {
        alert('Tulis pesan dulu');
        return;
    }

    axios.post('/chat/send', {
        receiver_id: receiverId,
        content: message
    }).then(response => {
        location.reload();
    }).catch(error => {
        console.error(error);
    });
});
</script>
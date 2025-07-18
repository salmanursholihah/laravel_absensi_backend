@foreach ($users as $user)
<div class="user">
    <a href="{{ route('chat.show', $user->id) }}">
        <img src="{{ asset('storage/avatars/' . ($user->avatar ?? 'default.png')) }}" width="30"
            style="border-radius: 50%;">
        {{ $user->name }}
    </a>
</div>
@endforeach

<textarea id="message"></textarea>
<button id="send">Send</button>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>

<script>
let receiverId = null;

document.querySelectorAll('.user').forEach(user => {
    user.addEventListener('click', function() {
        receiverId = this.dataset.id;
        alert('Chatting with user ID: ' + receiverId);
    });
});

document.getElementById('send').addEventListener('click', function() {
    const message = document.getElementById('message').value;

    if (!receiverId) {
        alert('Pilih user dulu!');
        return;
    }

    axios.post('/chat/send', {
            receiver_id: receiverId,
            content: message
        })
        .then(response => {
            console.log('Message sent:', response.data);
            document.getElementById('message').value = '';
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
});

Echo.channel('chat.{{ auth()->id() }}')
    .listen('MessageSent', (e) => {
        console.log('New message received:', e);
    });
</script>
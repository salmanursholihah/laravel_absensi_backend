@foreach ($notifications as $notification)
    <div>
        <strong>{{ $notification->data['title'] }}</strong><br>
        <span>{{ $notification->data['message'] }}</span><br>
        <small>{{ $notification->created_at->diffForHumans() }}</small>
        @if (is_null($notification->read_at))
            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit">Tandai dibaca</button>
            </form>
        @else
            ✔ Dibaca
        @endif
    </div>
@endforeach
@foreach ($users as $user)
    <div class="user">
        <a href="{{ route('chat.show', $user->id) }}">
            <img src="{{ asset('storage/avatars/' . ($user->avatar ?? 'default.png')) }}" class="avatar">
            {{ $user->name }}
        </a>
    </div>
@endforeach

<style>
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}
</style>

{{-- resources/views/chat/index.blade.php --}}
<!-- <h2>Daftar Admin</h2>
@foreach ($admins as $admin)
  <div>
    <a href="{{ route('chat.show', $admin->id) }}">Chat dengan {{ $admin->name }}</a>
  </div>
@endforeach -->

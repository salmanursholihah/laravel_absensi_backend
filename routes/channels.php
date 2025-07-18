<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
//     return (int) $user->id === (int) $receiverId;
// });

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{senderId}_{receiverId}', function ($user, $senderId, $receiverId) {
    return $user->id === (int) $senderId || $user->id === (int) $receiverId;
});
<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// User private channel
Broadcast::channel('user.{slug}', function ($user, $slug) {
    return (string) $user->id === (string) $slug;
});
// User conversation channel
Broadcast::channel('user.conversation.{id}', function ($user, $id) {
    Talk::setAuthUserId($user->id);

    $thread = Talk::getConversationsById($id);

    return (bool)$thread;
});

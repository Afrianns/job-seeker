<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-chat.{id}', function ($user, $id) {
    return (string) $user->id === (string) $id;
});

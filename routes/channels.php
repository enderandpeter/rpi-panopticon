<?php

use App\Models\Alarm;
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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Every authenticated user should get this message
//Broadcast::channel('alarm-status-changed.{alarm}', function ($user, Alarm $alarm) {
//    return (int) $user->id === auth()->id();
//});

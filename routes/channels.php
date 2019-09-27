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

Broadcast::channel('chat', function ($user) {
    return Auth::check();
});

Broadcast::channel('users', function ($user) {
  	  return Auth::check();
});

Broadcast::channel('groups1', function ($user) {
    return Auth::check();
});

Broadcast::channel('groupchat', function ($user) {
    return Auth::check();
});

Broadcast::channel('unseen', function ($user) {
	return Auth::check();
});

Broadcast::channel('removeuser', function ($user) {
	return Auth::check();
});

Broadcast::channel('newmember', function ($user) {
	return Auth::check();
});

Broadcast::channel('dashboardchannel', function ($user) {
    return Auth::check();
});

Broadcast::channel('managerchannel', function ($user) {
    return Auth::check();
});

Broadcast::channel('hrchannel', function ($user) {
    return Auth::check();
});

Broadcast::channel('adminchannel', function ($user) {
    return Auth::check();
});

Broadcast::channel('announcementchannel', function ($user) {
    return Auth::check();
});



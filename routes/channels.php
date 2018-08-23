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


// {} 正则替换为 news.*
//如果closure 执行结果是false 那么 http 403
Broadcast::channel('news.{id}', function ($user, $id) {
    return ['aaa'=>12344];
});

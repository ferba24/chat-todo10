<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('home/logout', 'HomeController@logout')->name('home.logout');

Route::post('broadcast', function(Request $req){
    $pusher = new Pusher\Pusher(
                        "236acea19ee8b3a3672a", //PUSHER_APP_KEY
                        "aa3d0ed20d984c0b2179", //PUSHER_APP_SECRET
                        "991438" //PUSHER_APP_ID
                    );
    return $pusher->socket_auth($req->get('channel_name'), $req->get('socket_id'));
});

Route::prefix('room')->group(function(){
    Route::get('selected/{room}', 'RoomController@selected')->name('room.selected');
    Route::get('change/{room}', 'RoomController@change')->name('room.change');
    Route::get('getRoom', 'RoomController@getRooms')->name('room.getRoom');
    Route::get('getRoomsUser/{id}', 'RoomController@getRoomsUser')->name('room.getRoomsUser');
    Route::get('exitRoom/{room}', 'RoomController@exitRoom')->name('room.exitRoom');
});

Route::prefix('chat')->group(function(){
    Route::post('create', 'ChatController@create')->name('chat.create');
    Route::get('getMessages', 'ChatController@getMessages')->name('chat.getMessages');
});

Route::prefix('api')->group(function(){
    Route::post('login', 'ApiController@login');
    Route::get('checkLogin', 'ApiController@checkLogin');
    Route::get('checkRoom', 'ApiController@checkRoom')->middleware('api_connect');
    Route::middleware(['api_connect'])->group(function () {
        Route::prefix('user')->group(function(){
            Route::get('getCurrent', 'ApiController@getCurrentUser');
        });
    });
});
Route::prefix('room')->group(function(){
    //Route::post('login', 'ApiController@login');
});
Route::get('/api/getUser/{room}/{search?}', 'ApiController@getUser')->name('api.getUser');
Route::get('/api/getUserPrivate', 'ApiController@getUserPrivate')->name('api.getUserPrivate');
Route::get('/api/getMessages/{room}', 'ApiController@getMessages')->name('api.getMessages');
Route::get('/api/getCountUsers/{room}', 'ApiController@getCountUsers')->name('api.getCountUsers'); //no se usa
Route::get('/api/getUserPrivateChat/{user}', 'ApiController@getUserPrivateChat')->name('api.getUserPrivateChat');
Route::post('/api/saveUsers', 'ApiController@saveUsers')->name('api.saveUsers');

//
Route::resources([
	'/admin/room' => 'Admin\RoomController'
]);

Route::get('/private_chat/stored/{user_private_id}', 'PrivateChatController@stored')->name('private_chat.stored');
Route::post('/private_chat/stored', 'PrivateChatController@stored_messages')->name('private_chat.stored_messages');
Route::get('/private_chat/getPrivateUser/{private}', 'PrivateChatController@getPrivateUser')->name('private_chat.getPrivateUser');
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
    $exp = explode(" ", $req->get('channel_name'));
    if($exp[0] == 'private'){
        $auth = $pusher->socket_auth($req->get('channel_name'), $req->get('socket_id'));
    }else{ //presence
        $x_user = new \App\XenUser;
        $x_user = $x_user->getUserById($req->session()->get('user'));
        $json = json_decode($x_user->json);

        $presence_data = [
            'user_id' => intval($req->session()->get('user')),
            'name' => $json->username,
            'role' => $json->secondary_group_ids
        ];
        $auth = $pusher->presence_auth(
            $req->get('channel_name'),
            $req->get('socket_id'),
            $req->session()->get('user'),
            $presence_data);
    }
    return $auth;
});

Route::prefix('room')->group(function(){
    //Route::post('selected', 'RoomController@selected')->name('room.selected');
    Route::get('change/{room}', 'RoomController@change')->name('room.change');
//    Route::get('getRoom', 'RoomController@getRooms')->name('room.getRoom');
    Route::get('getRoomsUser/{id}', 'RoomController@getRoomsUser')->name('room.getRoomsUser');
    //Route::get('exitRoom/{room}', 'RoomController@exitRoom')->name('room.exitRoom');
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
        Route::prefix('room')->group(function(){
            Route::get('getFromUser', 'RoomController@getFromUser')->name('room.getFromUser');
            Route::post('select', 'RoomController@select')->name('room.select');
            Route::post('exitRoom', 'RoomController@exitRoom')->name('room.exitRoom');
            Route::get('getRooms', 'RoomController@getRooms')->name('room.getRooms');
            Route::get('getRoom/{id}', 'RoomController@getRoom')->name('room.getRoom');
            Route::get('getRoomsByUser/{room_id}', 'RoomController@getRoomsByUser');
        });
    });
    Route::prefix('report')->group(function(){
        Route::post('check', 'ChatController@checkReportExist');
        Route::post('send', 'ChatController@sendReport');
    });
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
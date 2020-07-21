<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home/', 'HomeController@index')->name('home');
Route::get('/home/logout', 'HomeController@logout')->name('home.logout');

Route::prefix('room')->group(function(){
    Route::get('selected/{room}', 'RoomController@selected')->name('room.selected');
    Route::get('change/{room}', 'RoomController@change')->name('room.change');
    Route::get('getRoom', 'RoomController@getRooms')->name('room.getRoom');
    Route::get('getRoomsUser/{id}', 'RoomController@getRoomsUser')->name('room.getRoomsUser');
    Route::get('exitRoom/{room}', 'RoomController@exitRoom')->name('room.exitRoom');
});

//
Route::get('/api/getUser/{room}/{search?}', 'ApiController@getUser')->name('api.getUser');
Route::get('/api/getUserPrivate', 'ApiController@getUserPrivate')->name('api.getUserPrivate');
Route::get('/api/getMessages/{room}', 'ApiController@getMessages')->name('api.getMessages');
Route::get('/api/getCountUsers/{room}', 'ApiController@getCountUsers')->name('api.getCountUsers'); //no se usa
Route::get('/api/getUserPrivateChat/{user}', 'ApiController@getUserPrivateChat')->name('api.getUserPrivateChat');
Route::post('/api/saveUsers', 'ApiController@saveUsers')->name('api.saveUsers');
Route::post('/api/login', 'ApiController@login')->name('api.login');

//
Route::post('/chat/create', 'ChatController@create')->name('chat.create');

//
Route::resources([
	'/admin/room' => 'Admin\RoomController'
]);

Route::get('/private_chat/stored/{user_private_id}', 'PrivateChatController@stored')->name('private_chat.stored');
Route::post('/private_chat/stored', 'PrivateChatController@stored_messages')->name('private_chat.stored_messages');
Route::get('/private_chat/getPrivateUser/{private}', 'PrivateChatController@getPrivateUser')->name('private_chat.getPrivateUser');
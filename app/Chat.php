<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model{
	protected $table = 'chat';
    protected $fillable = [
        'user_id', 'room_id', 'messages', 'json'
    ];
}

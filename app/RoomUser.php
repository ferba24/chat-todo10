<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model{
	protected $table = 'room_user';
    protected $fillable = [
        'user_id', 'room_id',
    ];	
}

<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Room extends Model{
	protected $table = 'room';
    protected $fillable = [
        'room_name', 'room_description', 'room_photo',
    ];
}

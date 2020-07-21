<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateChatUser extends Model
{
    //
	protected $table = 'private_chat_user';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_private_id',
    ];
}

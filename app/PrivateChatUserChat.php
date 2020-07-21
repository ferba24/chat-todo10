<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateChatUserChat extends Model
{
    //
	protected $table = 'private_chat_user_chat';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'private_chat_user_id', 'user_id', 'messages',
    ];
}

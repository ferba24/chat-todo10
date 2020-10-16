<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $user;
    public $message;
    public $date;
    public $id;

    public function __construct($room, $user, $message, $date, $id){
        $this->room = $room;
        $this->user = $user;
        $this->message = $message;
        $this->date = $date;
        $this->id = $id;
    }
    public function broadcastOn(){
        return new PrivateChannel('chat');
    }
}

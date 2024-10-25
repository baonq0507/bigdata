<?php

namespace Adminftr\Messages\Http\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $userId;

    public $sender;

    public function __construct($message, $sender, $userId)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->sender = User::find($sender);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->userId);
    }

    public function broadcastWith()
    {

        return ['message' => $this->message, 'sender' => $this->sender];
    }
}

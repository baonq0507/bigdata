<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $sender;
    public $user;

    public function __construct($user, $message, $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->user = $user;
        $this->userId = $user->id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }

    public function broadcastWith()
    {

        return ['message' => $this->message, 'user' => $this->user, 'sender' => $this->sender];
    }
}

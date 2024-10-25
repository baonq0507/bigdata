<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserPrivateMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $senderId;
    public $userId;

    public function __construct($message, $senderId, $userId)
    {
        $this->message = $message;
        $this->senderId = $senderId;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }

    public function broadcastWith()
    {

        try {
            $sender = User::find($this->senderId);
            $user = User::find($this->userId);

            return ['message' => $this->message, 'sender' => $sender, 'user' => $user];
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
        }
    }
}

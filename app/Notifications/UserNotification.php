<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;

class UserNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $content;
    protected $userId;
    /**
     * Create a new notification instance.
     */
    public function __construct($userId, $title, $content)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database']; // Added 'database'
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toBroadcast(object $notifiable): array
    {
        return [
            'userId' => $this->userId,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }
}

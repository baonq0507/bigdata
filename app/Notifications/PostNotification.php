<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostNotification extends Notification
{
    use Queueable;

    public $type;
    public $content;
    public $title;
    public $id_post;
    public $user;
    public $id_comment;
    public function __construct($type, $content, $title,$id_post,$user,$id_comment)
    {
        $this->type = $type;
        $this->content = $content;
        $this->title = $title;
        $this->id_post = $id_post;
        $this->user = $user;
        $this->id_comment = $id_comment;
    }

    public function via($notifiable)
    {
        return ['database']; // Chọn kênh thông báo, ở đây là 'database'
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'content' => $this->content,
            'title' => $this->title,
            'id_post'=>$this->id_post,
            'user'=>$this->user,
            'id_comment'=>$this->id_comment
        ];
    }
}

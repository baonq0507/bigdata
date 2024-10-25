<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContractNotification extends Notification
{
    use Queueable;

    public $type;
    public $content;
    public $title;
    public $id_contract;
    public $user;
    public function __construct($type, $content, $title, $id_contract,$user)
    {
        $this->type = $type;
        $this->content = $content;
        $this->title = $title;
        $this->id_contract = $id_contract;
        $this->user = $user;
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
            'id_contract' => $this->id_contract,
            'user' => $this->user
        ];
    }
}

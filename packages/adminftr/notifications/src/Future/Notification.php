<?php

namespace Adminftr\Notifications\Future;

use Livewire\Component;

class Notification extends Component
{
    public $title;

    public $message;

    public $icon;

    public $time;

    public $color;

    public $type;

    public function title()
    {
        return $this->title;
    }

    public function send()
    {
        $this->dispatch('swalSuccess', [
            'message' => __('future::global.delete').' '.__('future::global.successfully'),
        ]);
    }

    public function render()
    {
        return view('notifications::notifications.notification');
    }
}

<?php

namespace Adminftr\Core\Future\Admin;

use Livewire\Component;

class Notifications extends Component
{
    public $page = 10;

    public function getListeners()
    {
        return [
            'ReadNotification' => 'render',
            'loadMore' => 'loadMore',
        ];
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate($this->page);

        $perPage = $this->page;

        return view('future::future.notifications.index', compact('notifications', 'perPage'));
    }

    public function loadMore()
    {
        $this->page += 10;
    }
}

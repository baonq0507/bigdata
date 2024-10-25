<?php

namespace Adminftr\Notifications\Future;

use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Lazy]
class NotificationIcon extends Component
{
    public $count = 0;

    public function mount()
    {

    }

    public function getListeners()
    {
        return [
            'ReadNotification' => 'loadCount',
            'reloadNotification' => 'loadCount',
        ];
    }

    public function render()
    {
        return view('notifications::notifications.icon', ['count' => $this->getCount()]);
    }

    protected function getCount()
    {
        $user = auth()->user();
        $this->count = $user->unreadNotifications->count();
        return $this->count > 99 ? '99+' : $this->count;
    }

    public function loadCount()
    {
        $this->count = auth()->user()->unreadNotifications->count();
    }
}

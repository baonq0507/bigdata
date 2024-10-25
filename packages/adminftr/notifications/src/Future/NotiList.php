<?php

namespace Adminftr\Notifications\Future;

use Exception;
use Livewire\Component;

class NotiList extends Component
{
    public $page = 10;

    public $show = false;

    public function getListeners()
    {
        return [
            'readAll' => 'readAll',
            'markAsRead' => 'markAsRead',
            'showNotifications' => 'show',
            'reloadNotification' => 'render',
        ];
    }

    public function show()
    {
        $this->show = true;
    }

    public function render()
    {
        $notifications = [];
        if ($this->show) {
            $notifications = auth()->user()->notifications()->paginate($this->page);
        }
        $perPage = $this->page;

        return view('notifications::notifications.lists', compact('notifications', 'perPage'));
    }

    public function loadMore()
    {
        $this->page += 10;
    }

    public function readAll()
    {
        try {
            auth()->user()->unreadNotifications->markAsRead();
            $this->dispatch('ReadNotification');
            $this->dispatch('alert-success', __('future::global.success').' '.__('future::notifications.read_all_notifications'));
        } catch (Exception $exception) {
            $this->dispatch('alert-error', __('future::global.error').' '.__('future::global.error_occurred'));
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('ReadNotification');
            $this->dispatch('alert-success', __('future::notifications.read_this_notification'));

            return;
        }
        $this->dispatch('alert-error', __('future::global.not_found').' '.__('future::notifications.notification'));
    }
}

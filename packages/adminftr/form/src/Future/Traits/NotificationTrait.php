<?php

namespace Adminftr\Form\Future\Traits;

trait NotificationTrait
{
    protected function notificationOk($message)
    {
        $this->dispatch('alert-success', 'Success', $message);
    }

    protected function notificationError($message)
    {
        $this->dispatch('alert-error', 'Error', $message);
    }
}

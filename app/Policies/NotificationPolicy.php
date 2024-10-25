<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Notification $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return false;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, Notification $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Notification $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Notification $model): bool
    {
        return false;
    }

    public function delete(User $user, Notification $model): bool
    {
        return false;
    }
}

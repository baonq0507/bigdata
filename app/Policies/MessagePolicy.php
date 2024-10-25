<?php

namespace App\Policies;


use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;



class MessagePolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Message $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return true;
    }

    public function update(User $user, Message $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Message $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Message $model): bool
    {
        return true;
    }

    public function delete(User $user, Message $model): bool
    {
        return true;
    }
}

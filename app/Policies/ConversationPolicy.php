<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ConversationPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Conversation $model): bool
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

    public function update(User $user, Conversation $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Conversation $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Conversation $model): bool
    {
        return true;
    }

    public function delete(User $user, Conversation $model): bool
    {
        return true;
    }
}

<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Comment $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, Comment $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Comment $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Comment $model): bool
    {
        return false;
    }

    public function delete(User $user, Comment $model): bool
    {
        return true;
    }
}

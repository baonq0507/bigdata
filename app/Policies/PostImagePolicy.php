<?php

namespace App\Policies;


use App\Models\PostImage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostImagePolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, PostImage $model): bool
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

    public function update(User $user, PostImage $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, PostImage $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, PostImage $model): bool
    {
        return true;
    }

    public function delete(User $user, PostImage $model): bool
    {
        return true;
    }
}

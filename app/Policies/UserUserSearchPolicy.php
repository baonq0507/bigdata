<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserUserSearch;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserUserSearchPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, UserUserSearch $model): bool
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

    public function update(User $user, UserUserSearch $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, UserUserSearch $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, UserUserSearch $model): bool
    {
        return true;
    }

    public function delete(User $user, UserUserSearch $model): bool
    {
        return true;
    }
}

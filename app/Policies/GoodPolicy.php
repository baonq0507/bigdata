<?php

namespace App\Policies;

use App\Models\Good;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoodPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Good $model): bool
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

    public function update(User $user, Good $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Good $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Good $model): bool
    {
        return true;
    }

    public function delete(User $user, Good $model): bool
    {
        return true;
    }
}

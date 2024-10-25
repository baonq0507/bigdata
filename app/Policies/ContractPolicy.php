<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Contract $model): bool
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

    public function update(User $user, Contract $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Contract $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Contract $model): bool
    {
        return true;
    }

    public function delete(User $user, Contract $model): bool
    {
        return true;
    }
}

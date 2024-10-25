<?php

namespace App\Policies;

use App\Models\PartyBInfo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartyBInfoPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, PartyBInfo $model): bool
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

    public function update(User $user, PartyBInfo $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, PartyBInfo $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, PartyBInfo $model): bool
    {
        return true;
    }

    public function delete(User $user, PartyBInfo $model): bool
    {
        return true;
    }
}

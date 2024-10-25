<?php

namespace App\Policies;

use App\Models\PartyAInfo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartyAInfoPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, PartyAInfo $model): bool
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

    public function update(User $user, PartyAInfo $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, PartyAInfo $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, PartyAInfo $model): bool
    {
        return true;
    }

    public function delete(User $user, PartyAInfo $model): bool
    {
        return true;
    }
}

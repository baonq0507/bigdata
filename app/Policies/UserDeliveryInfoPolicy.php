<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserDeliveryInfo;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDeliveryInfoPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, UserDeliveryInfo $model): bool
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

    public function update(User $user, UserDeliveryInfo $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, UserDeliveryInfo $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, UserDeliveryInfo $model): bool
    {
        return true;
    }

    public function delete(User $user, UserDeliveryInfo $model): bool
    {
        return true;
    }
}

<?php

namespace App\Policies;
use App\Models\User;
use App\Enums\UserRole;


class UserPolicy
{
    public function __construct()
    {
        //
    }

    public function isAdmin(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function isOwner(User $user): bool
    {
        return $user->role === UserRole::DONO;
    }
}

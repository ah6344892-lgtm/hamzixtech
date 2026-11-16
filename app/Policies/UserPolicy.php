<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool { return $user->can('view users'); }
    public function create(User $user): bool { return $user->can('create users'); }

    public function update(User $user, User $target): bool
    {
        if (! $user->can('edit users')) {
            return false;
        }

        return ! $target->hasRole('Super Admin') || $user->hasRole('Super Admin');
    }

    public function delete(User $user, User $target): bool
    {
        if (! $user->can('delete users') || $user->is($target)) {
            return false;
        }

        if (! $target->hasRole('Super Admin')) {
            return true;
        }

        return $user->hasRole('Super Admin') &&
            (! $target->is_active || User::role('Super Admin')->where('is_active', true)->count() > 1);
    }

    public function deactivate(User $user, User $target): bool
    {
        if (! $user->can('deactivate users')) {
            return false;
        }

        if (! $target->hasRole('Super Admin')) {
            return true;
        }

        return $user->hasRole('Super Admin') &&
            User::role('Super Admin')->where('is_active', true)->count() > 1;
    }

    public function assignRoles(User $user, User $target): bool
    {
        return $user->hasRole('Super Admin') || $user->can('assign user roles');
    }
}

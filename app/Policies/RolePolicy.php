<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('Super Admin') || $user->can('manage roles'); }
    public function create(User $user): bool { return $user->hasRole('Super Admin') || $user->can('manage roles'); }
    public function update(User $user, Role $role): bool { return $this->mayManage($user, $role); }
    public function delete(User $user, Role $role): bool { return $this->mayManage($user, $role); }

    private function mayManage(User $user, Role $role): bool
    {
        if (! $user->hasRole('Super Admin') && ! $user->can('manage roles')) {
            return false;
        }

        return $role->name !== 'Super Admin' || $user->hasRole('Super Admin');
    }
}

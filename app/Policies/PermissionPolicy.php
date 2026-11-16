<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('Super Admin') || $user->can('manage permissions'); }
    public function create(User $user): bool { return $user->hasRole('Super Admin') || $user->can('manage permissions'); }
    public function update(User $user, Permission $permission): bool { return $this->mayManage($user, $permission); }
    public function delete(User $user, Permission $permission): bool { return $this->mayManage($user, $permission); }

    private function mayManage(User $user, Permission $permission): bool
    {
        return ($user->hasRole('Super Admin') || $user->can('manage permissions')) &&
            ($permission->name !== 'manage permissions' || $user->hasRole('Super Admin'));
    }
}

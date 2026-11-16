<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool { return $user->can('view posts') || $user->can('view tutorials') || $user->can('view templates') || $user->can('view tools') || $user->can('view projects'); }

    public function create(User $user, ?string $type = null): bool
    {
        return $this->permissionFor($user, $type);
    }

    public function update(User $user, Category $category): bool { return $this->permissionFor($user, $category->type); }
    public function delete(User $user, Category $category): bool { return $this->permissionFor($user, $category->type); }

    private function permissionFor(User $user, ?string $type): bool
    {
        $permission = match ($type) {
            'posts' => 'manage post categories',
            'tutorials' => 'manage tutorial categories',
            'templates' => 'manage template categories',
            'tools' => 'manage tools',
            'projects' => 'manage project categories',
            default => null,
        };

        return $permission !== null && $user->can($permission);
    }
}

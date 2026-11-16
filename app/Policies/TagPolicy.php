<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function viewAny(User $user): bool { return $user->can('view posts') || $user->can('view tutorials') || $user->can('view templates'); }
    public function create(User $user): bool { return $this->canManage($user); }
    public function update(User $user, Tag $tag): bool { return $this->canManage($user); }
    public function delete(User $user, Tag $tag): bool { return $this->canManage($user); }

    private function canManage(User $user): bool
    {
        return $user->can('manage post tags') || $user->can('manage tutorial tags') || $user->can('manage template tags');
    }
}

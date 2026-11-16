<?php

namespace App\Policies;

use App\Models\Tutorial;
use App\Models\User;

class TutorialPolicy
{
    public function viewAny(User $user): bool { return $user->can('view tutorials'); }

    public function view(User $user, Tutorial $tutorial): bool
    {
        return $user->can('view tutorials') && (
            $tutorial->status === 'published' ||
            $user->can('edit tutorials') ||
            $tutorial->author_id === $user->id
        );
    }

    public function create(User $user): bool { return $user->can('create tutorials'); }

    public function update(User $user, Tutorial $tutorial): bool
    {
        return $user->can('edit tutorials') && (
            $user->hasAnyRole(['Super Admin', 'Admin', 'Manager']) ||
            $tutorial->author_id === $user->id
        );
    }

    public function delete(User $user, Tutorial $tutorial): bool { return $user->can('delete tutorials'); }
    public function publish(User $user, Tutorial $tutorial): bool { return $user->can('publish tutorials'); }
}

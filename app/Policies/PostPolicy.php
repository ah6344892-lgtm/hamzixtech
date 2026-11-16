<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool { return $user->can('view posts'); }

    public function view(User $user, Post $post): bool
    {
        return $user->can('view posts') && (
            $post->status === 'published' ||
            $user->can('edit posts') ||
            $post->author_id === $user->id
        );
    }

    public function create(User $user): bool { return $user->can('create posts'); }

    public function update(User $user, Post $post): bool
    {
        return $user->can('edit posts') && (
            $user->hasAnyRole(['Super Admin', 'Admin', 'Manager']) ||
            $post->author_id === $user->id
        );
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->can('delete posts') && (
            $user->hasAnyRole(['Super Admin', 'Admin', 'Manager']) ||
            $post->author_id === $user->id
        );
    }

    public function publish(User $user, Post $post): bool { return $user->can('publish posts'); }
}

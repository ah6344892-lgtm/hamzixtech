<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool { return $user->can('view projects'); }
    public function view(User $user, Project $project): bool { return $user->can('view projects') && ($project->status === 'published' || $user->can('edit projects')); }
    public function create(User $user): bool { return $user->can('create projects') && $user->can('manage projects'); }
    public function update(User $user, Project $project): bool { return $user->can('edit projects') && $user->can('manage projects'); }
    public function delete(User $user, Project $project): bool { return $user->can('delete projects') && $user->can('manage projects'); }
    public function publish(User $user, Project $project): bool { return $user->can('publish projects') && $user->can('manage projects'); }
}

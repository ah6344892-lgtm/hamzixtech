<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;

class ToolPolicy
{
    public function viewAny(User $user): bool { return $user->can('view tools'); }
    public function view(User $user, Tool $tool): bool { return $user->can('view tools') && ($tool->status === 'published' || $user->can('edit tools')); }
    public function create(User $user): bool { return $user->can('create tools'); }
    public function update(User $user, Tool $tool): bool { return $user->can('edit tools') && $user->can('manage tools'); }
    public function delete(User $user, Tool $tool): bool { return $user->can('delete tools') && $user->can('manage tools'); }
    public function publish(User $user, Tool $tool): bool { return $user->can('publish tools') && $user->can('manage tools'); }
}

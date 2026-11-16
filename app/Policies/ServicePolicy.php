<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool { return $user->can('view services'); }
    public function view(User $user, Service $service): bool { return $user->can('view services') && ($service->status === 'published' || $user->can('edit services')); }
    public function create(User $user): bool { return $user->can('create services') && $user->can('manage services'); }
    public function update(User $user, Service $service): bool { return $user->can('edit services') && $user->can('manage services'); }
    public function delete(User $user, Service $service): bool { return $user->can('delete services') && $user->can('manage services'); }
    public function publish(User $user, Service $service): bool { return $user->can('publish services') && $user->can('manage services'); }
}

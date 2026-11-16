<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool { return $user->can('view contact messages'); }
    public function view(User $user, ContactMessage $message): bool { return $user->can('view contact messages'); }
    public function update(User $user, ContactMessage $message): bool { return $user->can('view contact messages'); }
    public function reply(User $user, ContactMessage $message): bool { return $user->can('reply contact messages'); }
    public function delete(User $user, ContactMessage $message): bool { return $user->can('delete contact messages'); }
}

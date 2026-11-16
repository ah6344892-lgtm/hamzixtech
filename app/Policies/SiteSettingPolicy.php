<?php

namespace App\Policies;

use App\Models\SiteSetting;
use App\Models\User;

class SiteSettingPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage settings'); }
    public function update(User $user, SiteSetting $setting): bool { return $user->can('manage settings'); }
}

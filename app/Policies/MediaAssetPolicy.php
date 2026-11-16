<?php

namespace App\Policies;

use App\Models\MediaAsset;
use App\Models\User;

class MediaAssetPolicy
{
    public function viewAny(User $user): bool { return $user->can('view media') || $user->can('manage media'); }
    public function create(User $user): bool { return $user->can('manage media'); }
    public function delete(User $user, MediaAsset $asset): bool { return $user->can('manage media'); }
}

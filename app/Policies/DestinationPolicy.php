<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;

class DestinationPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Destination $d): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Destination $d): bool { return $user->role === 'admin'; }
    public function delete(User $user, Destination $d): bool { return $user->role === 'admin'; }
}


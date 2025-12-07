<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
    public function delete(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
}


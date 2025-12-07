<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Category $c): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Category $c): bool { return $user->role === 'admin'; }
    public function delete(User $user, Category $c): bool { return $user->role === 'admin'; }
}


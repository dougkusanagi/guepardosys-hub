<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Category $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }

    public function restore(User $user, Category $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }
}

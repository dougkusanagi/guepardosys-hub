<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Product $product): bool
    {
        return $user->tenant_id === $product->tenant_id || is_null($user->tenant_id);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->tenant_id === $product->tenant_id || is_null($user->tenant_id);
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->tenant_id === $product->tenant_id || is_null($user->tenant_id);
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->tenant_id === $product->tenant_id || is_null($user->tenant_id);
    }
}

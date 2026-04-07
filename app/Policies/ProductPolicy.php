<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    // User hanya boleh edit/update produk miliknya sendiri
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    // User boleh hapus milik sendiri, tapi ADMIN boleh hapus milik siapa saja
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->role === 'admin';
    }
}

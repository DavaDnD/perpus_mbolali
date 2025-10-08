<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KategoriPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Kategori $kategori): bool { return true; }

    // Hanya Officer & Admin bisa create/update/delete
    public function create(User $user): bool {
        return in_array($user->role, ['Admin','Officer']);
    }
    public function update(User $user, Kategori $kategori): bool {
        return in_array($user->role, ['Admin','Officer']);
    }
    public function delete(User $user, Kategori $kategori): bool {
        return in_array($user->role, ['Admin','Officer']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kategori $kategori): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kategori $kategori): bool
    {
        return false;
    }
}

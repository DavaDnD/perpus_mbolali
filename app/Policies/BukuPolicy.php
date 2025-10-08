<?php

namespace App\Policies;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BukuPolicy
{
    // Semua role bisa lihat
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Buku $buku): bool { return true; }

    // Hanya Officer & Admin bisa create/update/delete
    public function create(User $user): bool {
        return in_array($user->role, ['Admin','Officer']);
    }
    public function update(User $user, Buku $buku): bool {
        return in_array($user->role, ['Admin','Officer']);
    }
    public function delete(User $user, Buku $buku): bool {
        return in_array($user->role, ['Admin','Officer']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Buku $buku): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Buku $buku): bool
    {
        return false;
    }
}

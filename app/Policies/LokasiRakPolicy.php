<?php

namespace App\Policies;

use App\Models\LokasiRak;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LokasiRakPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, LokasiRak $lokasiRak): bool { return true; }

    // hanya Officer & Admin yang boleh tambah / ubah / hapus
    public function create(User $user): bool {
        return in_array($user->role, ['Admin','Officer']);
    }

    public function update(User $user, LokasiRak $lokasiRak): bool {
        return in_array($user->role, ['Admin','Officer']);
    }

    public function delete(User $user, LokasiRak $lokasiRak): bool {
        return in_array($user->role, ['Admin','Officer']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LokasiRak $lokasiRak): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LokasiRak $lokasiRak): bool
    {
        return false;
    }
}

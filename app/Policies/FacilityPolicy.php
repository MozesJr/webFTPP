<?php

namespace App\Policies;

use App\Models\Facility;
use App\Models\User;

class FacilityPolicy
{
    /**
     * Determine if the user can view any facilities.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can view the facility.
     */
    public function view(User $user, Facility $facility): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can create facilities.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can update the facility.
     */
    public function update(User $user, Facility $facility): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can delete the facility.
     */
    public function delete(User $user, Facility $facility): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if the user can restore the facility.
     */
    public function restore(User $user, Facility $facility): bool
    {
        return $user->hasRole('super_admin');
    }
}

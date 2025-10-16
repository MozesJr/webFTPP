<?php

namespace App\Policies;

use App\Models\DeanGreeting;
use App\Models\User;

class DeanGreetingPolicy
{
    /**
     * Determine if the user can view any dean greetings.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can view the dean greeting.
     */
    public function view(User $user, DeanGreeting $deanGreeting): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can create dean greetings.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can update the dean greeting.
     */
    public function update(User $user, DeanGreeting $deanGreeting): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine if the user can delete the dean greeting.
     */
    public function delete(User $user, DeanGreeting $deanGreeting): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if the user can restore the dean greeting.
     */
    public function restore(User $user, DeanGreeting $deanGreeting): bool
    {
        return $user->hasRole('super_admin');
    }
}

<?php

namespace App\Policies\Event;

use App\Models\Clean\User;
use App\Models\Event\Organizer;

class OrganizerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage-organizers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Organizer $organizer): bool
    {
        return $user->hasPermissionTo('manage-organizers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage-organizers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organizer $organizer): bool
    {
        return $user->hasPermissionTo('manage-organizers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Organizer $organizer): bool
    {
        return $user->hasPermissionTo('manage-organizers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Organizer $organizer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Organizer $organizer): bool
    {
        return false;
    }
}

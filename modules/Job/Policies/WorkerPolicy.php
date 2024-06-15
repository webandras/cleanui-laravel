<?php

namespace Modules\Job\Policies;

use Modules\Auth\Models\User;
use Modules\Job\Models\Worker;

class WorkerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage-workers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Worker $worker): bool
    {
        return $user->hasPermissionTo('manage-workers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage-workers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Worker $worker): bool
    {
        return $user->hasPermissionTo('manage-workers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Worker $worker): bool
    {
        return $user->hasPermissionTo('manage-workers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Worker $worker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Worker $worker): bool
    {
        return false;
    }
}

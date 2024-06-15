<?php

namespace Modules\Auth\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;

interface UserRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedUsersWithRoles(): LengthAwarePaginator;


    /**
     * @param  array  $data
     * @return User
     */
    public function createUser(array $data): User;


    /**
     * @param  User  $user
     * @return bool
     */
    public function deleteUser(User $user): bool;


    /**
     * @param  User  $user
     * @param  array  $data
     * @return bool
     */
    public function updateUser(User $user, array $data): bool;


    /**
     * @param  User  $user
     * @param  array  $data
     *
     * @return Model
     */
    public function updateUserPreferences(User $user, array $data): Model;


    /**
     * @return bool
     */
    public function userHasPreferences(): bool;
}

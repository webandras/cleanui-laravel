<?php

namespace App\Repository\Clean;

use App\Interface\Entities\Clean\UserInterface;
use App\Interface\Repository\Clean\UserRepositoryInterface;
use App\Models\Clean\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedUsersWithRoles(): LengthAwarePaginator
    {
        return User::orderBy('created_at', 'DESC')
            ->with('role')
            ->paginate(UserInterface::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @param  array  $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }


    /**
     * @param  User  $user
     * @return bool
     * @throws \Throwable
     */
    public function deleteUser(User $user): bool
    {
        return $user->deleteOrFail();
    }


    /**
     * @param  User  $user
     * @param  array  $data
     * @return bool
     * @throws \Throwable
     */
    public function updateUser(User $user, array $data): bool
    {
        return $user->updateOrFail($data);
    }
}

<?php

namespace App\Repository\Clean;

use App\Interface\Entities\Clean\UserInterface;
use App\Interface\Repository\Clean\UserRepositoryInterface;
use App\Models\Clean\User;
use App\Models\Clean\UserSetting;
use Illuminate\Database\Eloquent\Model;
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


    /**
     * @param  User  $user
     * @param  array  $data
     *
     * @return Model
     */
    public function updateUserPreferences(User $user, array $data): Model
    {
        return $user->preferences()->updateOrCreate([ 'user_id' => $user->id ], $data);
    }


    /**
     * @return bool
     */
    public function userHasPreferences(): bool
    {
        return array_key_exists('App\Trait\Clean\HasPreferences', class_uses_recursive(User::class));
    }
}

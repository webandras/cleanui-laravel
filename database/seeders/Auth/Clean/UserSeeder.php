<?php

namespace Database\Seeders\Auth\Clean;

use App\Models\Clean\Role;
use App\Models\Clean\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdmin = Role::where('slug', 'super-administrator')->firstOrFail();
        $admin = Role::where('slug', 'administrator')->firstOrFail();
        $customer = Role::where('slug', 'customer')->firstOrFail();

        $user1 = new User();
        $user1->name = 'Gulácsi András';
        $user1->email = 'gulandras90@gmail.com';
        $user1->password = bcrypt('FSrztfvr5gii2');
        $user1->enable_2fa = 1;
        $user1->role()->associate($superAdmin);
        $user1->save();

        $user2 = new User();
        $user2->name = 'John Doe';
        $user2->email = 'john@doe.com';
        $user2->password = bcrypt('password');
        $user2->save();
        $user2->role()->associate($admin);

        $user2 = new User();
        $user2->name = 'Finn Gabika';
        $user2->email = 'finn@gabika.com';
        $user2->password = bcrypt('password');
        $user2->save();
        $user2->role()->associate($customer);

    }
}

<?php

namespace Database\Seeders\Auth\Clean;

use App\Models\Clean\Role;
use App\Models\Clean\User;
use Faker\Factory;
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
        $faker = Factory::create();

        $superAdmin = Role::where('slug', 'super-administrator')->firstOrFail();
        $admin = Role::where('slug', 'administrator')->firstOrFail();
        $customer = Role::where('slug', 'customer')->firstOrFail();

        $user1 = new User();
        $user1->name = 'Gulácsi András';
        $user1->email = 'gulandras90@gmail.com';
        $user1->password = bcrypt('g9QFR&bvsBW;ZrT%1)Fd');
        $user1->enable_2fa = 1;
        $user1->role()->associate($superAdmin);
        $user1->save();

        $user2 = new User();
        $user2->name = $faker->name();
        $user2->email = $faker->safeEmail();
        $user2->password = bcrypt('bHYm2YnR^0Dpmxb17k^2');
        $user2->save();
        $user2->role()->associate($admin);

        $user2 = new User();
        $user2->name = $faker->name();
        $user2->email = $faker->safeEmail();
        $user2->password = bcrypt('3dSRqkUBafX(w8W7Dut(');
        $user2->save();
        $user2->role()->associate($customer);

    }
}

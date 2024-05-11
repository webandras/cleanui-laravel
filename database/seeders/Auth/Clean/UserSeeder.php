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

        User::factory(1)->create([
            'name' => 'András Gulácsi',
            'email' => 'gulandras90@gmail.com',
            'password' => bcrypt('FSrztfvr5gii2'),
            'enable_2fa' => 1,
            'role_id' => $superAdmin->id
        ]);

        User::factory(1)->create([
            'role_id' => $admin->id
        ]);

        User::factory(1)->create([
            'role_id' => $customer->id
        ]);

    }
}

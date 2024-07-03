<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;

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
            'password' => bcrypt('g9QFR&bvsBW;ZrT%1)Fd'),
            'enable_2fa' => 1,
            'role_id' => $superAdmin->id
        ]);

        User::factory(1)->create([
            'role_id' => $admin->id,
            'password' => bcrypt('bHYm2YnR^0Dpmxb17k^2'),
        ]);

        User::factory(1)->create([
            'role_id' => $customer->id,
            'password' => '3dSRqkUBafX(w8W7Dut(',
        ]);

    }
}

<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'Super administrator';
        $admin->slug = 'super-administrator';
        $admin->save();

        $admin = new Role();
        $admin->name = 'Administrator';
        $admin->slug = 'administrator';
        $admin->save();

        $customer = new Role();
        $customer->name = 'Customer';
        $customer->slug = 'customer';
        $customer->save();
    }
}

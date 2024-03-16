<?php

namespace Database\Seeders\Auth\Clean;

use App\Models\Clean\Role;
use Illuminate\Database\Seeder;

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

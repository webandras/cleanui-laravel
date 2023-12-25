<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Auth\PermissionSeeder;
use Database\Seeders\Auth\RoleSeeder;
use Database\Seeders\Auth\RolesPermissionsPivotSeeder;
use Database\Seeders\Auth\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders for users, authorization
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolesPermissionsPivotSeeder::class);
        $this->call(UserSeeder::class);
        // Seeders for users, authorization END

        // BLOG
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostTagsCategoriesSeeder::class);
    }
}

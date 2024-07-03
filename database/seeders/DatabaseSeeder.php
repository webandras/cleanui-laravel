<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\PermissionSeeder;
use Modules\Auth\Database\Seeders\RoleSeeder;
use Modules\Auth\Database\Seeders\RolesPermissionsPivotSeeder;
use Modules\Auth\Database\Seeders\UserSeeder;
use Modules\Blog\Database\Seeders\CategorySeeder;
use Modules\Blog\Database\Seeders\CleanModulePermissionsSeeder;
use Modules\Blog\Database\Seeders\DocumentSeeder;
use Modules\Blog\Database\Seeders\PostSeeder;
use Modules\Blog\Database\Seeders\PostTagsCategoriesSeeder;
use Modules\Blog\Database\Seeders\TagSeeder;
use Modules\Event\Database\Seeders\EventDetailSeeder;
use Modules\Event\Database\Seeders\EventModulePermissionsSeeder;
use Modules\Event\Database\Seeders\EventSeeder;
use Modules\Event\Database\Seeders\LocationSeeder;
use Modules\Event\Database\Seeders\OrganizerSeeder;
use Modules\Job\Database\Seeders\ClientSeeder;
use Modules\Job\Database\Seeders\JobModulePermissionsSeeder;
use Modules\Job\Database\Seeders\JobSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders for users, authorization
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolesPermissionsPivotSeeder::class,
            UserSeeder::class
        ]);
        // Seeders for users, authorization END


        // BLOG
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            PostTagsCategoriesSeeder::class,
            DocumentSeeder::class,
            CleanModulePermissionsSeeder::class,
        ]);


        // JOBS
        $this->call([
            ClientSeeder::class,
            JobSeeder::class,
            JobModulePermissionsSeeder::class,
        ]);


        // EVENTS
        $this->call([
            LocationSeeder::class,
            OrganizerSeeder::class,
            EventSeeder::class,
            EventDetailSeeder::class,
            EventModulePermissionsSeeder::class,
        ]);

    }
}

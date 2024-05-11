<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Auth\Clean\PermissionSeeder;
use Database\Seeders\Auth\Clean\RoleSeeder;
use Database\Seeders\Auth\Clean\RolesPermissionsPivotSeeder;
use Database\Seeders\Auth\Clean\UserSeeder;
use Database\Seeders\Clean\CategorySeeder;
use Database\Seeders\Clean\DocumentSeeder;
use Database\Seeders\Clean\PostSeeder;
use Database\Seeders\Clean\PostTagsCategoriesSeeder;
use Database\Seeders\Clean\TagSeeder;
use Database\Seeders\Event\ClientsWorkersMediaPermissionsSeeder;
use Database\Seeders\Event\EventDetailSeeder;
use Database\Seeders\Event\EventModulePermissionsSeeder;
use Database\Seeders\Event\EventSeeder;
use Database\Seeders\Event\LocationSeeder;
use Database\Seeders\Event\OrganizerSeeder;
use Database\Seeders\Job\ClientSeeder;
use Database\Seeders\Job\JobSeeder;
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


        // DOCS
        $this->call(DocumentSeeder::class);


        // JOBS
        $this->call(ClientSeeder::class);
        $this->call(JobSeeder::class);


        // EVENTS
        $this->call(LocationSeeder::class);
        $this->call(OrganizerSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(EventDetailSeeder::class);

        $this->call(EventModulePermissionsSeeder::class);
        $this->call(ClientsWorkersMediaPermissionsSeeder::class);

//        $this->call(CommentSeeder::class);
    }
}

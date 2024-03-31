<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Event\EventModulePermissionsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     /*   // Seeders for users, authorization
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
        $this->call(JobSeeder::class);
        $this->call(ClientSeeder::class);


        // EVENTS
        $this->call(LocationSeeder::class);
        $this->call(OrganizerSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(EventDetailSeeder::class);*/

        $this->call(EventModulePermissionsSeeder::class);
    }
}

<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;
use Modules\Auth\Traits\HasRolesPermissionsGetters;

class CleanModulePermissionsSeeder extends Seeder
{
    use HasRolesPermissionsGetters;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manageCats = new Permission();
        $manageCats->name = 'Manage Categories';
        $manageCats->slug = 'manage-categories';
        $manageCats->save();

        $managePosts = new Permission();
        $managePosts->name = 'Manage Posts';
        $managePosts->slug = 'manage-posts';
        $managePosts->save();

        $manageTags = new Permission();
        $manageTags->name = 'Manage Tags';
        $manageTags->slug = 'manage-tags';
        $manageTags->save();

        $manageDocuments = new Permission();
        $manageDocuments->name = 'Manage Documents';
        $manageDocuments->slug = 'manage-documents';
        $manageDocuments->save();

        $manageMedia = new Permission();
        $manageMedia->name = 'Manage Media';
        $manageMedia->slug = 'manage-media';
        $manageMedia->save();

        $newPermissions = [$manageCats->id, $managePosts->id, $manageTags->id, $manageDocuments->id, $manageMedia->id];

        // Add permissions to the super-administrator
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->attach($newPermissions);

        // Add permissions to the administrator
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->attach($newPermissions);
    }
}

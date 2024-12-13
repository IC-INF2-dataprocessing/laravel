<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define Permissions
        $permissions = [
            'view_financial',
            'view_sensitive',
            'view_general',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $junior = Role::where('name', 'Junior')->first();
        $medior = Role::where('name', 'Medior')->first();
        $senior = Role::where('name', 'Senior')->first();

        // Senior: All permissions
        $senior->permissions()->sync(Permission::all()->pluck('id'));

        // Medior: All except 'view_financial'
        $medior->permissions()->sync(
            Permission::where('name', '!=', 'view_financial')->pluck('id')
        );

        // Junior: Only 'view_general'
        $junior->permissions()->sync(
            Permission::where('name', 'view_general')->pluck('id')
        );
    }
}

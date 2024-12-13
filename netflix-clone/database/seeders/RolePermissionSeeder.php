<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define the permissions
        $permissions = [
            'view_general',
            'view_financial',
            'view_sensitive',
        ];

        // Create or fetch permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to roles
        $roles = [
            'Junior' => ['view_general'], // Juniors only have access to general information
            'Medior' => ['view_general', 'view_sensitive'], // Mediors don't see financial data
            'Senior' => ['view_general', 'view_sensitive', 'view_financial'], // Seniors see everything
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $permissionIds = Permission::whereIn('name', $permissions)->pluck('id');
                $role->permissions()->sync($permissionIds); // Attach permissions to the role
            }
        }
    }
}

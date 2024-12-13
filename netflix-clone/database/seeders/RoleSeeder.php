<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Junior', 'Medior', 'Senior'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}

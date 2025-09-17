<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Create Admin Role
            $adminRole = Role::firstOrCreate([
                'name' => 'Administrador',
                'guard_name' => 'web',
            ]);

            // Create Permissions
            $permissions = [
                ['name' => 'Gestor de usuarios', 'guard_name' => 'web'],
                ['name' => 'Dashboard', 'guard_name' => 'web'],
                ['name' => 'Gestión Previsional', 'guard_name' => 'web'],
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate($permission);
            }

            // Assign all permissions to Admin role
            $adminRole->syncPermissions(Permission::all());

            // Assign role to User ID 1
            $user = User::firstOrCreate(
                ['id' => 1],
                [
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password'),
                ]
            );

            $user->assignRole($adminRole);
        });
    }
}

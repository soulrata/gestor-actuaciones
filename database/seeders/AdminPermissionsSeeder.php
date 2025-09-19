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
            // Create SuperAdmin Role
            $superRole = Role::firstOrCreate([
                'name' => 'SuperAdmin',
                'guard_name' => 'web',
            ]);

            // Define permission slugs used by the sidebar and system
            $permissionSlugs = [
                // Dashboard
                ['name' => 'Dashboard', 'guard_name' => 'web'],

                // Gestor SuperAdmin
                ['name' => 'Gestor SuperAdmin', 'guard_name' => 'web'],

                // Ecosystem inbox / tracking
                ['name' => 'ecosystem.inbox.assigned', 'guard_name' => 'web'],
                ['name' => 'ecosystem.inbox.team', 'guard_name' => 'web'],
                ['name' => 'ecosystem.inbox.due', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.search', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.history', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.reports', 'guard_name' => 'web'],

                // Flows design
                ['name' => 'Gestor de estados', 'guard_name' => 'web'],
                ['name' => 'Diseñador de Secuencias', 'guard_name' => 'web'],
                ['name' => 'ecosystem.flows.states', 'guard_name' => 'web'],
                ['name' => 'ecosystem.flows.transitions', 'guard_name' => 'web'],

                // Team management
                ['name' => 'Roles y Permisos del Ecosistema', 'guard_name' => 'web'],
                ['name' => 'Usuarios del Ecosistema', 'guard_name' => 'web'],
            ];

            foreach ($permissionSlugs as $perm) {
                Permission::firstOrCreate($perm);
            }

            // Assign all permissions to SuperAdmin
            $superRole->syncPermissions(Permission::all());

            // Ensure admin user exists (by email) and assign SuperAdmin role
            $user = User::firstOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Administrador',
                    'password' => bcrypt('12345678'),
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole($superRole);
        });
    }
}

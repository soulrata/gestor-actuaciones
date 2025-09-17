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
                ['name' => 'dashboard.general', 'guard_name' => 'web'],

                // System management
                ['name' => 'system.users.manage', 'guard_name' => 'web'],
                ['name' => 'system.users.assign_superadmin', 'guard_name' => 'web'],
                ['name' => 'system.users.assign_admin_ecosistema', 'guard_name' => 'web'],
                ['name' => 'system.users.assign_operational_roles', 'guard_name' => 'web'],
                ['name' => 'system.roles.manage', 'guard_name' => 'web'],

                // Ecosystem inbox / tracking
                ['name' => 'ecosystem.inbox.assigned', 'guard_name' => 'web'],
                ['name' => 'ecosystem.inbox.team', 'guard_name' => 'web'],
                ['name' => 'ecosystem.inbox.due', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.search', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.history', 'guard_name' => 'web'],
                ['name' => 'ecosystem.tracking.reports', 'guard_name' => 'web'],

                // Flows design
                ['name' => 'ecosystem.flows.types', 'guard_name' => 'web'],
                ['name' => 'ecosystem.flows.designer', 'guard_name' => 'web'],
                ['name' => 'ecosystem.flows.states', 'guard_name' => 'web'],
                ['name' => 'ecosystem.flows.transitions', 'guard_name' => 'web'],

                // Team management
                ['name' => 'ecosystem.team.assign_roles', 'guard_name' => 'web'],
                ['name' => 'ecosystem.team.list', 'guard_name' => 'web'],
                ['name' => 'ecosystem.team.invite', 'guard_name' => 'web'],
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

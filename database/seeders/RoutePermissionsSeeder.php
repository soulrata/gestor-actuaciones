<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoutePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            'dashboard.general',
            'system.users.manage',
            'system.users.assign_superadmin',
            'system.users.assign_admin_ecosistema',
            'system.users.assign_operational_roles',
            'system.roles.manage',
            'ecosystem.inbox.assigned',
            'ecosystem.inbox.team',
            'ecosystem.inbox.due',
            'ecosystem.tracking.search',
            'ecosystem.tracking.history',
            'ecosystem.tracking.reports',
            'ecosystem.flows.types',
            'ecosystem.flows.designer',
            'ecosystem.flows.states',
            'ecosystem.flows.transitions',
            'ecosystem.team.assign_roles',
            'ecosystem.team.list',
            'ecosystem.team.invite',
        ];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // If SuperAdmin role exists, give it the permissions
        $super = Role::where('name', 'SuperAdmin')->first();
        if ($super) {
            $super->syncPermissions(Permission::all());
        }
    }
}

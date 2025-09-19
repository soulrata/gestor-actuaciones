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
            'Dashboard',
            'Gestor SuperAdmin',
            'Diseñador de Secuencias',
            'Usuarios del Ecosistema',
            'Roles y Permisos del Ecosistema',
            'Gestor de estados',
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

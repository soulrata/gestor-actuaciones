<?php

namespace Database\Seeders;

use App\Models\Ecosistema;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EcosistemaSeeder extends Seeder
{
    public function run(): void
    {
        $dnse = Ecosistema::firstOrCreate(
            ['nombre' => 'DNSEEPPS'],
            ['descripcion' => 'Ecosistema base creado por el kickstart']
        );

        $onep = Ecosistema::firstOrCreate(
            ['nombre' => 'ONEP'],
            ['descripcion' => 'Ecosistema ONEP']
        );

        $dpsp = Ecosistema::firstOrCreate(
            ['nombre' => 'DPSP'],
            ['descripcion' => 'Ecosistema DPSP']
        );

        // Create Admin role for ecosistema admins and give all permissions except 'Gestor SuperAdmin'
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $permissions = Permission::all()->filter(fn ($p) => $p->name !== 'Gestor SuperAdmin');
        $adminRole->syncPermissions($permissions->pluck('id')->toArray());

        // Assign user id=2 to Admin role and to DPSP ecosistema. If id=2 not found, fallback to test user email.
        $user = User::find(2) ?: User::where('email', 'liaomiguel@gmail.com')->first();

        if (! $user) {
            // create a fallback user with that email
            $user = User::firstOrCreate([
                'email' => 'liaomiguel@gmail.com',
            ], [
                'name' => 'Miguel Liao',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        // Assign role and ecosistema
        $user->assignRole($adminRole);
        $user->ecosistema()->associate($dpsp);
        $user->save();
    }
}

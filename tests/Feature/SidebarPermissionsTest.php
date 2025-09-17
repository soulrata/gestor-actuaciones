<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;

it('shows system management group to superadmin', function () {
    $role = Role::firstOrCreate(['name' => 'SuperAdmin']);
    /** @var User $user */
    $user = User::factory()->create();
    $user->assignRole($role);

    // Ensure role/user has at least one of the permissions used in the sidebar group
    $perm = Permission::firstOrCreate(['name' => 'system.roles.manage']);
    $user->givePermissionTo($perm);

    $res = actingAs($user)->get(route('dashboard'));
    $res->assertOk();

    // The sidebar should contain the heading 'Gestión Global del Sistema'
    $res->assertSee('Gestión Global del Sistema');
});

it('does not show system management group to regular user', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $res = actingAs($user)->get(route('dashboard'));
    $res->assertOk();
    $res->assertDontSee('Gestión Global del Sistema');
});

it('shows tracking history item to user with specific permission', function () {
    $perm = Permission::firstOrCreate(['name' => 'ecosystem.tracking.history']);
    /** @var User $user */
    $user = User::factory()->create();
    $user->givePermissionTo($perm);

    $res = actingAs($user)->get(route('dashboard'));
    $res->assertOk();
    $res->assertSee('Historial completo');
});

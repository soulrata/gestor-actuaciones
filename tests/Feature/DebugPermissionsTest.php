<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;

it('allows superadmin to view permissions', function () {
    $role = Role::firstOrCreate(['name' => 'SuperAdmin']);
    /** @var User $user */
    $user = User::factory()->create();
    $user->assignRole($role);

    actingAs($user)->get('/debug/permissions')->assertOk()->assertJsonStructure([['id', 'name', 'guard_name']]);
});

it('forbids regular user from viewing permissions', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)->get('/debug/permissions')->assertForbidden();
});

<?php

use App\Models\{User, Role};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear permisos base
    $this->seed(\Database\Seeders\AdminPermissionsSeeder::class);
    
    // Crear rol Admin del Ecosistema
    $ecosystemAdminRole = Role::firstOrCreate([
        'name' => 'Admin del Ecosistema',
        'guard_name' => 'web'
    ]);
    $ecosystemAdminRole->givePermissionTo(['Usuarios del Ecosistema', 'Roles y Permisos del Ecosistema']);
    
    // Crear usuarios básicos
    $this->ecosystemAdmin = User::factory()->create(['ecosistema_id' => null]);
    $this->ecosystemAdmin->assignRole('Admin del Ecosistema');
    
    $this->normalUser = User::factory()->create(['ecosistema_id' => null]);
});

it('blocks unauthorized users', function () {
    $this->actingAs($this->normalUser)
        ->get(route('ecosystem.roles.index'))
        ->assertForbidden();
});

it('shows roles page for authorized ecosystem admin', function () {
    $this->actingAs($this->ecosystemAdmin)
        ->get(route('ecosystem.roles.index'))
        ->assertOk()
        ->assertSee('Roles y Permisos del Ecosistema');
});
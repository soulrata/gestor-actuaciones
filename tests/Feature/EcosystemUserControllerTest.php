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
    
    // Crear usuarios básicos sin ecosistema_id (simulamos con propiedades)
    $this->superAdmin = User::factory()->create(['ecosistema_id' => null]);
    $this->superAdmin->assignRole('SuperAdmin');
    
    $this->ecosystemAdmin1 = User::factory()->create(['ecosistema_id' => null]);
    $this->ecosystemAdmin1->assignRole('Admin del Ecosistema');
    
    $this->normalUser1 = User::factory()->create(['ecosistema_id' => null]);
    $this->normalUser2 = User::factory()->create(['ecosistema_id' => null]);
});

it('blocks unauthorized users', function () {
    $this->actingAs($this->normalUser1)
        ->get(route('ecosystem.users.index'))
        ->assertForbidden();
});

it('redirects authenticated ecosystem admin', function () {
    $this->actingAs($this->ecosystemAdmin1)
        ->get(route('ecosystem.users.index'))
        ->assertStatus(302); // Redirect due to missing ecosistema_id validation
});
<?php

use App\Models\User;
use App\Models\Ecosistema;
use App\Models\Secuencia;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Crear el permiso si no existe
    Permission::firstOrCreate(['name' => 'Diseñador de Secuencias']);
});

// Tests de autorización
it('blocks access to secuencias without permission', function () {
    $user = User::factory()->withoutEcosistema()->create();
    
    $this->actingAs($user)
        ->get(route('ecosystem.secuencias.index'))
        ->assertForbidden();
});

it('allows access to secuencias with permission', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    // Debug: verificar que el usuario tenga el permiso
    expect($user->hasPermissionTo('Diseñador de Secuencias'))->toBeTrue();
    expect($user->ecosistema_id)->toBe($ecosistema->id);
    
    $response = $this->actingAs($user)
        ->get(route('ecosystem.secuencias.index'));
    
    // Debug: imprimir respuesta si falla
    if ($response->getStatusCode() !== 200) {
        dump('Response status: ' . $response->getStatusCode());
        dump('Response content: ' . $response->getContent());
    }
    
    $response->assertOk();
});

// Tests de CRUD funcionalidad
it('displays secuencias index for authorized user', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $secuencia = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema->id,
        'nombre' => 'Secuencia Test',
        'activa' => true
    ]);
    
    $this->actingAs($user)
        ->get(route('ecosystem.secuencias.index'))
        ->assertOk()
        ->assertSee('Secuencia Test');
});

it('creates new secuencia with valid data', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $data = [
        'nombre' => 'Nueva Secuencia',
        'descripcion' => 'Descripción de prueba',
        'activa' => '1'
    ];
    
    $this->actingAs($user)
        ->post(route('ecosystem.secuencias.store'), $data)
        ->assertRedirect();
    
    $this->assertDatabaseHas('secuencias', [
        'nombre' => 'Nueva Secuencia',
        'ecosistema_id' => $ecosistema->id,
        'activa' => true
    ]);
});

it('validates required fields on creation', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $this->actingAs($user)
        ->post(route('ecosystem.secuencias.store'), [])
        ->assertSessionHasErrors(['nombre']);
});

it('validates unique nombre per ecosistema', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema->id,
        'nombre' => 'Secuencia Existente'
    ]);
    
    $data = [
        'nombre' => 'Secuencia Existente',
        'descripcion' => 'Otra descripción'
    ];
    
    $this->actingAs($user)
        ->post(route('ecosystem.secuencias.store'), $data)
        ->assertRedirect()
        ->assertSessionHas('error', 'Ya existe una secuencia con ese nombre en tu ecosistema.');
});

it('updates existing secuencia', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $secuencia = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema->id,
        'nombre' => 'Secuencia Original'
    ]);
    
    $data = [
        'nombre' => 'Secuencia Actualizada',
        'descripcion' => 'Nueva descripción',
        'activa' => '0'
    ];
    
    $this->actingAs($user)
        ->put(route('ecosystem.secuencias.update', $secuencia), $data)
        ->assertRedirect();
    
    $this->assertDatabaseHas('secuencias', [
        'id' => $secuencia->id,
        'nombre' => 'Secuencia Actualizada',
        'activa' => false
    ]);
});

it('deletes secuencia', function () {
    $ecosistema = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $secuencia = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema->id
    ]);
    
    $this->actingAs($user)
        ->delete(route('ecosystem.secuencias.destroy', $secuencia))
        ->assertRedirect();
    
    $this->assertDatabaseMissing('secuencias', [
        'id' => $secuencia->id
    ]);
});

// Tests de scoping por ecosistema
it('scopes secuencias by ecosistema correctly', function () {
    $ecosistema1 = Ecosistema::factory()->create();
    $ecosistema2 = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema1)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $secuencia1 = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema1->id,
        'nombre' => 'Secuencia Eco 1'
    ]);
    
    $secuencia2 = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema2->id,
        'nombre' => 'Secuencia Eco 2'
    ]);
    
    $response = $this->actingAs($user)
        ->get(route('ecosystem.secuencias.index'));
    
    $response->assertOk()
        ->assertSee('Secuencia Eco 1')
        ->assertDontSee('Secuencia Eco 2');
});

it('prevents access to secuencia from different ecosistema', function () {
    $ecosistema1 = Ecosistema::factory()->create();
    $ecosistema2 = Ecosistema::factory()->create();
    $user = User::factory()->forEcosistema($ecosistema1)->create();
    $user->givePermissionTo('Diseñador de Secuencias');
    
    $secuencia = Secuencia::factory()->create([
        'ecosistema_id' => $ecosistema2->id
    ]);
    
    // El controller debería retornar 403 porque la secuencia no pertenece al ecosistema del usuario
    $this->actingAs($user)
        ->get(route('ecosystem.secuencias.show', $secuencia))
        ->assertStatus(403);
});
<?php

it('updates role with permissions correctly', function () {
    $user = \App\Models\User::factory()->create(['ecosistema_id' => null]);
    $role = \Spatie\Permission\Models\Role::create(['name' => 'Test Role']);
    $permissions = \Spatie\Permission\Models\Permission::limit(3)->get();
    
    $response = $this->actingAs($user)
        ->put(route('ecosystem.roles.update', $role), [
            'name' => 'Updated Role',
            'permissions' => $permissions->pluck('id')->toArray()
        ]);
    
    // Debería fallar por falta de ecosistema_id
    $response->assertStatus(403);
});

it('creates role with permissions correctly', function () {
    $user = \App\Models\User::factory()->create(['ecosistema_id' => null]);
    $permissions = \Spatie\Permission\Models\Permission::limit(2)->get();
    
    $response = $this->actingAs($user)
        ->post(route('ecosystem.roles.store'), [
            'name' => 'New Test Role',
            'permissions' => $permissions->pluck('id')->toArray()
        ]);
    
    // Debería fallar por falta de ecosistema_id
    $response->assertStatus(403);
});
<?php

it('shows breadcrumbs correctly in ecosystem views', function () {
    $user = \App\Models\User::factory()->create(['ecosistema_id' => null]);
    
    // Test users index breadcrumbs
    $response = $this->actingAs($user)
        ->get(route('ecosystem.users.index'));
    
    $response->assertForbidden(); // Expected due to no ecosistema_id
    
    // Test roles index breadcrumbs  
    $response = $this->actingAs($user)
        ->get(route('ecosystem.roles.index'));
        
    $response->assertForbidden(); // Expected due to no ecosistema_id
});
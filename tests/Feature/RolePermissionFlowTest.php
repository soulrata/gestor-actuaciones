<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

it('saves and retrieves role permissions correctly in full flow', function () {
    // Crear rol de prueba
    $role = Role::create(['name' => 'Test Role Flow']);
    
    // Obtener algunos permisos
    $permissions = Permission::where('name', 'not like', '%SuperAdmin%')->limit(3)->get();
    $permissionIds = $permissions->pluck('id')->toArray();
    $permissionNames = $permissions->pluck('name')->toArray();
    
    echo "Testing role: {$role->name}\n";
    echo "Permission IDs to assign: " . implode(', ', $permissionIds) . "\n";
    echo "Permission names: " . implode(', ', $permissionNames) . "\n";
    
    // Simular el guardado como lo hace el controller
    $role->syncPermissions($permissionNames);
    
    // Verificar que se guardaron
    $role->refresh();
    expect($role->permissions->count())->toBe(3);
    expect($role->permissions->pluck('name')->sort()->values()->toArray())
        ->toEqual(collect($permissionNames)->sort()->values()->toArray());
    
    // Simular la carga para edición (como en el controller edit)
    $rolePermissions = $role->permissions->pluck('id')->toArray();
    expect($rolePermissions)->toEqual($permissionIds);
    
    echo "✓ Permissions saved correctly\n";
    echo "✓ Permissions loaded correctly for edit form\n";
    
    // Limpiar
    $role->delete();
});
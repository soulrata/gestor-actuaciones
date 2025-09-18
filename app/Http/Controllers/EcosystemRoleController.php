<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EcosystemRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo roles que no sean SuperAdmin
        $roles = Role::where('name', '!=', 'SuperAdmin')
            ->with('permissions') // Eager loading de permisos
            ->withCount('users')
            ->paginate(10);

        return view('ecosystem.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // Permisos que no incluyan los de SuperAdmin
        $permissions = Permission::where('name', 'not like', '%SuperAdmin%')->get();

        return view('ecosystem.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // DEBUG: Mostrar datos del request
        Log::info('=== ECOSYSTEM ROLE STORE DEBUG ===');
        Log::info('Request Name: ' . $request->input('name'));
        Log::info('Request Permissions: ' . json_encode($request->input('permissions')));
        Log::info('Request All Data: ' . json_encode($request->all()));

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Verificar que no se incluyan permisos de SuperAdmin
        if ($request->permissions) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            Log::info('Permission Names Found: ' . json_encode($permissionNames->toArray()));
            
            $superAdminPermissions = $permissionNames->filter(fn($permission) => str_contains($permission, 'SuperAdmin'));
            
            if ($superAdminPermissions->isNotEmpty()) {
                abort(403, 'No puedes asignar permisos de SuperAdmin.');
            }
        }

        $role = Role::create(['name' => $request->name]);
        Log::info('Role created with ID: ' . $role->id);
        
        if ($request->permissions) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            Log::info('Syncing Permissions: ' . json_encode($permissionNames));
            $role->syncPermissions($permissionNames);
        }

        // DEBUG: Verificar resultado
        $role->refresh();
        Log::info('Role after store - Permission count: ' . $role->permissions->count());
        Log::info('Role permissions: ' . json_encode($role->permissions->pluck('name')->toArray()));
        Log::info('=== END STORE DEBUG ===');

        return redirect()->route('ecosystem.roles.index')
            ->with('success', 'Rol creado exitosamente.');
    }    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // No permitir ver rol SuperAdmin
        if ($role->name === 'SuperAdmin') {
            abort(403, 'No puedes ver el rol SuperAdmin.');
        }

        $role->load('permissions', 'users');

        return view('ecosystem.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // No permitir editar rol SuperAdmin
        if ($role->name === 'SuperAdmin') {
            abort(403, 'No puedes editar el rol SuperAdmin.');
        }

        $permissions = Permission::where('name', 'not like', '%SuperAdmin%')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('ecosystem.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // No permitir editar rol SuperAdmin
        if ($role->name === 'SuperAdmin') {
            abort(403, 'No puedes editar el rol SuperAdmin.');
        }

        // DEBUG: Mostrar datos del request
        Log::info('=== ECOSYSTEM ROLE UPDATE DEBUG ===');
        Log::info('Role ID: ' . $role->id);
        Log::info('Role Name: ' . $role->name);
        Log::info('Request Name: ' . $request->input('name'));
        Log::info('Request Permissions: ' . json_encode($request->input('permissions')));
        Log::info('Request All Data: ' . json_encode($request->all()));
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Verificar que no se incluyan permisos de SuperAdmin
        if ($request->permissions) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            Log::info('Permission Names Found: ' . json_encode($permissionNames->toArray()));
            
            $superAdminPermissions = $permissionNames->filter(fn($permission) => str_contains($permission, 'SuperAdmin'));
            
            if ($superAdminPermissions->isNotEmpty()) {
                abort(403, 'No puedes asignar permisos de SuperAdmin.');
            }
        }

        $role->update(['name' => $request->name]);
        
        // Sincronizar permisos - convertir IDs a nombres
        if ($request->permissions) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            Log::info('Syncing Permissions: ' . json_encode($permissionNames));
            $role->syncPermissions($permissionNames);
        } else {
            Log::info('No permissions to sync - clearing all');
            $role->syncPermissions([]);
        }

        // DEBUG: Verificar resultado
        $role->refresh();
        Log::info('Role after update - Permission count: ' . $role->permissions->count());
        Log::info('Role permissions: ' . json_encode($role->permissions->pluck('name')->toArray()));
        Log::info('=== END DEBUG ===');

        return redirect()->route('ecosystem.roles.index')
            ->with('success', 'Rol actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // No permitir eliminar rol SuperAdmin
        if ($role->name === 'SuperAdmin') {
            abort(403, 'No puedes eliminar el rol SuperAdmin.');
        }

        // Verificar si tiene usuarios asignados
        if ($role->users()->count() > 0) {
            return redirect()->route('ecosystem.roles.index')
                ->with('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
        }

        $role->delete();

        return redirect()->route('ecosystem.roles.index')
            ->with('success', 'Rol eliminado exitosamente.');
    }
}

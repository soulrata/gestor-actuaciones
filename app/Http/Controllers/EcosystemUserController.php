<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class EcosystemUserController extends Controller
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
        // Solo usuarios del mismo ecosistema
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema para gestionar usuarios.');
        }

        $users = User::where('ecosistema_id', $currentUser->ecosistema_id)
            ->with(['roles', 'ecosistema'])
            ->paginate(10);

        return view('ecosystem.users.index', compact('users'));
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

        // Solo roles que no sean SuperAdmin
        $roles = Role::where('name', '!=', 'SuperAdmin')->get();

        return view('ecosystem.users.create', compact('roles'));
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Verificar que no se asigne rol SuperAdmin
        if (in_array('SuperAdmin', $request->roles)) {
            abort(403, 'No puedes asignar el rol SuperAdmin.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ecosistema_id' => $currentUser->ecosistema_id, // Asignar al mismo ecosistema
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('ecosystem.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Verificar que el usuario pertenece al mismo ecosistema
        $currentUser = Auth::user();
        
        if ($user->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes ver usuarios de otros ecosistemas.');
        }

        $user->load(['roles', 'ecosistema']);

        return view('ecosystem.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar que el usuario pertenece al mismo ecosistema
        if ($user->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar usuarios de otros ecosistemas.');
        }

        // No permitir editar SuperAdmin
        if ($user->hasRole('SuperAdmin')) {
            abort(403, 'No puedes editar usuarios SuperAdmin.');
        }

        $roles = Role::where('name', '!=', 'SuperAdmin')->get();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('ecosystem.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar que el usuario pertenece al mismo ecosistema
        if ($user->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar usuarios de otros ecosistemas.');
        }

        // No permitir editar SuperAdmin
        if ($user->hasRole('SuperAdmin')) {
            abort(403, 'No puedes editar usuarios SuperAdmin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Verificar que no se asigne rol SuperAdmin
        if (in_array('SuperAdmin', $request->roles)) {
            abort(403, 'No puedes asignar el rol SuperAdmin.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('ecosystem.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar que el usuario pertenece al mismo ecosistema
        if ($user->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes eliminar usuarios de otros ecosistemas.');
        }

        // No permitir eliminar SuperAdmin
        if ($user->hasRole('SuperAdmin')) {
            abort(403, 'No puedes eliminar usuarios SuperAdmin.');
        }

        // No permitir auto-eliminación
        if ($user->id === $currentUser->id) {
            abort(403, 'No puedes eliminarte a ti mismo.');
        }

        $user->delete();

        return redirect()->route('ecosystem.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}

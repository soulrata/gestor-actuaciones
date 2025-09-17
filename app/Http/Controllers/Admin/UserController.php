<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        // eager load roles to avoid N+1 and allow displaying role names
        $users = User::with('roles')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();

        // hash password
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        // Ensure ecosistema presence for non-SuperAdmin roles
        $roles = $data['roles'] ?? [];
        $isSuperAdminRole = in_array('SuperAdmin', $roles);

        if (! $isSuperAdminRole && empty($data['ecosistema_id'])) {
            return back()->withInput()->withErrors(['ecosistema_id' => 'Ecosistema obligatorio para usuarios que no sean SuperAdmin.']);
        }

        $user = User::create($data);

        // sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();

        // handle password: if empty, don't update it
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        // Ensure ecosistema presence for non-SuperAdmin roles
        $roles = $data['roles'] ?? $user->roles->pluck('name')->toArray();
        $isSuperAdminRole = in_array('SuperAdmin', $roles);

        if (! $isSuperAdminRole && empty($data['ecosistema_id'])) {
            return back()->withInput()->withErrors(['ecosistema_id' => 'Ecosistema obligatorio para usuarios que no sean SuperAdmin.']);
        }

        $user->update($data);

        // sync roles
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado');
    }
}

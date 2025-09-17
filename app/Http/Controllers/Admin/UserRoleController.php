<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.user-roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.user-roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array|exists:roles,name'
        ]);

        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.user-roles.index')->with('success', 'Roles asignados exitosamente');
    }
}
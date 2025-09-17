<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\EcosistemaController;
use Illuminate\Support\Facades\Route;

Route::resource('permissions', PermissionController::class)->except('show');
Route::resource('roles', RoleController::class);

// CRUD de Ecosistemas
Route::resource('ecosistema', EcosistemaController::class)->names('ecosistema');

// Asignación de roles a usuarios
Route::resource('user-roles', UserRoleController::class); // Ruta para asignar roles a usuarios
Route::get('{user}/roles', [UserRoleController::class, 'edit'])->name('user-roles.edit');
Route::put('{user}/roles', [UserRoleController::class, 'update'])->name('user-roles.update');

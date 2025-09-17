<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;

Route::resource('permissions', PermissionController::class)->except('show');
Route::resource('roles', RoleController::class);

// Asignación de roles a usuarios
Route::resource('user-roles', UserRoleController::class); // Ruta para asignar roles a usuarios
Route::get('{user}/roles', [UserRoleController::class, 'edit'])->name('user-roles.edit');
Route::put('{user}/roles', [UserRoleController::class, 'update'])->name('user-roles.update');
<?php

use App\Http\Controllers\EcosystemUserController;
use App\Http\Controllers\EcosystemRoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ecosystem Management Routes
|--------------------------------------------------------------------------
|
| Rutas para que los Admins de ecosistema gestionen sus propios usuarios
| y roles, sin acceso a funciones de SuperAdmin.
|
*/

Route::middleware(['auth'])->prefix('ecosystem')->name('ecosystem.')->group(function () {
    
    // Debug temporal
    Route::get('/debug/roles', function() {
        return view('ecosystem.roles.debug');
    })->name('debug.roles');

    // Gestión de usuarios del ecosistema
    Route::resource('users', EcosystemUserController::class)
        ->middleware('can:Usuarios del Ecosistema');
    
    // Gestión de roles del ecosistema  
    Route::resource('roles', EcosystemRoleController::class)
        ->middleware('can:Roles y Permisos del Ecosistema');
});
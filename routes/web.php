<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard/{tanda_id?}', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Debug route to list permissions (only SuperAdmin)
Route::get('/debug/permissions', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if (! $user || ! $user->hasRole('SuperAdmin')) {
        abort(403);
    }

    return response()->json(\Spatie\Permission\Models\Permission::orderBy('name')->get(['id', 'name', 'guard_name']));
})->middleware(['auth'])->name('debug.permissions');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;

Route::get('/', [MenuController::class, 'index'])->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';


require __DIR__.'/auth.php';

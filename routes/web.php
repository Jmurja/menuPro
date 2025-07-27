<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyRestaurantController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Controllers\UserController;

Route::get('/', [MenuController::class, 'home'])->name('home');
Route::get('/menu/{restaurant}', [MenuController::class, 'publicMenu'])->name('menu.public');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');

    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::middleware(['auth', 'can:admin-only'])->group(function () {
        //Users Region
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        //End Users Region

        //restaurants Region
        Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
        Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
        Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
        Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
        Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
        //End Restaurants Region
    });

    Route::middleware(['auth', 'can:owner-only'])->group(function () {
        // my restaurants region
        Route::get('/meus-restaurantes', [MyRestaurantController::class, 'index'])->name('my_restaurants.index');
        Route::get('/meus-restaurantes/{restaurant}', [MyRestaurantController::class, 'show'])->name('my_restaurants.show');
        Route::post('/owner/restaurants/{restaurant}/employees', [MyRestaurantController::class, 'storeEmployee'])->name('owner.employees.store');
        Route::put('/owner/restaurants/{restaurant}/employees/{user}', [MyRestaurantController::class, 'updateEmployee'])->name('owner.employees.update');
        Route::delete('/owner/restaurants/{restaurant}/employees/{user}', [MyRestaurantController::class, 'destroyEmployee'])->name('owner.employees.destroy');
        // end my restaurants region
    });
});


require __DIR__.'/auth.php';


require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Manage\RestaurantController;
use Illuminate\Support\Facades\Route;

//'middleware' => ['auth', 'role:super admin|admin']

Route::group(['prefix' => 'manage', 'as' => 'manage.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', function () {
        return view('manage.index');
    })->name('index');

    //Route::resource('roles', RoleController::class);
    Route::get('permissions', App\Http\Livewire\Manage\Permissions\Datatable::class)->name('permissions.index');
    Route::resource('restaurants', RestaurantController::class);
    Route::get('profile', App\Http\Livewire\Manage\Profile\Update::class)->name('profile.index');
    Route::get('change-password', App\Http\Livewire\Manage\Profile\ChangePassword::class)->name('change-password');
});
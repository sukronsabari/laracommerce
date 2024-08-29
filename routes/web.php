<?php

use App\Http\Controllers;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [Controllers\Home\HomeController::class,'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [Controllers\Profile\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/image', [Controllers\Profile\ProfileImageController::class, 'update'])->name('profile.image.update');

});

Route::group(['prefix'=> '/admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/dashboard', [Controllers\Dashboard\AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/settings', [Controllers\Settings\AdminSettingsController::class, 'edit'])->name('admin.settings.edit');

    Route::get('/sliders', [Controllers\Sliders\SlidersController::class, 'index'])->name('admin.sliders.index');
    Route::get('/sliders/new', [Controllers\Sliders\SlidersController::class, 'create'])->name('admin.sliders.create');
    Route::post('/sliders', [Controllers\Sliders\SlidersController::class, 'store'])->name('admin.sliders.store');
    Route::get('/sliders/{slider}/edit', [Controllers\Sliders\SlidersController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('/sliders/{slider}', [Controllers\Sliders\SlidersController::class, 'update'])->name('admin.sliders.update');

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

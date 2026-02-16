<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\SchoolClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::resource('majors', MajorController::class)->except(['show']);
        Route::resource('classes', SchoolClassController::class)->except(['show']);
    });

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

        Route::view('/dashboard', 'guru.dashboard')->name('dashboard');
    });

require __DIR__.'/auth.php';

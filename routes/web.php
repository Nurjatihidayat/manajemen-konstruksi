<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Admin & Manajer routes
    Route::middleware(['role:admin,manajer'])->group(function () {
        Route::resource('projects', ProjectController::class)->except(['index', 'show']);
        Route::resource('projects.materials', MaterialController::class)->except(['index', 'show']);
    });

    // Material transactions (accessible by Gudang and others)
    Route::post('/projects/{project}/materials/{material}/transaction', [MaterialController::class, 'transaction'])->name('projects.materials.transaction');

    // Routes accessible by all for viewing
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Gudang routes (specific actions can be added here if they are not just standard CRUD)
    Route::middleware(['role:gudang'])->group(function () {
        // e.g., Route::post('/materials/{material}/stock-in', [MaterialController::class, 'stockIn']);
    });
});

require __DIR__.'/auth.php';

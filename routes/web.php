<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\ProjectProgressController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =====================
    //  Admin only routes
    // =====================
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // =====================
    //  Admin & Manajer routes
    // =====================
    Route::middleware(['role:admin,manajer'])->group(function () {
        Route::resource('projects', ProjectController::class)->except(['index', 'show']);
        Route::resource('projects.materials', MaterialController::class)->except(['index', 'show']);
        // Progress Update (Manager)
        Route::post('/projects/{project}/progress', [ProjectProgressController::class, 'store'])->name('projects.progress.store');
    });

    // =====================
    //  Material Request Routes (authorization inside controller)
    //  accessible by all 3 roles
    // =====================
    Route::get('/material-requests', [MaterialRequestController::class, 'index'])->name('material-requests.index');
    Route::get('/material-requests/create', [MaterialRequestController::class, 'create'])->name('material-requests.create');
    Route::post('/material-requests', [MaterialRequestController::class, 'store'])->name('material-requests.store');
    Route::get('/material-requests/{materialRequest}', [MaterialRequestController::class, 'show'])->name('material-requests.show');
    Route::post('/material-requests/{materialRequest}/approve', [MaterialRequestController::class, 'approve'])->name('material-requests.approve');
    Route::post('/material-requests/{materialRequest}/reject', [MaterialRequestController::class, 'reject'])->name('material-requests.reject');
    Route::post('/material-requests/{materialRequest}/ship', [MaterialRequestController::class, 'ship'])->name('material-requests.ship');
    Route::post('/material-requests/{materialRequest}/receive', [MaterialRequestController::class, 'receive'])->name('material-requests.receive');

    Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics.index');

    // =====================
    //  Gudang & Admin routes
    // =====================
    Route::middleware(['role:admin,gudang'])->group(function () {
        // Master Materials & Suppliers
        Route::resource('master-materials', \App\Http\Controllers\MasterMaterialController::class);
        Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

        // Purchase Orders
        Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
        Route::get('/purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create');
        Route::post('/purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchase-orders.store');
        Route::get('/purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
        Route::post('/purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
        Route::delete('/purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'destroy'])->name('purchase-orders.destroy');

        // Stock Opname
        Route::get('/stock-opnames', [StockOpnameController::class, 'index'])->name('stock-opnames.index');
        Route::get('/stock-opnames/create', [StockOpnameController::class, 'create'])->name('stock-opnames.create');
        Route::post('/stock-opnames', [StockOpnameController::class, 'store'])->name('stock-opnames.store');
        Route::get('/stock-opnames/{stockOpname}', [StockOpnameController::class, 'show'])->name('stock-opnames.show');
        Route::post('/stock-opnames/{stockOpname}/complete', [StockOpnameController::class, 'complete'])->name('stock-opnames.complete');
        Route::delete('/stock-opnames/{stockOpname}', [StockOpnameController::class, 'destroy'])->name('stock-opnames.destroy');
    });

    // =====================
    //  Shared viewing routes (all roles)
    // =====================
    Route::post('/projects/{project}/materials/{material}/transaction', [MaterialController::class, 'transaction'])->name('projects.materials.transaction');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});

require __DIR__.'/auth.php';

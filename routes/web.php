<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class);

Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('inventory', [InventoryController::class, 'store'])->name('inventory.store');

Route::resource('orders', OrderController::class)->except(['edit', 'update', 'destroy']);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

Route::get('marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('marketplace/import', [MarketplaceController::class, 'importForm'])->name('marketplace.import');
Route::post('marketplace/import', [MarketplaceController::class, 'import'])->name('marketplace.import.process');

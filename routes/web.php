<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SaleController as AdminSaleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/tienda', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/tienda/{slug}', [ShopController::class, 'show'])->name('shop.show');

    Route::prefix('carrito')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/agregar/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/actualizar/{product}', [CartController::class, 'update'])->name('update');
        Route::delete('/eliminar/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/vaciar', [CartController::class, 'clear'])->name('clear');
    });

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/mis-pedidos/{code}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::post('/products/{product}/status/{status}', [AdminProductController::class, 'markStatus'])
        ->name('products.status');

    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);

    Route::get('sales', [AdminSaleController::class, 'index'])->name('sales.index');
    Route::get('sales/{sale}', [AdminSaleController::class, 'show'])->name('sales.show');

    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
});
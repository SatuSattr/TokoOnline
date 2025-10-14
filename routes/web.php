<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public routes
Route::get('/products', [HomeController::class, 'products'])->name('products.index');
Route::get('/products/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [HomeController::class, 'product'])->name('products.show');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
    

    
    // Cart functionality
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });
    
    // Checkout & orders
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    
    Route::get('carts', [AdminCartController::class, 'index'])->name('carts.index');
    Route::get('carts/user/{user}', [AdminCartController::class, 'showByUser'])->name('carts.show');
    Route::delete('carts/{id}', [AdminCartController::class, 'destroy'])->name('carts.destroy');
    

});

// Seller routes
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', SellerProductController::class)->except(['show']);
    Route::get('orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}', [SellerOrderController::class, 'update'])->name('orders.update');
});

require __DIR__.'/auth.php';

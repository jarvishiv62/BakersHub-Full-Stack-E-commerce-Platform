<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AboutController;

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'environment' => env('APP_ENV', 'unknown')
    ]);
});

// =============================
// Authentication Routes
// =============================
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [PageController::class, 'register'])->name('register');

// =============================
// Account Management Routes
// =============================
Route::middleware('auth')->group(function () {
    // Account Dashboard
    Route::get('/account', [AccountController::class, 'dashboard'])->name('account');

    // Profile Update
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');

    // Password Update
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    // Order History
    Route::get('/account/orders', [AccountController::class, 'dashboard'])->name('account.orders');
    Route::get('/account/orders/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');

    // Logout
    Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
});
Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('password.request');
Route::get('/reset-password/{token}', [PageController::class, 'resetPassword'])->name('password.reset');

// =============================
// Admin Routes (separate file)
// =============================
require __DIR__ . '/admin.php';

// =============================
// Frontend Routes
// =============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

// =============================
// Product Routes
// =============================
// Show all products
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Show products by category (SEO-friendly slugs)
Route::get('/products/category/{category}', [ProductController::class, 'index'])
    ->name('products.category')
    ->where('category', '[a-z0-9-]+');

// Show single product details (numeric ID only)
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show')
    ->where('product', '[0-9]+');

// =============================
// Admin Dashboard
// =============================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Products Management
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
        ->except(['show']);

    // Product Status Toggle (AJAX)
    Route::post('products/{product}/status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])
        ->name('products.status');

    // Occasions Management
    Route::resource('occasions', \App\Http\Controllers\Admin\OccasionController::class)
        ->except(['show']);

    // Testimonials Management
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)
        ->except(['show']);

    // Testimonial Status Toggle (AJAX)
    Route::post('testimonials/{testimonial}/status', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateStatus'])
        ->name('testimonials.status');
});

// =============================
// Cart + Checkout Routes
// =============================
Route::middleware('web')->group(function () {
    // Cart Routes
    Route::prefix('cart')->group(function () {
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');
});

// =============================
// Admin Order Routes (auth+admin)
// =============================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('admin.orders.show')
        ->where('order', '[0-9]+');

    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('admin.orders.update-status')
        ->where('order', '[0-9]+');

    // Example: Route for generating invoice
    // Route::post('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])
    //     ->name('admin.orders.invoice');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;

// Authentication Routes
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('password.request');
Route::get('/reset-password/{token}', [PageController::class, 'resetPassword'])->name('password.reset');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/account', [PageController::class, 'account'])->name('account');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Admin Dashboard
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Products Management
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

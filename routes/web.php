<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;

// Main routes
// Replace the existing login route with:
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::get('/cart', [PageController::class,'cart'])->name('cart');
// Route::get('/account', [PageController::class,'account'])->name('account');
Route::get('/checkout', [PageController::class,'checkout'])->name('checkout');
Route::get('/register', [PageController::class,'register'])->name('register');
Route::get('/forgot-password', [PageController::class,'forgot-password'])->name('forgot-password');
Route::get('/reset-password', [PageController::class,'reset-password'])->name('reset-password');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
// // Products Page
// Route::get('/products', function () {
//     return view('products');
// })->name('products');

// Route::get('/product/{slug}', function ($slug) { 
//     return view('product', compact('slug')); 
// })->name('product.show');

// About Page
// Route::get('/about', function () {
//     return view('about');
// })->name('about');  

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');  

//catering page
Route::get('/catering', function () {
    return view('catering');
})->name('catering');  

// Cart Page
// Route::get('/cart', function () {
//     return view('cart');
// })->name('cart');

// Account Page
Route::get('/account', function () {
    return view('account');
})->name('account'); 

// Checkout Page (commented out)
// Route::get('/checkout', function () { 
//     return view('checkout'); 
// })->name('checkout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Occasions Management
    Route::resource('occasions', 'App\Http\Controllers\Admin\OccasionController')
        ->except(['show']);
    // You can add more admin routes here in the future
});

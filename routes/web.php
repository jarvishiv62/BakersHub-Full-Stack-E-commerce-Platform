<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PageController;

// Main routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::get('/cart', [PageController::class,'cart'])->name('cart');
// Route::get('/account', [PageController::class,'account'])->name('account');
Route::get('/checkout', [PageController::class,'checkout'])->name('checkout');
Route::get('/login', [PageController::class,'login'])->name('login');
Route::get('/register', [PageController::class,'register'])->name('register');
Route::get('/forgot-password', [PageController::class,'forgot-password'])->name('forgot-password');
Route::get('/reset-password', [PageController::class,'reset-password'])->name('reset-password');

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


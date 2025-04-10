<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('welcome');
    }
    $products = \App\Models\Product::with('category')->latest()->paginate(9);
    return view('welcome', compact('products'));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class)->names('admin.products');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    $products = \App\Models\Product::with('category')->latest()->paginate(9);
    Route::get('/user/dashboard', [UserController::class, 'index', compact('products')])->name('user.dashboard');
});
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/produk', [ProductController::class, 'daftarProduk'])->name('produk.daftar');
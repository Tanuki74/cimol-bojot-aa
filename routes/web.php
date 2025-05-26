<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    $products = \App\Models\Product::latest()->with('categories')->paginate(9);
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
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/orders/{order}/complete', [AdminController::class, 'completeOrder'])->name('admin.orders.complete');
    Route::post('/admin/orders/{order}/shipped', [AdminController::class, 'shipOrder'])->name('admin.orders.shipped');
    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/products/{product}', [UserController::class, 'show'])->name('user.products.show');
    Route::prefix('cart')->group(function () {
        Route::post('/add', [UserController::class, 'addToCart'])->name('cart.add');
        Route::get('/', [UserController::class, 'cart'])->name('cart.view');
        Route::post('/update', [UserController::class, 'updateCart'])->name('cart.update');
        Route::delete('/remove/{key}', [UserController::class, 'removeFromCart'])->name('cart.remove');
    });
    Route::post('/checkout/submit', [UserController::class, 'submitCheckout'])->name('checkout.submit');
    Route::get('/order/summary', [UserController::class, 'orderSummary'])->name('order.summary');
    Route::post('/order/place', [UserController::class, 'placeOrder'])->name('order.place');
    Route::post('/order/cancel', [UserController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/order/success', [UserController::class, 'orderSuccess'])->name('order.success');
    Route::get('/my-orders', [UserController::class, 'myOrders'])->name('user.my-orders');
    Route::get('/reviews/create/{order}', [UserController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews/{order}', [UserController::class, 'storeReview'])->name('reviews.store');
    Route::get('/reviews/show/{order}', [UserController::class, 'showReview'])->name('reviews.show');
});
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
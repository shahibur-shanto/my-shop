<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.dashboard');

Route::get('/', function () {
    return Inertia::render('Home'); // Just render the Inertia page
})->name('home');

//Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Admin/Dashboard');
//    })->name('admin.dashboard');
//});
Route::get('dashboard', function() {
    return Inertia::render('Dashboard')->name('dashboard');
});

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
//Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
//Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ... existing routes ...

    // Product management
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});


Route::middleware('auth:sanctum')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

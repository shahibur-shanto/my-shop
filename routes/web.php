<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Social\SocialAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.dashboard');

Route::get('/', function () {
    return Inertia::render('Home'); // Just render the Inertia page
})->name('home');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');


    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands/create', [BrandController::class, 'store'])->name('brands.store');

    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [CategoriesController::class, 'store'])->name('categories.store');
});



//Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
//    // Product management
//    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
//    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
//    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
//    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
//    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
//    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
//});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

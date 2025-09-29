<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\URL;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/', function(Request $request){

    return User::all();
});

Route::get('/category', function () {
    $categories = Category::all()->map(function($category) {
        // Prepend 'storage/' if it's missing
        $category->image = URL::to('storage/' . ltrim($category->image, '/'));
        return $category;
    });
    return $categories;
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

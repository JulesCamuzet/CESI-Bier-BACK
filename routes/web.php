<?php

use App\Http\Controllers\PictureController;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FeedbackController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [LoginController::class, 'register']);


Route::apiResource('categories', CategoryController::class);
Route::apiResource('feedbacks', FeedbackController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('orderproducts', OrderProductController::class);
Route::apiResource('pictures', PictureController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('users', controller: UserController::class);
Route::middleware('auth:sanctum')->get('/users/me', [UserController::class, 'me']);




Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts'])
    ->name('categories.products');

Route::get('/feedbacks/{product_id}/feedbacks', [FeedbackController::class, 'getFeedbacks'])
    ->name('feedbacks.products');

Route::get('/suppliers/{supplier}/biers', [SupplierController::class, 'getBiers'])
    ->name('suppliers.biers');

Route::get('/users/{user}/orders', [UserController::class, 'getOrders'])
    ->name('users.orders');


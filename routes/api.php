<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExportDbController;

// Auth
Route::post('/login', [LoginController::class, 'authenticate']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->get('/users/me', [UserController::class, 'me']);



// DB
Route::get('/export-db', [ExportDbController::class, 'export']);
Route::get('/backup', [ExportDbController::class, 'downloadLatestBackup']);


// USERS
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('/users/{user}/orders', [UserController::class, 'getOrders']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);

// FEEDBACKS
Route::get('/feedbacks', [FeedbackController::class, 'index']);
Route::post('/feedbacks', [FeedbackController::class, 'store']);
Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
Route::put('/feedbacks/{id}', [FeedbackController::class, 'update']);
Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy']);
Route::get('/feedbacks/{product_id}/feedbacks', [FeedbackController::class, 'getFeedbacks']);

// ORDERS
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

// ORDER PRODUCTS
Route::get('/orderproducts', [OrderProductController::class, 'index']);
Route::post('/orderproducts', [OrderProductController::class, 'store']);
Route::get('/orderproducts/{id}', [OrderProductController::class, 'show']);
Route::put('/orderproducts/{id}', [OrderProductController::class, 'update']);
Route::delete('/orderproducts/{id}', [OrderProductController::class, 'destroy']);

// PICTURES
Route::get('/pictures', [PictureController::class, 'index']);
Route::post('/pictures', [PictureController::class, 'store']);
Route::get('/pictures/{picture}', [PictureController::class, 'show']);
Route::put('/pictures/{picture}', [PictureController::class, 'update']);
Route::delete('/pictures/{picture}', [PictureController::class, 'destroy']);

// SUPPLIERS
Route::get('/suppliers', [SupplierController::class, 'index']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);
Route::get('/suppliers/{supplier}/biers', [SupplierController::class, 'getBiers']);

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
use App\Http\Controllers\StripeController;

// AUTH
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/users/me', [UserController::class, 'me']);

// STRIPE
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);

// FEEDBACKS
// proteger par le role admin (POST / PUT / DELETE) grace au middleware
    // USERS
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    // PRODUCTS
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // CATEGORIES
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // FEEDBACKS
    Route::put('/feedbacks/{id}', [FeedbackController::class, 'update']);

    // ORDERS
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

    // ORDER PRODUCTS
    Route::post('/orderproducts', [OrderProductController::class, 'store']);
    Route::put('/orderproducts/{id}', [OrderProductController::class, 'update']);
    Route::delete('/orderproducts/{id}', [OrderProductController::class, 'destroy']);

    // PICTURES
    Route::post('/pictures', [PictureController::class, 'store']);
    Route::put('/pictures/{picture}', [PictureController::class, 'update']);
    Route::delete('/pictures/{picture}', [PictureController::class, 'destroy']);

    // SUPPLIERS
    Route::post('/suppliers', [SupplierController::class, 'store']);
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);

Route::post('/import-db', [ExportDbController::class, 'import']);
Route::get('/export-db', [ExportDbController::class, 'export']);

// AUTH USER ROUTES
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/place-order', [OrderController::class, 'place_order']);
});

Route::post('/feedbacks', [FeedbackController::class, 'store']);
Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy']);



// USERS
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/orders', [UserController::class, 'getOrders']);

// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);

// FEEDBACKS
Route::get('/feedbacks', [FeedbackController::class, 'index']);
Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
Route::get('/products/{product_id}/feedbacks', [FeedbackController::class, 'getFeedbacks']);

// ORDER PRODUCTS
Route::get('/orderproducts', [OrderProductController::class, 'index']);
Route::get('/orderproducts/{id}', [OrderProductController::class, 'show']);

// PICTURES
Route::get('/pictures', [PictureController::class, 'index']);
Route::get('/pictures/{picture}', [PictureController::class, 'show']);

// SUPPLIERS
Route::get('/suppliers', [SupplierController::class, 'index']);
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
Route::get('/suppliers/{supplier}/biers', [SupplierController::class, 'getBiers']);

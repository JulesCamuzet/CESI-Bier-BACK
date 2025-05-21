<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;


Route::get('/', function () {
    return 'Hello World';
});

Route::get('/checkout/{orderId}', [StripeController::class, 'createCheckoutSession']);

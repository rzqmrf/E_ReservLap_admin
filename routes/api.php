<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/payments/store', [PaymentController::class, 'store']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
Route::get('/payments', [PaymentController::class, 'index']);

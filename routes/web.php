<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FieldController;

Route::prefix('api')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('fields', FieldController::class);
});

// Route untuk halaman home
Route::get('/', function () {
    return view('home');
});

// Route untuk halaman about
Route::get('/about', function () {
    return view('about');
});

// Route untuk halaman contact
Route::get('/contact', function () {
    return view('contact');
});

// Route untuk halaman features
Route::get('/features', function () {
    return view('features');
});

Route::get('/users-page', function () {
    return view('users');
});

Route::get('/fields', function () {
    return view('fields');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman about
Route::get('/about', function () {
    return view('about');
});

// Route untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

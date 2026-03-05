<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutControllers;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('about', AboutControllers::class);

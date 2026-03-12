<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman welcome
Route::get('/', function () {
    return view('welcome');
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

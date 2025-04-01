<?php

use App\Http\Controllers\ImpresoraController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/home', function () {
    return view('home');
});

Route::resource('impresoras', ImpresoraController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

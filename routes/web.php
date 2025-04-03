<?php

use App\Http\Controllers\ImpresoraController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('/impresoras/buscar', [ImpresoraController::class, 'buscar'])->name('impresoras.buscar');

Route::resource('impresoras', ImpresoraController::class);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [ImpresoraController::class, 'test']);
Auth::routes();

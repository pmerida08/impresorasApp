<?php

use App\Http\Controllers\ImpresoraController;
use App\Http\Controllers\ImpresoraHistoricoController;
use App\Http\Controllers\EstadisticasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::get('/impresoras/buscar', [ImpresoraController::class, 'buscar'])->name('impresoras.buscar');


Route::resource('impresoras', ImpresoraController::class);

Route::get('/test', [ImpresoraController::class, 'test']);
Route::get('/impresoras/{id}/historico', [ImpresoraHistoricoController::class, 'mostrar'])->name('impresoras.historico');
Route::get('/impresoras/{id}/historico', [ImpresoraHistoricoController::class, 'mostrar'])->name('impresoras.historico');
Route::get('/impresoras/{id}/paginas-rango', [ImpresoraHistoricoController::class, 'mostrarPaginasEnRango'])->name('impresoras.paginas.rango');
Route::get('/estadisticas/totales-por-mes', [EstadisticasController::class, 'totalesPorMes'])->name('estadisticas.totales-por-mes');

Auth::routes();

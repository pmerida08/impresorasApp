<?php

use App\Http\Controllers\ImpresoraController;
use App\Http\Controllers\ImpresoraHistoricoController;
use App\Http\Controllers\EstadisticasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

// Custom impresora routes must be before the resource route
Route::get('/impresoras/importar', [ImpresoraController::class, 'importarForm'])
    ->name('impresoras.importar.form');
Route::post('/impresoras/importar', [ImpresoraController::class, 'importar'])
    ->name('impresoras.importar');
Route::get('/impresoras/buscar', [ImpresoraController::class, 'buscar'])
    ->name('impresoras.buscar');
Route::get('/impresoras/{id}/historico', [ImpresoraHistoricoController::class, 'mostrar'])
    ->name('impresoras.historico');
Route::get('/impresoras/{id}/paginas-rango', [ImpresoraHistoricoController::class, 'mostrarPaginasEnRango'])
    ->name('impresoras.paginas.rango');
Route::get('/impresoras/pdf', [ImpresoraController::class, 'exportarPDF'])->name('impresoras.pdfAll');
Route::get('/check-toner-levels', [ImpresoraController::class, 'checkTonerLevels']);

// Resource route should be after all custom routes
Route::get("/impresoras/pdf/filter", [ImpresoraController::class, "showFilterForm"])->name("impresoras.pdf.filter");
Route::get("/impresoras/pdf/filtered", [ImpresoraController::class, "generateFilteredPDF"])->name("impresoras.pdf.filtered");

Route::resource('impresoras', ImpresoraController::class);

// Test and statistics routes
Route::get('/test', [ImpresoraController::class, 'test']);
Route::get('/estadisticas/totales-por-mes', [EstadisticasController::class, 'totalesPorMes'])
    ->name('estadisticas.totales-por-mes');

Auth::routes();

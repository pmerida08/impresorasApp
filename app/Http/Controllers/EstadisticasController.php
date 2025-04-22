<?php

namespace App\Http\Controllers;

use App\Models\ImpresoraHistorico;

class EstadisticasController extends Controller
{
    public function totalesPorMes()
    {
        $totales = ImpresoraHistorico::selectRaw('
        YEAR(fecha) as anio,
        MONTH(fecha) as mes,
        impresora_id,
        MIN(created_at) as primera_lectura,
        MAX(created_at) as ultima_lectura,
        MIN(paginas) as paginas_inicio,
        MAX(paginas) as paginas_fin
    ')
            ->where('paginas', '>', 0) // Excluir lecturas con 0 páginas
            ->groupBy('impresora_id', 'anio', 'mes')
            ->orderByRaw('anio DESC, mes DESC')
            ->get()
            ->groupBy(['anio', 'mes'])
            ->map(function ($meses) {
                return $meses->map(function ($impresoras) {
                    return [
                        'total_paginas' => $impresoras->sum(function ($registro) {
                            return $registro->paginas_fin - $registro->paginas_inicio;
                        }),
                        'total_impresoras' => $impresoras->count()
                    ];
                });
            });

        return view('estadisticas.totales-por-mes', compact('totales'));
    }
}
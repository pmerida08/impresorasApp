<?php

namespace App\Http\Controllers;

use App\Models\ImpresoraHistorico;
use App\Models\Impresora;
use Illuminate\Http\Request;

class ImpresoraHistoricoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mostrar($id)
    {
        $impresora = Impresora::findOrFail($id);
        $anioActual = now()->year;

        $datos = ImpresoraHistorico::where('impresora_id', $id)
            ->whereYear('fecha', $anioActual)
            ->selectRaw('MONTH(fecha) as mes, paginas, paginas_bw, paginas_color')
            ->orderBy('fecha')
            ->get()
            ->groupBy('mes')
            ->map(function ($grupo) {
                $minTotal = $grupo->min('paginas');
                $maxTotal = $grupo->max('paginas');
                $minBW = $grupo->min('paginas_bw');
                $maxBW = $grupo->max('paginas_bw');
                $minColor = $grupo->min('paginas_color');
                $maxColor = $grupo->max('paginas_color');
                
                return [
                    'total' => $maxTotal - $minTotal,
                    'bw' => $maxBW - $minBW,
                    'color' => $maxColor - $minColor
                ];
            });

        $meses = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic',
        ];

        $labels = [];
        $valoresTotal = [];
        $valoresBW = [];
        $valoresColor = [];

        foreach ($meses as $numMes => $nombreMes) {
            $labels[] = "$nombreMes/$anioActual";
            $valoresTotal[] = $datos->get($numMes, ['total' => 0])['total'];
            $valoresBW[] = $datos->get($numMes, ['bw' => 0])['bw'];
            $valoresColor[] = $datos->get($numMes, ['color' => 0])['color'];
        }

        return view('impresora.historico', compact('impresora', 'labels', 'valoresTotal', 'valoresBW', 'valoresColor'));
    }

    public function mostrarPaginasEnRango(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $impresora = Impresora::findOrFail($id);

        $datos = ImpresoraHistorico::where('impresora_id', $id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->selectRaw('
                MIN(paginas) as min_paginas, 
                MAX(paginas) as max_paginas,
                MIN(paginas_bw) as min_paginas_bw, 
                MAX(paginas_bw) as max_paginas_bw,
                MIN(paginas_color) as min_paginas_color, 
                MAX(paginas_color) as max_paginas_color
            ')
            ->first();

        $paginas = 0;
        $paginasBW = 0;
        $paginasColor = 0;
        
        if (!is_null($datos->min_paginas) && !is_null($datos->max_paginas)) {
            $paginas = $datos->max_paginas - $datos->min_paginas;
        }
        
        if (!is_null($datos->min_paginas_bw) && !is_null($datos->max_paginas_bw)) {
            $paginasBW = $datos->max_paginas_bw - $datos->min_paginas_bw;
        }
        
        if (!is_null($datos->min_paginas_color) && !is_null($datos->max_paginas_color)) {
            $paginasColor = $datos->max_paginas_color - $datos->min_paginas_color;
        }

        $mensaje = "Páginas impresas entre <strong>$fechaInicio</strong> y <strong>$fechaFin</strong>: " .
                  "<span class='text-success font-weight-bold'><strong>$paginas</strong> páginas totales</span>, " .
                  "<span class='text-secondary font-weight-bold'><strong>$paginasBW</strong> páginas B/N</span>, " .
                  "<span class='text-primary font-weight-bold'><strong>$paginasColor</strong> páginas color</span>";

        return redirect()
            ->route('impresoras.historico', $id)
            ->with('resultado', $mensaje);
    }
}
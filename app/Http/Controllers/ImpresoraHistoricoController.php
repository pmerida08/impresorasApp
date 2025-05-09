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
            ->selectRaw('MONTH(fecha) as mes, paginas')
            ->orderBy('fecha')
            ->get()
            ->groupBy('mes')
            ->map(function ($grupo) {
                $min = $grupo->min('paginas');
                $max = $grupo->max('paginas');
                return $max - $min;
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
        $valores = [];

        foreach ($meses as $numMes => $nombreMes) {
            $labels[] = "$nombreMes/$anioActual";
            $valores[] = $datos->get($numMes, 0);
        }

        return view('impresora.historico', compact('impresora', 'labels', 'valores'));
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
            ->selectRaw('MIN(paginas) as min_paginas, MAX(paginas) as max_paginas')
            ->first();

        $paginas = 0;
        if (!is_null($datos->min_paginas) && !is_null($datos->max_paginas)) {
            $paginas = $datos->max_paginas - $datos->min_paginas;
        }

        $mensaje = "Páginas impresas entre <strong>$fechaInicio</strong> y <strong>$fechaFin</strong>: <span class='text-success font-weight-bold'><strong>$paginas</strong> páginas</span>";


        return redirect()
            ->route('impresoras.historico', $id)
            ->with('resultado', $mensaje);
    }
}

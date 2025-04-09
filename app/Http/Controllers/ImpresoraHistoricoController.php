<?php

namespace App\Http\Controllers;

use App\Models\ImpresoraHistorico;
use App\Models\Impresora;
use Illuminate\Http\Request;

class ImpresoraHistoricoController extends Controller
{
    public function mostrar($id)
    {
        $impresora = Impresora::findOrFail($id);

        $anioActual = now()->year;

        $datos = ImpresoraHistorico::where('impresora_id', $id)
            ->whereYear('fecha', $anioActual)
            ->selectRaw('MONTH(fecha) as mes, paginas') // sin agrupación
            ->orderBy('fecha')
            ->get()
            ->groupBy('mes')
            ->map(function ($grupo) {
                // max - min de las páginas de ese mes
                $min = $grupo->min('paginas');
                $max = $grupo->max('paginas');
                return $max - $min;
            });


        // Crear array con los 12 meses del año
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
            $valores[] = $datos->get($numMes, 0); // si no existe el mes, pone 0
        }

        return view('impresora.historico', compact('impresora', 'labels', 'valores'));
    }



}
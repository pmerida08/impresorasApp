<?php

namespace App\Http\Controllers;

use App\Models\ImpresoraHistorico;
use Illuminate\Http\Request;
use App\Models\Impresora;

class ImpresoraHistoricoController extends Controller
{
    public function mostrar($id)
    {
        $impresora = ImpresoraHistorico::findOrFail($id);
        $datos = $impresora->paginasPorMes();

        // Transformar a formato útil para Chart.js
        $labels = [];
        $valores = [];

        foreach ($datos as $registro) {
            $labels[] = $registro->mes . '/' . $registro->anio;
            $valores[] = $registro->paginas_mes;
        }

        return view('impresoras.historico', compact('impresora', 'labels', 'valores'));
    }
}

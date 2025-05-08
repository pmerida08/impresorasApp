<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Impresora;
use App\Models\ImpresoraHistorico;
use Illuminate\Support\Facades\Log;

class ActualizarPaginasImpresoras extends Command
{
    protected $signature = 'impresoras:actualizar_paginas';

    protected $description = 'Actualizar las páginas de las impresoras una vez al día';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('🖨️ Comando impresoras:actualizar_paginas iniciado');

        $impresoras = Impresora::all();

        foreach ($impresoras as $impresora) {
            $paginasActuales = intval($impresora->paginas_total);
            $hoy = now('Europe/Madrid')->toDateString();

            if ($paginasActuales == 0) {
                // Buscar la última lectura válida con páginas ≠ 0
                $ultimaLecturaValida = ImpresoraHistorico::where('impresora_id', $impresora->id)
                    ->where('paginas', '!=', 0)
                    ->orderByDesc('fecha')
                    ->first();

                if ($ultimaLecturaValida) {
                    $paginasActuales = $ultimaLecturaValida->paginas; // Usar valor anterior
                } else {
                    Log::warning("⚠️ No hay lectura válida anterior para la impresora {$impresora->id} ({$impresora->descripcion}). Se omite.");
                    continue; // Si no hay valor anterior válido, salta esta impresora
                }
            }

            // Guardar o actualizar lectura de hoy
            $historico = ImpresoraHistorico::updateOrCreate(
                [
                    'impresora_id' => $impresora->id,
                    'fecha' => $hoy,
                ],
                [
                    'paginas' => $paginasActuales
                ]
            );

            Log::info("🖨️ Impresora {$impresora->id} asignada a {$impresora->usuario} de {$impresora->ubicacion} ({$impresora->descripcion}) registrada con {$paginasActuales} páginas en fecha {$hoy}.");
        }

        Log::info('✅ Comando impresoras:actualizar_paginas finalizado');
    }


}
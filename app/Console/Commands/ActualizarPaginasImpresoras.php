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
            $paginasActuales = intval($impresora->getPaginasTotalAttribute());

            $historico = ImpresoraHistorico::where('impresora_id', $impresora->id)
                ->whereDate('fecha', now('Europe/Madrid')->toDateString())
                ->first();

            if ($historico) {
                $historico->paginas = $paginasActuales;
                $historico->save();
            } else {
                ImpresoraHistorico::create([
                    'impresora_id' => $impresora->id,
                    'fecha' => now('Europe/Madrid')->toDateString(),
                    'paginas' => $paginasActuales
                ]);
            }

            Log::info("🖨️ Impresora {$impresora->id} ({$impresora->observaciones}) actualizada con {$paginasActuales} páginas.");
        }

        Log::info('✅ Comando impresoras:actualizar_paginas finalizado');
    }
}
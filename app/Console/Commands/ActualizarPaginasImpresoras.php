<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Impresora;
use App\Models\ImpresoraHistorico;

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
        // Obtener todas las impresoras
        $impresoras = Impresora::all();

        foreach ($impresoras as $impresora) {
            // Aquí puedes utilizar SNMP o lo que sea que uses para obtener el número de páginas
            $paginasActuales = $impresora->getPaginasTotalAttribute(); // O la función que tengas para obtener las páginas

            // Verificar si ya existe un histórico para ese día
            $historico = ImpresoraHistorico::where('impresora_id', $impresora->id)
                ->whereDate('fecha', now()->toDateString()) // Filtrar solo por la fecha de hoy
                ->first();

            if ($historico) {
                // Si ya existe, solo actualizar
                $historico->paginas = $paginasActuales;
                $historico->save();
            } else {
                // Si no existe, crear un nuevo histórico
                ImpresoraHistorico::create([
                    'impresora_id' => $impresora->id,
                    'fecha' => now()->toDateString(),
                    'paginas' => $paginasActuales
                ]);
            }

            $this->info("Impresora {$impresora->observaciones} actualizada.");
        }

        $this->info('Todas las impresoras han sido actualizadas.');
    }
}

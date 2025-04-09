<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Impresora;
use App\Models\ImpresoraHistorico;
use Carbon\Carbon;

class RegistrarPaginasImpresas extends Command
{
    protected $signature = 'impresoras:registrar-historico';
    protected $description = 'Registra el total de páginas impresas de cada impresora en la base de datos';

    public function handle()
    {
        $impresoras = Impresora::all();
        $hoy = Carbon::today();

        foreach ($impresoras as $impresora) {
            try {
                $paginas = $impresora->paginas_total;

                if ($paginas === null) {
                    $this->warn("No se pudo obtener páginas de la impresora {$impresora->ip}");
                    continue;
                }

                ImpresoraHistorico::create([
                    'impresora_id' => $impresora->id,
                    'fecha' => $hoy,
                    'paginas' => intval($paginas),
                ]);

                $this->info("Registrado: {$impresora->ip} => $paginas páginas");

            } catch (\Exception $e) {
                $this->error("Error con impresora {$impresora->ip}: " . $e->getMessage());
            }
        }

        return 0;
    }
}

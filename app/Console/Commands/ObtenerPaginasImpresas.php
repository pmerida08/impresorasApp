<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Impresion;
use Carbon\Carbon;

class ObtenerPaginasImpresas extends Command
{
    protected $signature = 'impresora:obtener-contador';
    protected $description = 'Obtiene el total de páginas impresas desde la impresora y lo guarda en la base de datos';

    public function handle($ip, $oid)
    {
        $community = "public";

        $result = snmpget($ip, $community, $oid);

        if ($result === false) {
            $this->error("No se pudo obtener el valor SNMP.");
            return 1;
        }

        $paginas = (int) filter_var($result, FILTER_SANITIZE_NUMBER_INT);

        Impresion::create([
            'fecha' => Carbon::now()->toDateString(),
            'paginas' => $paginas
        ]);

        $this->info("Guardado contador: $paginas páginas.");
        return 0;
    }
}

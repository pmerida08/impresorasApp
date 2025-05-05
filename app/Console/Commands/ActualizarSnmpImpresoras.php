<?php

namespace App\Console\Commands;

use App\Models\Impresora;
use App\Models\ImpresoraDatosSnmp;
use Illuminate\Console\Command;

class ActualizarSnmpImpresoras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'impresoras:actualizar-snmp-impresoras';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los datos SNMP de cada impresora';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $impresoras = Impresora::all();

        foreach ($impresoras as $impresora) {
            // TODO: Simulación de obtención SNMP, hay un JSON para los métodos
            $datosSnmp = [
                'mac' => snmpget($impresora->ip, '1.3.6.1.x.x.x'),
                'paginas_total' => snmpget($impresora->ip, '1.3.6.1.x.x.y'),
                'paginas_bw' => snmpget($impresora->ip, '1.3.6.1.x.x.z'),
                'paginas_color' => snmpget($impresora->ip, '1.3.6.1.x.x.k'),
                'num_serie' => snmpget($impresora->ip, '1.3.6.1.x.x.m'),
            ];

            ImpresoraDatosSnmp::updateOrCreate(
                ['impresora_id' => $impresora->id],
                $datosSnmp
            );
        }

        $this->info('Datos SNMP actualizados.');

        //TODO: Descomenta el crontab para que funcione
    }
}

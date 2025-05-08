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

        // Cargar JSON con OIDs por marca/modelo
        $jsonPath = resource_path('oids.json');
        $community = "public";
        $oidsPorModelo = json_decode(file_get_contents($jsonPath), true);

        foreach ($impresoras as $impresora) {
            $modeloSNMP = @snmpget($impresora->ip, $community, '.1.3.6.1.2.1.25.3.2.1.3.1');
            $modeloSNMP = trim(str_replace(['"', 'STRING:'], '', $modeloSNMP)); // limpiar

            $this->info("Modelo SNMP: $modeloSNMP");

            // Detectar marca (puedes afinarlo más)
            $marcaDetectada = null;
            foreach ($oidsPorModelo as $marca => $oids) {
                if (stripos($modeloSNMP, $marca) !== false) {
                    $marcaDetectada = $marca;
                    break;
                }
            }

            if (!$marcaDetectada) {
                $this->warn("Marca no reconocida para IP: {$impresora->ip} - Modelo: $modeloSNMP");
                continue;
            }

            $oids = $oidsPorModelo[$marcaDetectada];

            // Hacer SNMPGET con los OIDs del modelo detectado
            $datosSnmp = [
                'modelo' => $modeloSNMP,
                'mac' => snmpget($impresora->ip, $community, $oids['mac'] ?? ''),
                'paginas_total' => isset($oids['pagesTotal']) ? explode(":", snmpget($impresora->ip, $community, $oids['pagesTotal']))[1] : 0,
                'paginas_bw' => isset($oids['pagesBWTotal']) ? explode(":", snmpget($impresora->ip, $community, $oids['pagesBWTotal']))[1] : 0,
                'paginas_color' => isset($oids['pagesColorTotal']) ? explode(":", snmpget($impresora->ip, $community, $oids['pagesColorTotal']))[1] : 0,
                'num_serie' => snmpget($impresora->ip, $community, $oids['numSerie'] ?? ''),
                'black_toner' => isset($oids['blackToner'])? explode(":", snmpget($impresora->ip, $community, $oids['blackToner']))[1] : 'No registrado',
                'cyan_toner' => isset($oids['cyanToner'])? explode(":", snmpget($impresora->ip, $community, $oids['cyanToner']))[1] : 'No registrado',
               'magenta_toner' => isset($oids['magentaToner'])? explode(":", snmpget($impresora->ip, $community, $oids['magentaToner']))[1] : 'No registrado',
               'yellow_toner' => isset($oids['yellowToner'])? explode(":", snmpget($impresora->ip, $community, $oids['yellowToner']))[1] : 'No registrado',
               'max_capacity' => isset($oids['maxCapacity'])? explode(":", snmpget($impresora->ip, $community, $oids['maxCapacity']))[1] : 'No registrado',
            ];

            // Limpiar resultados (quitar "STRING: ..." y comillas dobles)
            foreach ($datosSnmp as $k => $v) {
                if (is_string($v)) {
                    $datosSnmp[$k] = trim(str_replace(['"', 'STRING:'], '', $v));
                }
            }

            ImpresoraDatosSnmp::updateOrCreate(
                ['impresora_id' => $impresora->id],
                $datosSnmp
            );

            // Establecer activo = 1 si se han guardado datos SNMP, 0 si no
            $tieneDatosSnmp = ImpresoraDatosSnmp::where('impresora_id', $impresora->id)->exists();
            $impresora->activo = $tieneDatosSnmp ? 1 : 0;
            $impresora->save();

            $this->info("Actualizada impresora {$impresora->ip} con modelo {$modeloSNMP} y estado activo = {$impresora->activo}");
        }
    }

}

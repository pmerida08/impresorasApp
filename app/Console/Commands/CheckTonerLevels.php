<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Impresora;
use App\Services\TonerLevelService;

class CheckTonerLevels extends Command
{
    protected $signature = 'impresoras:check-toner-levels';
    protected $description = 'Verifica los niveles de tóner de todas las impresoras y envía alertas';

    protected $tonerLevelService;

    public function __construct(TonerLevelService $tonerLevelService)
    {
        parent::__construct();
        $this->tonerLevelService = $tonerLevelService;
    }

    public function handle()
    {
        $impresoras = Impresora::with('datosSnmp')->get();
        
        // Obtener la dirección de correo y verificar que no esté vacía
        $alertEmail = env('MAIL_DESTINO');
        if (empty($alertEmail)) {
            $this->error("La variable MAIL_DESTINO no está configurada en el archivo .env");
            return 1;
        }
        
        $this->info("Se enviarán alertas a: $alertEmail");
        $results = [];

        foreach ($impresoras as $impresora) {
            $this->info("Verificando impresora: {$impresora->ip}");
            
            $lowTonerLevels = $this->tonerLevelService->checkTonerLevels($impresora);

            if (!empty($lowTonerLevels)) {
                // Solo recopilamos la información, no enviamos correos individuales
                $this->tonerLevelService->collectLowTonerPrinter($impresora, $lowTonerLevels);
                $results[] = [
                    'impresora' => $impresora->ip,
                    'lowTonerLevels' => $lowTonerLevels
                ];
                $this->info("Alerta recopilada para impresora: {$impresora->ip}");
            } else {
                $this->info("Niveles de tóner normales para impresora: {$impresora->ip}");
            }
        }

        // Enviar un solo correo con todas las alertas recopiladas
        $mailSent = false;
        if (!empty($results)) {
            $mailSent = $this->tonerLevelService->sendCombinedLowTonerAlert($alertEmail);
            $this->info($mailSent ? "Correo de alerta combinada enviado correctamente" : "Error al enviar correo de alerta combinada");
        } else {
            $this->info("No se encontraron impresoras con niveles bajos de tóner");
        }

        $this->info("Verificación de niveles de tóner completada.");
        $this->table(['Impresora', 'Niveles Bajos'], 
            array_map(function($result) {
                return [
                    $result['impresora'],
                    json_encode($result['lowTonerLevels'])
                ];
            }, $results)
        );
        
        if (!empty($results)) {
            $this->info("Estado del envío de correo: " . ($mailSent ? "Enviado correctamente" : "Error al enviar"));
        }
    }
}
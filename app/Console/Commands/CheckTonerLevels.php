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
        $alertEmails = User::all()->pluck('email')->toArray();
        $results = [];

        foreach ($impresoras as $impresora) {
            $this->info("Verificando impresora: {$impresora->ip}");
            
            $lowTonerLevels = $this->tonerLevelService->checkTonerLevels($impresora);

            if (!empty($lowTonerLevels)) {
                $mailResult = $this->tonerLevelService->sendLowTonerAlert($impresora, $lowTonerLevels, $alertEmails);
                $results[] = [
                    'impresora' => $impresora->ip,
                    'lowTonerLevels' => $lowTonerLevels,
                    'mailSent' => $mailResult
                ];
                $this->info("Alerta enviada para impresora: {$impresora->ip}");
            } else {
                $this->info("Niveles de tóner normales para impresora: {$impresora->ip}");
            }
        }

        $this->info("Verificación de niveles de tóner completada.");
        $this->table(['Impresora', 'Niveles Bajos', 'Correo Enviado'], 
            array_map(function($result) {
                return [
                    $result['impresora'],
                    json_encode($result['lowTonerLevels']),
                    $result['mailSent'] ? 'Sí' : 'No'
                ];
            }, $results)
        );
    }
}
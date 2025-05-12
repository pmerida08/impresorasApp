<?php

namespace App\Services;

use App\Models\Impresora;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowTonerAlert;

class TonerLevelService
{
    // Almacena las impresoras con niveles bajos de tóner
    private $impresorasConAlertas = [];
    
    public function checkTonerLevels(Impresora $impresora)
    {
        $lowTonerLevels = [];
        $tonerLevels = [
            'black' => $impresora->datosSnmp->black_toner ?? 'No registrado',
            'cyan' => $impresora->datosSnmp->cyan_toner ?? 'No registrado',
            'magenta' => $impresora->datosSnmp->magenta_toner ?? 'No registrado',
            'yellow' => $impresora->datosSnmp->yellow_toner ?? 'No registrado'
        ];

        foreach ($tonerLevels as $color => $level) {
            if ($level !== 'No registrado') {
                $level = (int) $level;
                if ($level < 5) {
                    $lowTonerLevels[$color] = $level;
                } elseif ($level < 20) {
                    $lowTonerLevels[$color] = $level;
                }
            }
        }

        return $lowTonerLevels;
    }

    // Método para recopilar impresoras con alertas
    public function collectLowTonerPrinter(Impresora $impresora, array $lowTonerLevels)
    {
        if (!empty($lowTonerLevels)) {
            $this->impresorasConAlertas[] = [
                'impresora' => $impresora,
                'tonerLevels' => $lowTonerLevels
            ];
        }
    }
    
    // Método para enviar un solo correo con todas las alertas
    public function sendCombinedLowTonerAlert($alertEmail)
    {
        // Si no hay impresoras con alertas, no enviamos nada
        if (empty($this->impresorasConAlertas)) {
            Log::info("No hay impresoras con niveles bajos de tóner para reportar");
            return true;
        }
        
        // Asegurarse de que tenemos una dirección de correo
        if (empty($alertEmail)) {
            $alertEmail = env('MAIL_DESTINO', 'a21mevepa@iesgrancapitan.org');
            Log::info("Usando dirección de correo de respaldo: $alertEmail");
        }
        
        Log::info("Enviando alerta combinada a: " . (is_array($alertEmail) ? implode(', ', $alertEmail) : $alertEmail));
        
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.juntadeandalucia.es';
            $mail->Port = 25;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->CharSet = 'UTF-8';

            // Recipients
            $mail->setFrom('ceis.dpco.chap@juntadeandalucia.es', 'Junta de Andalucía');
            
            // Añadir destinatarios
            if (is_array($alertEmail)) {
                foreach ($alertEmail as $email) {
                    $mail->addAddress($email);
                }
            } else {
                $mail->addAddress($alertEmail);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Alerta: Impresoras con niveles bajos de tóner';

            $body = "<h2>Alerta: Impresoras con niveles bajos de tóner</h2>";
            $body .= "<p>Las siguientes impresoras tienen niveles bajos de tóner:</p>";
            
            $body .= "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
            $body .= "<tr style='background-color: #f2f2f2;'><th>Impresora</th><th>IP</th><th>Ubicación</th><th>Color</th><th>Nivel</th></tr>";
            
            foreach ($this->impresorasConAlertas as $item) {
                $impresora = $item['impresora'];
                foreach ($item['tonerLevels'] as $color => $level) {
                    $body .= "<tr>";
                    $body .= "<td>{$impresora->tipo} {$impresora->modelo}</td>";
                    $body .= "<td>{$impresora->ip}</td>";
                    $body .= "<td>{$impresora->ubicacion}</td>";
                    $body .= "<td>" . ucfirst($color) . "</td>";
                    $body .= "<td>{$level}%</td>";
                    $body .= "</tr>";
                }
            }
            
            $body .= "</table>";
            $body .= "<p>Este es un mensaje automático del sistema de monitoreo de impresoras.</p>";

            $mail->Body = $body;

            $mail->send();
            Log::info("Correo de alerta combinada enviado correctamente con información de " . count($this->impresorasConAlertas) . " impresoras");
            
            // Limpiar la lista después de enviar
            $this->impresorasConAlertas = [];
            
            return true;
        } catch (Exception $e) {
            Log::error("Error al enviar correo de alerta combinada: {$mail->ErrorInfo}");
            return false;
        }
    }
    
    // Mantener el método original para compatibilidad con el código existente
    public function sendLowTonerAlert(Impresora $impresora, array $lowTonerLevels, $alertEmail)
    {
        // Simplemente recopilamos la información y devolvemos true
        $this->collectLowTonerPrinter($impresora, $lowTonerLevels);
        return true;
    }
}
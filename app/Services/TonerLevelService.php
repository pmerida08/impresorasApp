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

    public function sendLowTonerAlert(Impresora $impresora, array $lowTonerLevels, $alertEmails)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.juntadeandalucia.es';
            $mail->Port = 25; // Standard SMTP port for non-encrypted connections
            $mail->SMTPAuth = false; // No authentication
            $mail->SMTPSecure = false; // No encryption
            $mail->SMTPAutoTLS = false; // Disable automatic TLS
            $mail->CharSet = 'UTF-8';

            // Recipients
            $mail->setFrom('ceis.dpco.chap@juntadeandalucia.es', 'Junta de Andalucía');
            foreach ($alertEmails as $alertEmail) {
                $mail->addAddress($alertEmail);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Alerta de nivel bajo de tóner';

            $body = "La impresora {$impresora->tipo} (IP: {$impresora->ip}) tiene niveles bajos de tóner:<br><br>";
            foreach ($lowTonerLevels as $color => $level) {
                $body .= ucfirst($color) . ": " . $level . "%<br>";
            }

            $mail->Body = $body;

            $mail->send();
            Log::info("Correo enviado correctamente para impresora: {$impresora->ip}");
            return true;
        } catch (Exception $e) {
            Log::error("Error al enviar correo para impresora {$impresora->ip}: {$mail->ErrorInfo}");
            return false;
        }
    }
}
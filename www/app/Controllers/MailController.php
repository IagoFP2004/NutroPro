<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends BaseController
{
    public function enviarCorreo($para, $asunto, $mensaje) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP desde .env
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
            $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'] ?? 587;
            $mail->CharSet    = 'UTF-8';

            // Debug desactivado
            $mail->SMTPDebug  = 0;

            // Remitente y destinatario
            $mail->setFrom(
                $_ENV['MAIL_FROM_ADDRESS'] ?? $_ENV['MAIL_USERNAME'],
                $_ENV['MAIL_FROM_NAME'] ?? 'NutroPro'
            );
            $mail->addAddress($para);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;
            $mail->AltBody = strip_tags($mensaje);

            // Enviar
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
}
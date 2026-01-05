<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\DetallePedidoModel;
use Com\Daw2\Models\PedidoModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends BaseController {
    public function enviarCorreo(string $para , $idPedido): bool {
        $pedidoController = new PedidosController();
        $pedidos = $pedidoController->getPedidosUser($_SESSION['usuario']['id_usuario']);


        $pedido = end($pedidos);   // último pedido del array
        try {
            $mail = new PHPMailer(true);
            
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
            $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'] ?? 587;
            $mail->CharSet    = 'UTF-8';
            
            // Debug desactivado en producción
            $mail->SMTPDebug  = 0;
            
            // Remitente y destinatario
            $mail->setFrom(
                $_ENV['MAIL_FROM_ADDRESS'] ?? $_ENV['MAIL_USERNAME'],
                $_ENV['MAIL_FROM_NAME'] ?? 'NutroPro'
            );
            $mail->addAddress($para);

            // Preparar el contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Tu pedido en NutroPro está en marcha!, Numero Pedido:'.$idPedido;

            
            // Construir el cuerpo del correo con diseño responsive
            $mail->Body = '
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center">
                                    <table role="presentation" width="600" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-family: Arial, sans-serif; text-align: center;">
                                                <h1 style="color: #198754; margin: 0 0 16px 0;">¡Gracias por su compra en NutroPro!</h1>
                                                <p style="color: #666; margin: 0 0 8px 0;">Su pedido está siendo procesado y pronto será enviado.</p>
                                                <p>Productos del pedido:</p>
                                                
                                                <p style="color: #666; font-size: 14px; margin: 0;">
                                                    Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>';

            // Versión texto plano del correo (para clientes que no soporten HTML)
            $mail->AltBody = "Gracias por su compra en NutroPro!\n\n" .
                            "Su pedido está siendo procesado y pronto será enviado.\n\n" .
            
            // Enviar el correo
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
}

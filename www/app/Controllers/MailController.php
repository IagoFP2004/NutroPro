<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends BaseController {
    public function enviarCorreo(string $para): bool {
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
            
            // Obtener los productos del carrito del usuario (evitar variable indefinida)
            $productosCarrito = [];
            if (class_exists('\Com\Daw2\Models\CarritoModel')) {
                $carritoModelo = new \Com\Daw2\Models\CarritoModel();
                $productosCarrito = $carritoModelo->getProductosCarrito((int)$idUsuario) ?? [];
            }

            // Preparar el contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Tu pedido en NutroPro está en marcha!';
            
            // Construir la lista de productos
            $listaProductos = '';
            $total = 0;
            foreach ($productosCarrito as $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
                $listaProductos .= '<li style="margin-bottom: 10px;">' . 
                    htmlspecialchars($producto['nombre']) . 
                    ' - Cantidad: ' . $producto['cantidad'] . 
                    ' - Precio: ' . number_format($subtotal, 2) . '€</li>';
            }
            
            // Construir el cuerpo del correo con diseño responsive
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h1 style="color: #198754; text-align: center;">¡Gracias por su compra en NutroPro!</h1>
                <p style="color: #666;">Su pedido está siendo procesado y pronto será enviado.</p>
                <p style="color: #666; font-size: 14px;">Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
            </div>';

            // Versión texto plano del correo (para clientes que no soporten HTML)
            $mail->AltBody = "Gracias por su compra en NutroPro!\n\n" .
                            "Su pedido está siendo procesado y pronto será enviado.\n\n" .
                            "Total del pedido: " . number_format($total, 2) . "€";
            
            // Enviar el correo
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
}

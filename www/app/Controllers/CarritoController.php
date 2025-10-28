<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CarritoModel;

class CarritoController extends BaseController
{
    public function showCarrito():void
    {
        // Debug temporal
        error_log("=== ENTRANDO A showCarrito ===");
        error_log("Usuario en sesión: " . (isset($_SESSION['usuario']) ? 'SI' : 'NO'));
        
        if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
            error_log("Usuario no logueado, redirigiendo a login");
            $_SESSION['error'] = 'Debes iniciar sesión para ver el carrito';
            header('Location: /login');
            exit;
        }

        $idUsuario = $_SESSION['usuario']['id_usuario'];
        error_log("ID Usuario: " . $idUsuario);
        
        $modelo = new CarritoModel();
        
        try {
            $data['numeroItems'] = $modelo->getAll();
            $data['productos'] = $modelo->getProductosCarrito($idUsuario);
            $data['sumaTotal'] = array_sum(array_column($data['productos'], 'precio'));
            $data['gastosEnvio'] =4.50;
            $data['total'] = $data['sumaTotal'] + $data['gastosEnvio'];

            error_log("Número de items: " . $data['numeroItems']);
            error_log("Productos encontrados: " . count($data['productos']));
            error_log("Mostrando vistas...");

            $this->view->showViews(array('templates/header.view.php', 'carrito.view.php','templates/footer.view.php'), $data);
            error_log("=== VISTAS MOSTRADAS ===");
        } catch (\Exception $e) {
            error_log("ERROR: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            $_SESSION['error'] = 'Error al cargar el carrito: ' . $e->getMessage();
            header('Location: /productos');
            exit;
        }
    }

    public function addCarrito():void
    {
        // Obtener datos del POST
        $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT) ?? 1;


        $carritoModel = new CarritoModel();
        $idUsuario = $_SESSION['usuario']['id_usuario'];
        
        $imagenUrl = $carritoModel->getImagenProducto($idProducto);

        $productos = [
            'id_producto' => $idProducto,
            'cantidad' => $cantidad,
            'imagen_url' => $imagenUrl ?? ''
        ];

            $resultado = $carritoModel->insertarCarrito($idUsuario, $productos);

            if ($resultado) {
                $_SESSION['success'] = 'Producto agregado al carrito correctamente';
                // Actualizar el contador del carrito en la sesión
                $_SESSION['carrito_count'] = $carritoModel->contarProductosCarrito($idUsuario);
            } else {
                $_SESSION['error'] = 'Error al agregar el producto al carrito';
            }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
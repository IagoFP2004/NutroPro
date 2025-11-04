<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CarritoModel;

class CarritoController extends BaseController
{
    public function showCarrito():void
    {
        if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
            error_log("Usuario no logueado, redirigiendo a login");
            $_SESSION['error'] = 'Debes iniciar sesión para ver el carrito';
            header('Location: /login');
            exit;
        }

        $idUsuario = $_SESSION['usuario']['id_usuario'];
        
        $modelo = new CarritoModel();
        
        try {
            $data['numeroItems'] = $modelo->getAll();
            $data['productos'] = $modelo->getProductosCarrito($idUsuario);
            $data['sumaTotal'] = array_reduce($data['productos'], function ($total, $producto) {
                return $total + ($producto['precio'] * $producto['cantidad']);
            }, 0);
            $data['gastosEnvio'] =4.50;
            $data['total'] = $data['sumaTotal'] + $data['gastosEnvio'];

            // Pasar mensajes de sesión a la vista
            $data['msjE'] = $_SESSION['msjE'] ?? null;
            $data['msjErr'] = $_SESSION['msjErr'] ?? null;

            unset($_SESSION['msjE']);
            unset($_SESSION['msjErr']);

            $this->view->showViews(array('templates/header.view.php', 'carrito.view.php','templates/footer.view.php'), $data);
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

    public function deleteItemCarrito(int $idProducto):void
    {
        $modelo = new CarritoModel();
        $idUsuario = $_SESSION['usuario']['id_usuario'];
        $borrado = $modelo->deleteItemCarrito($idProducto);
        if ($borrado !== false) {
            $_SESSION['msjE'] = 'Producto eliminado del carrito correctamente';
            $_SESSION['carrito_count'] = $modelo->contarProductosCarrito($idUsuario);
            header('Location: /carrito');
        }else{
            $_SESSION['msjErr'] = 'Error al eliminar el producto del carrito';
            header('Location: /carrito');
        }
    }

    public function pay():void
    {
        $modelo = new CarritoModel();

        $errores = $this->checkPayCard($_POST);

        if (empty($errores)) {

        }else{

            $idUsuario = $_SESSION['usuario']['id_usuario'];

            $data['numeroItems'] = $modelo->getAll();
            $data['productos'] = $modelo->getProductosCarrito($idUsuario);
            $data['sumaTotal'] = array_reduce($data['productos'], function ($total, $producto) {
                return $total + ($producto['precio'] * $producto['cantidad']);
            }, 0);
            $data['gastosEnvio'] =4.50;
            $data['total'] = $data['sumaTotal'] + $data['gastosEnvio'];

            $data['errores'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        $this->view->showViews(array('templates/header.view.php', 'carrito.view.php'), $data);
    }

    public function checkPayCard(array $data):array
    {
        $errores = [];

        if (empty($data['nombreTitular'])) {
            $errores['nombreTitular'] = 'Nombre del titular es obligatorio';
        }else if (!is_string($data['nombreTitular'])) {
            $errores['nombreTitular'] = 'Nombre debe ser un texto';
        }else if(strlen($data['nombreTitular']) < 3 || strlen($data['nombreTitular']) > 50 ){
            $errores['nombreTitular'] = 'Nombre debe tener al menos 3 caracteres y no mas de 50';
        }

        if (empty($data['numeroTarjeta'])) {
            $errores['numeroTarjeta'] = 'Numero tarjeta es obligatorio';
        }else if (strlen($data['numeroTarjeta']) < 16 || strlen($data['numeroTarjeta']) > 16 ){
            $errores['numeroTarjeta'] = 'El numero de la tarjeta tiene que tener 16 numeros';
        }

        if (empty($data['fechaExp'])) {
            $errores['fechaExp'] = 'Fecha de expiracion es obligatorio';
        }

        if (empty($data['cvv'])) {
            $errores['cvv'] = 'CVV es obligatorio';
        }else if (strlen($data['cvv']) < 3 || strlen($data['cvv']) > 3 ) {
            $errores['cvv'] = 'CVV debe tener  3 caracteres';
        }

        return $errores;
    }
}
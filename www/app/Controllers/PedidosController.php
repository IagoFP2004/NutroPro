<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\PedidoModel;

class PedidosController extends BaseController
{
    public function nuevoPedido(int $id_usuario, float $total):int|false
    {
        $modelo = new PedidoModel();
        $insertado = $modelo->insertarProducto($id_usuario, $total);

        if ($insertado == false) {
            $_SESSION['msjErr'] = "No se ha podido registrar el pedido";
            return false;
        }
        
        // Retornar el ID del pedido recién creado
        return $modelo->getLastInsertId();
    }

    public function getPedidosUser(int $id_usuario):array | false
    {
        $modelo = new PedidoModel();
        $pedidos = $modelo->getPedidosByIdUsuario($id_usuario);

        if ($pedidos === false) {
            $_SESSION["msjErr"] = 'No se pudieron obtener los pedidos';
            return false;
        }

        return $pedidos;
    }

    public function cambiarEstado(int $idPedido):void
    {
        // Verificar que sea admin
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['permisos'] != 'rwd') {
            $_SESSION['msjErr'] = 'No tienes permisos para realizar esta acción';
            header('Location: /');
            exit;
        }

        $nuevoEstado = $_POST['estado'] ?? '';
        
        // Validar que el estado sea válido
        $estadosValidos = ['pendiente', 'pagado', 'enviado', 'entregado', 'cancelado'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            $_SESSION['msjErr'] = 'Estado no válido';
            header('Location: /detalle-pedido/' . $idPedido);
            exit;
        }

        $modelo = new PedidoModel();
        $actualizado = $modelo->actualizarEstado($idPedido, $nuevoEstado);

        if ($actualizado) {
            $_SESSION['msjE'] = 'Estado del pedido actualizado correctamente';
        } else {
            $_SESSION['msjErr'] = 'Error al actualizar el estado del pedido';
        }

        header('Location: /detalle-pedido/' . $idPedido);
        exit;
    }
}
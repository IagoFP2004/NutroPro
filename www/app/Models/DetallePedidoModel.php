<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class DetallePedidoModel extends BaseDbModel
{
    public function getPedido(int $idPedido): array | false
    {
        $sql = "SELECT * FROM detalle_pedido WHERE id_pedido = :idPedido";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":idPedido" => $idPedido]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertDetallePedido(int $idPedido, int $idUsuario):bool
    {
        // Obtener productos del carrito del usuario
        $carritoModel = new CarritoModel();
        $productosCarrito = $carritoModel->getProductosCarrito($idUsuario);
        
        if (empty($productosCarrito)) {
            return false;
        }
        
        $sql = "INSERT INTO detalle_pedido(id_pedido, id_producto, cantidad, precio_unitario)
                VALUES (:idPedido, :idProducto, :cantidad, :precioUnitario)";
        $stmt = $this->pdo->prepare($sql);
        
        // Insertar cada producto del carrito como detalle del pedido
        foreach ($productosCarrito as $producto) {
            $result = $stmt->execute([
                ":idPedido" => $idPedido,
                ":idProducto" => $producto["id_producto"],
                ":cantidad" => $producto["cantidad"],
                ":precioUnitario" => $producto["precio"]
            ]);
            
            if (!$result) {
                return false;
            }
        }
        
        return true;
    }
}
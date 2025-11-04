<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class PedidoModel extends BaseDbModel
{
    public function insertarProducto(int $id_usuario, float $total):bool
    {
        $sql = "INSERT INTO pedidos (id_usuario, fecha_pedido, estado, total) 
                VALUES (:id_usuario, NOW(), :estado, :total)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':estado' => 'pendiente',
            ':total' => $total
        ]);
    }
}
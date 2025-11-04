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

    public function getPedidosByIdUsuario(int $id_usuario):array | false
    {
        $sql = "SELECT * FROM pedidos WHERE id_usuario = :id_usuario 
                ORDER BY fecha_pedido DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPedidoById(int $idPedido):array | false
    {
        $sql = "SELECT * FROM pedidos WHERE id_pedido = :id_pedido";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_pedido' => $idPedido]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getLastInsertId():int
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function actualizarEstado(int $idPedido, string $nuevoEstado):bool
    {
        $sql = "UPDATE pedidos SET estado = :estado WHERE id_pedido = :id_pedido";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':estado' => $nuevoEstado,
            ':id_pedido' => $idPedido
        ]);
    }
}
<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;


/**
 *
 */
class CarritoModel extends BaseDbModel
{

    /**
     * @return int
     */
    public function getAll():int
    {
        $sql = "SELECT COUNT(*) FROM carrito";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * @param int $idUsuario
     * @param array $productos
     * @return bool
     */
    public function insertarCarrito(int $idUsuario, array $productos):bool
    {
        $sqlCheck = "SELECT id_carrito, cantidad FROM carrito WHERE id_usuario = :id_usuario AND id_producto = :id_producto";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([
            'id_usuario' => $idUsuario,
            'id_producto' => $productos['id_producto']
        ]);
        $existe = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

        if ($existe) {
            $sqlUpdate = "UPDATE carrito SET cantidad = cantidad + :cantidad WHERE id_carrito = :id_carrito";
            $stmtUpdate = $this->pdo->prepare($sqlUpdate);
            return $stmtUpdate->execute([
                'cantidad' => $productos['cantidad'],
                'id_carrito' => $existe['id_carrito']
            ]);
        } else {
            $sql = "INSERT INTO `carrito`(`id_usuario`, `id_producto`, `cantidad`, `fecha_agregado`) 
            VALUES (:id_usuario, :id_producto, :cantidad, NOW())";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id_usuario' => $idUsuario,
                'id_producto' => $productos['id_producto'],
                'cantidad' => $productos['cantidad'],
            ]);
        }
    }

    /**
     * @param int $idProducto
     * @return string|null
     */
    public function getImagenProducto(int $idProducto): ?string
    {
        $sql = "SELECT imagen_url FROM productos WHERE id_producto = :id_producto";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_producto' => $idProducto]);
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado ? $resultado['imagen_url'] : null;
    }

    /**
     * @param int $idUsuario
     * @return int
     */
    public function contarProductosCarrito(int $idUsuario): int
    {
        $sql = "SELECT SUM(cantidad) as total FROM carrito WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $idUsuario]);
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultado && $resultado['total'] ? (int)$resultado['total'] : 0;
    }

    /**
     * @param int $idUsuario
     * @return array
     */
    public function getProductosCarrito(int $idUsuario):array
    {
        $sql = "SELECT c.*, p.nombre, p.descripcion, p.precio, p.stock, p.imagen_url 
                FROM carrito c 
                INNER JOIN productos p ON c.id_producto = p.id_producto 
                WHERE c.id_usuario = :id_usuario
                ORDER BY c.fecha_agregado DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $idUsuario]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $idProducto
     * @return bool
     */
    public function deleteItemCarrito(int $idProducto):bool
    {
        $sql = "DELETE FROM carrito WHERE id_producto = :id_producto";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_producto' => $idProducto]);
    }

    /**
     * @param int $idUsuario
     * @return bool
     */
    public function deleteAllItemsUser(int $idUsuario):bool
    {
        $sql = "DELETE FROM carrito WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_usuario' => $idUsuario]);
    }
}
<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{
    public function getProductos(): array
    {
        $sql = 'SELECT * FROM productos';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosProteinas(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 1 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosRopa(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 4 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosSuplementos(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 2 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosAccesorios(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 5 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosSnacks(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 3 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert(array $data):bool
    {
        $sql = "INSERT INTO `productos`(`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`) 
        VALUES (:nombre, :descripcion, :precio, :stock, :id_categoria, 0, :imagen_url)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'stock' => $data['stock'],
            'id_categoria' => $data['categoria'],
            'imagen_url' => $data['imagen_url']
        ]);
    }

    public function getProductoById(int $id): ?array
    {
        $sql = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function destacar(int $id): bool
    {
        $sql = "UPDATE productos SET destacado = 1 - destacado WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
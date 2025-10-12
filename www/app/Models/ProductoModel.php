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
}
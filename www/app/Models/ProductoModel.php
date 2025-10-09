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
}
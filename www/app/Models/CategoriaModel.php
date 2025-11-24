<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CategoriaModel extends BaseDbModel
{
    public function getAllCategorias():array
    {
        $sql = 'SELECT * FROM categorias';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
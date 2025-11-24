<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class InicioModel extends BaseDbModel
{
    public function pruebaModelo():array
    {
        $sql = 'SELECT * FROM pedidos';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ResenasModel extends BaseDbModel
{
    public function insertResena(int $idUsuario, array $data): bool
    {
        $sql='INSERT INTO resenas (id_usuario, comentario, valoracion) VALUES (:id_usuario, :comentario, :valoracion)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $idUsuario,
            ':comentario' => $data['comentario'],
            ':valoracion' => $data['valoracion']
        ]);
    }

    public function getResenas():array
    {
        $sql='SELECT u.nombre as nombre, r.comentario , r.valoracion  
              FROM resenas r 
              LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario 
              ORDER BY r.fecha_coment DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
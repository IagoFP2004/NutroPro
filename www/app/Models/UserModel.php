<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UserModel extends BaseDbModel
{

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByEmail(string $email): array | false
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert(array $data): bool
    {
        $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, id_rol) 
                VALUES (:nombre, :email, :password, :direccion, :telefono, :id_rol)";
        
        $stmt = $this->pdo->prepare($sql);

        if(empty($data['id_rol'])){
            $data['id_rol'] = 0;
        }
        
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => $data['password'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'id_rol' => $data['id_rol']
        ]);
    }
    public function getByPhone(string $phone): array | false
    {
        $sql = "SELECT * FROM usuarios WHERE telefono = :phone";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getById(int $idUsuario): array | false
    {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function editInfoUser(array $data, int $idUsuario): bool
    {
        $sql = "UPDATE usuarios SET
        nombre = :nombre,
        email = :email,
        direccion = :direccion,
        telefono = :telefono
        WHERE id_usuario = :idUsuario ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'idUsuario' => $idUsuario
        ]);
    }
}
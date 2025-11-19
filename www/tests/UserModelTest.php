<?php

declare(strict_types=1);

namespace www\tests;

use Com\Daw2\Models\UserModel;
use PDOException;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private UserModel $userModel;

    public function setUp(): void
    {
        parent::setUp();
        $this->userModel = new UserModel();
    }

    public function testCreateUser(): void
    {
        $emailUnico = 'prueba_' . uniqid() . '@gmail.com';
        $data = [
            'nombre' => "UserPrueba",
            'email' => $emailUnico,
            'password' => "123456",
            'direccion' => "Su casa",
            "telefono" => "625172810",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];

        $resultado = $this->userModel->insert($data);

        $this->assertEquals(1, $resultado);
    }

    public function testCreateUserInvalid(): void
    {
        // Usuario para forzar el error
        $emailDuplicado = 'userduplicado_' . uniqid() . '@gmail.com';
        $data1 = [
            'nombre' => "UserPrueba",
            'email' => $emailDuplicado,
            'password' => "123456",
            'direccion' => "Su casa",
            "telefono" => "625172810",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];
        $this->userModel->insert($data1);

        $data2 = [
            'nombre' => "OtroUsuario",
            'email' => $emailDuplicado, // Mismo email
            'password' => "654321",
            'direccion' => "Otra casa",
            "telefono" => "625172811",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];

        $this->expectException(PDOException::class);

        $this->userModel->insert($data2);

    }

    public function testCreateUserInvalid2(): void
    {
        //No mandamos el campo email para forzar el error
        $data = [
            'nombre' => "OtroUsuario",
            'email' => null,
            'password' => "654321",
            'direccion' => "Otra casa",
            "telefono" => "625172811",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];

        $this->expectException(PDOException::class);

        $this->userModel->insert($data);
    }

    public function testLoginUser(): void
    {
        $emailUnico = 'prueba_' . uniqid() . '@gmail.com';
        $data = [
            'nombre' => "UserPrueba",
            'email' => $emailUnico,
            'password' => "123456",
            'direccion' => "Su casa",
            "telefono" => "625172810",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];

        $this->userModel->insert($data);

        $emailInsertado = $data['email'];

        $resultado = $this->userModel->getByEmail($emailInsertado);

        $this->assertIsArray($resultado);
    }

    public function testLoginUserInvalid(): void
    {
        $emailUnico = 'prueba_' . uniqid() . '@gmail.com';
        $data = [
            'nombre' => "UserPrueba",
            'email' => $emailUnico,
            'password' => "123456",
            'direccion' => "Su casa",
            "telefono" => "625172810",
            "fecha_registro" => date("Y-m-d H:i:s"),
            "id_rol" => 1,
        ];

        $this->userModel->insert($data);

        $resultado = $this->userModel->getByEmail('prueba@gmail.com');

        $this->assertSame(false, $resultado);
    }

}
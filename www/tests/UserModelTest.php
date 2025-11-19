<?php

declare(strict_types=1);

use Com\Daw2\Models\UserModel;
use \PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private UserModel $userModel;
    public function setUp(): void
    {
        parent::setUp();
        $this->userModel = new UserModel();
    }

    public function testCreateUser():void
    {
        $emailUnico = 'prueba_' . uniqid() . '@gmail.com';
        $data = [
            'nombre' =>"UserPrueba",
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

}
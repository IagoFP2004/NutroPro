<?php

declare(strict_types=1);

namespace Com\Daw2\Tests;

use Com\Daw2\Controllers\UserController;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private UserController $userController;

    protected function setUp(): void
    {
        // Crear instancia real del controlador para testing
        $this->userController = new UserController();

        // Limpiar variables globales
        $_SESSION = [];
        $_POST = [];
        $_GET = [];
    }

    public function testGetPermisosReturnsReadWriteDeleteForAdmin(): void
    {
        // Ejecutar el método con rol de admin
        $result = $this->userController->getPermisos(1);

        // Verificar el resultado
        $this->assertEquals('rwd', $result);
    }

    public function testGetPermisosReturnsReadOnlyForRegularUser(): void
    {
        // Ejecutar el método con rol de usuario regular
        $result = $this->userController->getPermisos(0);

        // Verificar el resultado
        $this->assertEquals('r', $result);
    }


    public function testGetNumeroPaginasReturnsCorrectNumber(): void
    {
        // Configurar variable de entorno
        $_ENV['numero.pagina'] = 10;

        // Ejecutar el método con 25 elementos totales
        $result = $this->userController->getNumeroPaginas(25);

        // Verificar el resultado (25 / 10 = 2.5 -> ceil = 3)
        $this->assertEquals(3, $result);
    }

    public function testGetNumeroPaginaReturnsOneWhenNoPageSpecified(): void
    {
        // Limpiar GET
        $_GET = [];

        // Ejecutar el método
        $result = $this->userController->getNumeroPagina(5);

        // Verificar el resultado
        $this->assertEquals(1, $result);
    }

    public function testGetNumeroPaginaReturnsValidPageNumber(): void
    {
        // Configurar GET con página válida
        $_GET['page'] = '3';

        // Ejecutar el método
        $result = $this->userController->getNumeroPagina(5);

        // Verificar el resultado
        $this->assertEquals(3, $result);
    }

    public function testGetNumeroPaginaReturnsOneWhenPageOutOfRange(): void
    {
        // Configurar GET con página fuera de rango
        $_GET['page'] = '10';

        // Ejecutar el método
        $result = $this->userController->getNumeroPagina(5);

        // Verificar el resultado
        $this->assertEquals(1, $result);
    }
}

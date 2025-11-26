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
        $this->userController = new UserController();

        $_SESSION = [];
        $_POST = [];
        $_GET = [];
    }

    public function testGetPermisosReturnsReadWriteDeleteForAdmin(): void
    {
        $result = $this->userController->getPermisos(1);

        $this->assertEquals('rwd', $result);
    }


    public function testGetPermisosReturnsReadOnlyForRegularUser(): void
    {
        $result = $this->userController->getPermisos(0);

        $this->assertEquals('r', $result);
    }


    public function testGetNumeroPaginasReturnsCorrectNumber(): void
    {
        $_ENV['numero.pagina'] = 10;

        $result = $this->userController->getNumeroPaginas(25);

        $this->assertEquals(3, $result);
    }

    public function testGetNumeroPaginaReturnsOneWhenNoPageSpecified(): void
    {
        $_GET = [];

        $result = $this->userController->getNumeroPagina(5);

        $this->assertEquals(1, $result);
    }

    public function testGetNumeroPaginaReturnsValidPageNumber(): void
    {
        $_GET['page'] = '3';

        $result = $this->userController->getNumeroPagina(5);

        $this->assertEquals(3, $result);
    }

    public function testGetNumeroPaginaReturnsOneWhenPageOutOfRange(): void
    {
        $_GET['page'] = '10';

        $result = $this->userController->getNumeroPagina(5);

        $this->assertEquals(1, $result);
    }

}

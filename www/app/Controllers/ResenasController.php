<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class ResenasController extends BaseController
{
    public function insertNewComment(int $idUsuario): void
    {
        var_dump($_POST);
        var_dump($idUsuario);
        // Aquí podrás ver tanto los datos del formulario como el ID del usuario
    }
}
<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ResenasModel;

class ResenasController extends BaseController
{
    public function insertNewComment(int $idUsuario): void
    {
        $modelo = new ResenasModel();

        $errores = $this->checkErrors($_POST);

        if (empty($errores)){

            if ($modelo->insertResena($idUsuario, $_POST)) {
                $_SESSION['msjE'] = 'Reseña enviada con éxito!.';
                header ('Location: /micuenta/'.$idUsuario);
            } else {
                $_SESSION['msjErr'] = 'No se ha podido enviar la reseña. Por favor, inténtalo de nuevo más tarde.';
                header('Location: /micuenta/'.$idUsuario);
            }
        }else{
            $_SESSION['msjErr'] = 'No se ha podido enviar la reseña. Por favor, corrige los errores e inténtalo de nuevo.';
            header('Location: /micuenta/'.$idUsuario);
        }
    }

    public function checkErrors(array $data): array
    {
        $errors = [];

        if (empty($data['comentario']) || strlen($data['comentario']) < 10) {
            $errors['comentario'] = 'El comentario debe tener al menos 10 caracteres.';
        }

        if (empty($data['valoracion']) || !in_array($data['valoracion'], [1, 2, 3, 4, 5])) {
            $errors['valoracion'] = 'La valoración debe ser un número entre 1 y 5.';
        }

        return $errors;
    }

}
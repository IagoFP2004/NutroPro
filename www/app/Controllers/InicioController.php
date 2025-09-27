<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\InicioModel;

class InicioController extends BaseController
{
    public function index() {
        $data = array(
            'titulo' => 'Pagina inicial',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );

        $modelo = new InicioModel();

        $data['pedidos'] = $modelo->pruebaModelo();

        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php'), $data);
    }
}
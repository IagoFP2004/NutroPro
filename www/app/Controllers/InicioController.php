<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class InicioController extends BaseController
{
    public function index() {
        $data = array(
            'titulo' => 'Pagina inicial',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );
        $this->view->show('prueba.view.php', $data);
    }
}
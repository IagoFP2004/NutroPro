<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CarritoModel;
use Com\Daw2\Models\InicioModel;
use Com\Daw2\Models\ProductoModel;

class InicioController extends BaseController
{
    public function index() {
        $data = array(
            'titulo' => 'Pagina inicial',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );

        $productoModel = new ProductoModel();
        $data['productos'] = $productoModel->getProductos();

        $carritoModel = new CarritoModel();
        $data['carrito'] = $carritoModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php','templates/footer.view.php'), $data);
    }
}
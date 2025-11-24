<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CarritoModel;
use Com\Daw2\Models\InicioModel;
use Com\Daw2\Models\ProductoModel;
use Com\Daw2\Models\ResenasModel;

class InicioController extends BaseController
{
    /**
     * @return void
     * @throws \Exception
     */
    public function index() {
        $productoModel = new ProductoModel();
        $data['productos'] = $productoModel->getProductos();

        $carritoModel = new CarritoModel();
        $data['carrito'] = $carritoModel->getAll();

        $resenaModel = new ResenasModel();
        $data['resenas'] = $resenaModel->getResenas();

        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php','templates/footer.view.php'), $data);
    }
}
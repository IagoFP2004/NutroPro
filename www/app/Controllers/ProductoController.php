<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductoModel;
use Com\Daw2\Controllers\ProductoController;
use use Com\Daw2\Controllers\ProductoController;



class ProductoController extends BaseController
{
    public function showProductsView(): void
    {
        $data = array(
            'titulo' => 'Productos',
            'breadcrumb' => ['Inicio/productos'],
            'seccion' => '/productos'
        );

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php','templates/footer.view.php'), $data);
    }
}
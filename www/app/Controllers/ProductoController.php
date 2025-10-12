<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductoModel;

class ProductoController extends BaseController
{
    public function showProductsView(): void
    {
        $data = array(
            'titulo' => 'Productos',
            'breadcrumb' => ['Inicio/productos'],
            'seccion' => '/productos'
        );

        $modelo = new ProductoModel();

        $data['proteinas'] = $modelo->getProductosProteinas();
        $data['ropas'] = $modelo->getProductosRopa();

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php','templates/footer.view.php'), $data);
    }


}
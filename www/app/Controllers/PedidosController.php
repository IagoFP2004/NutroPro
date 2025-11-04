<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\PedidoModel;

class PedidosController extends BaseController
{
    public function nuevoPedido(int $id_usuario, float $total):void
    {
        $modelo = new PedidoModel();
        $insertado = $modelo->insertarProducto($id_usuario,$total);

        if($insertado == false){
            $_SESSION['msjErr'] = "No se ha podido registrar el pedido";
        }
    }
}
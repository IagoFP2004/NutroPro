<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\DetallePedidoModel;
use Com\Daw2\Models\PedidoModel;

class DetallePedidoController extends BaseController
{
    public function verPedido($idPedido):void
    {
        $modelo = new DetallePedidoModel();
        $detalle = $modelo->getPedido($idPedido);
        
        $data = [];
        
        if (!empty($detalle)) {
            $data['detallepedido'] = $detalle;
            $data['pedido'] = $this->getPedidoInfo($idPedido);
        } else {
            $_SESSION['msjErr'] = "No se encuentra el detalle del pedido";
            header('Location: /micuenta/' . $_SESSION['usuario']['id_usuario']);
            exit;
        }
        
        $this->view->showViews(array('templates/header.view.php', 'detallePedido.view.php', 'templates/footer.view.php'), $data);
    }
    
    private function getPedidoInfo(int $idPedido): array | false
    {
        $pedidoModel = new PedidoModel();
        return $pedidoModel->getPedidoById($idPedido);
    }


}
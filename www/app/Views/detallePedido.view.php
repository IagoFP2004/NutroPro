<main class="container py-5">
    <?php if (!empty($_SESSION['msjE'])) { ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['msjE']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['msjE']); ?>
    <?php } elseif (!empty($_SESSION['msjErr'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['msjErr']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['msjErr']); ?>
    <?php } ?>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <!-- Encabezado del pedido -->
        <div class="bg-success text-white py-4 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="bi bi-receipt me-2"></i>Pedido #NP-<?php echo $pedido['id_pedido'] ?>
                    </h2>
                    <p class="mb-1 opacity-75">
                        <i class="bi bi-calendar-event me-1"></i>
                        Realizado el <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?>
                    </p>
                    <?php 
                    // Calcular fecha de entrega estimada (5 días después del pedido)
                    $fechaEntrega = date('d/m/Y', strtotime($pedido['fecha_pedido'] . ' +5 days'));
                    ?>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-truck me-1"></i>
                        Entrega estimada: <?php echo $fechaEntrega ?>
                    </p>
                </div>
                <div class="text-end">
                    <?php 
                    $badgeClass = 'bg-warning';
                    switch($pedido['estado']) {
                        case 'entregado':
                            $badgeClass = 'bg-success';
                            break;
                        case 'cancelado':
                            $badgeClass = 'bg-danger';
                            break;
                        case 'enviado':
                            $badgeClass = 'bg-info';
                            break;
                    }
                    ?>
                    <span class="badge <?php echo $badgeClass ?> fs-5 px-4 py-2 text-capitalize">
                        <?php echo $pedido['estado'] ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-4 p-md-5 bg-white">
            
            <!-- Productos del pedido -->
            <h4 class="text-success mb-4">
                <i class="bi bi-bag-check me-2"></i>Productos del pedido
            </h4>

            <?php if (!empty($detallepedido)): ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio unitario</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $subtotal = 0;
                            foreach ($detallepedido as $item){
                                $itemTotal = $item['cantidad'] * $item['precio_unitario'];
                                $subtotal += $itemTotal;
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="flex: 0 0 auto;">
                                                <img src="<?php echo $_ENV['IMG_BASE'].$item['imagen_url']?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['nombre_producto']) ?>" style="width:64px; height:64px; object-fit:cover;">
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($item['nombre_producto']) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">
                                            <?php echo $item['cantidad'] ?> unidades
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <?php echo number_format($item['precio_unitario'], 2) ?> €
                                    </td>
                                    <td class="text-end fw-bold">
                                        <?php echo number_format($itemTotal, 2) ?> €
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                <td class="text-end fw-bold"><?php echo number_format($subtotal, 2) ?> €</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Gastos de envío:</td>
                                <td class="text-end fw-bold">4.50 €</td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="3" class="text-end fs-5 fw-bold">Total:</td>
                                <td class="text-end fs-5 fw-bold text-success"><?php echo number_format($pedido['total'], 2) ?> €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No hay productos en este pedido
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] == 'rwd'): ?>
                <hr class="my-5">
                <div class="card border-warning">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-pencil-square me-2"></i>Cambiar estado del pedido
                        </h5>
                        <form action="/pedido/cambiar-estado/<?php echo $pedido['id_pedido'] ?>" method="POST" class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="estado" class="form-label fw-semibold">Estado del pedido</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="pendiente" <?php echo $pedido['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="entregado" <?php echo $pedido['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                                    <option value="cancelado" <?php echo $pedido['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-check-circle me-2"></i>Actualizar estado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <hr class="my-5">

            <h4 class="text-success mb-4">
                <i class="bi bi-clipboard2-data-fill"></i>Datos de entrega del pedido
            </h4>
            <div class="mb-3">
                <i class="bi bi-truck me-1"></i>Direccion de envio: <?php echo $_SESSION['usuario']['direccion']?>
            </div>
            <div class="mb-3">
                <i class="bi bi-person me-1"></i>Nombre del cliente: <?php echo $_SESSION['usuario']['nombre']?>
            </div>
            <div>
                <i class="bi bi-telephone"></i>Telefono del cliente: <?php echo $_SESSION['usuario']['telefono']?>
            </div>


            <?php if (isset($_SESSION['usuario']) && (!$_SESSION['usuario']['permisos'] == 'rwd' )){ ?>
            <!-- Botón volver -->
            <div class="text-end mt-3 mb-2">
                <a href="/micuenta/<?php echo $_SESSION['usuario']['id_usuario'] ?>" class="btn btn-outline-success px-4">
                    <i class="bi bi-arrow-left me-2"></i>Volver a mi cuenta
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</main>


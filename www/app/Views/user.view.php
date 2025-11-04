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

        <div class="bg-success text-white text-center py-5">
            <h2 class="fw-bold mb-0"><?php echo $usuario['nombre'] ?></h2>
        </div>

        <div class="p-4 p-md-5 bg-white">
            <h4 class="text-success mb-4"><i class="bi bi-person-circle me-2"></i> Información Personal</h4>
            <form action="/micuenta/edit/<?php echo $usuario['id_usuario'] ?>" method="POST">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control inputs" name="nombre" id="nombre" value="<?php echo $input['nombre'] ?? $usuario['nombre'] ?>">
                        <p class="text-danger"><?php echo $errores['nombre'] ?? '' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" class="form-control inputs" name="email" id="email" value="<?php echo $input['email'] ??$usuario['email'] ?>">
                        <p class="text-danger"><?php echo $errores['email'] ?? '' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" class="form-control inputs" name="telefono" id="telefono" value="<?php echo $input['telefono'] ?? $usuario['telefono'] ?>">
                        <p class="text-danger"><?php echo $errores['telefono'] ?? '' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de Registro</label>
                        <input type="text" class="form-control " readonly value="<?php echo $input['fecha_registro'] ?? $usuario['fecha_registro'] ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Dirección</label>
                        <textarea class="form-control inputs" name="direccion" id="direccion" rows="2"><?php echo $input['direccion'] ?? $usuario['direccion'] ?></textarea>
                        <p class="text-danger"><?php echo $errores['direccion'] ?? '' ?></p>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button id="btnGuardar" class="btn btn-success" disabled>Guardar cambios</button>
                </div>
            </form>
            <hr class="my-5">

            <h4 class="text-success mb-4"><i class="bi bi-bag-check me-2"></i> Últimos pedidos</h4>
            <div class="table-responsive">
                <?php if (!empty($pedidos)) { ?>
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th># Pedido</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pedidos as $pedido) { ?>
                    <tr>
                        <td>NP-<?php echo $pedido['id_pedido'] ?></td>
                        <td><?php echo $pedido['fecha_pedido'] ?>></td>
                        <td><span class="badge text-bg-<?php echo  ($pedido['estado'] == 'cancelado') ? 'danger' : (($pedido['estado'] == 'pendiente') ? 'warning' : (($pedido['estado'] == 'entregado') ? 'success' : 'secondary'));?>"><?php echo $pedido['estado'] ?></span></td>
                        <td><strong><?php echo $pedido['total'] ?> €</strong></td>
                        <td><a href="/detalle-pedido/<?php echo $pedido['id_pedido'] ?>" class="btn btn-outline-success btn-sm">Ver</a></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php }else{?>
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle me-2"></i>
                            No hay pedidos para mostrar. <a href="/productos" class="alert-link">¡Empieza a comprar!</a>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</main>

<script src='/assets/js/disabledButton.js'></script>

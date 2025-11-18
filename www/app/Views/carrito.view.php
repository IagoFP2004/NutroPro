<?php if (!empty($msjE)) { ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($msjE) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
<?php } elseif (!empty($msjErr)) { ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($msjErr) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
<?php } ?>

<main class="flex-grow-1 py-3 py-md-5 bg-light">
    <div class="container py-2 py-md-4">
        <div class="row g-5">

            <!-- 🛒 Carrito -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 fw-bold text-success mb-0">
                        <i class="bi bi-cart-fill me-2"></i> Tu carrito
                    </h1>
                    <span class="badge bg-success fs-6"><?php echo isset($_SESSION['carrito_count']) ? $_SESSION['carrito_count'] : 0; ?> artículos</span>
                </div>

                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="card border-0 shadow-sm mb-4 p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-3 col-md-2">
                                    <img src="<?php echo $_ENV['IMG_BASE'].$producto['imagen_url']?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($producto['nombre']) ?>">
                                </div>
                                <div class="col-9 col-md-6">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($producto['nombre']) ?></h5>
                                    <small class="text-muted"><?php echo htmlspecialchars($producto['descripcion']) ?></small>
                                </div>
                                <div class="col-6 col-md-2">
                                    <input type="text" class="form-control form-control-lg" value="<?php echo $producto['cantidad'] ?>" readonly>
                                </div>
                                <div class="col-6 col-md-2 text-end">
                                    <div class="fw-bold text-success fs-5"><?php echo number_format($producto['precio'], 2) ?> €</div>
                                    <a href="<?php echo $_ENV['host.folder'].'carrito/remove/'.$producto['id_producto'] ?>" class="text-danger small d-inline-block mt-1"><i class="bi bi-x-circle me-1"></i>Quitar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Tu carrito está vacío. <a href="/productos" class="alert-link">¡Empieza a comprar!</a>
                    </div>
                <?php endif; ?>
                <!-- Botón seguir comprando -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="/productos" class="btn btn-outline-success btn-lg px-4">
                        <i class="bi bi-arrow-left me-1"></i> Seguir comprando
                    </a>
                </div>
            </div>

            <!-- 🧾 Resumen y formulario de pago -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg p-4">
                    <h4 class="fw-bold text-success mb-4">
                        <i class="bi bi-receipt-cutoff me-1"></i> Resumen del pedido
                    </h4>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span class="fw-semibold fs-5"><?php echo $sumaTotal ?> €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío</span>
                        <span class="fw-semibold fs-5"><?php echo $gastosEnvio ?> €</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center fs-4 mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-success"><?php echo ($sumaTotal == 0) ? 0 : $total ?> €</span>
                    </div>

                    <form action="/carrito" method="POST" class="mb-4">
                        <div class="mb-3">
                            <label for="nombreTitular" class="form-label">Nombre del titular</label>
                            <input type="text" class="form-control" id="nombreTitular" name="nombreTitular" placeholder="Titular" value="<?php echo $input['nombreTitular'] ?? '' ?>" required>
                            <p class="text-danger"><?php echo $errores['nombreTitular'] ?? '' ?></p>
                        </div>

                        <div class="mb-3">
                            <i class="bi bi-credit-card"></i>
                            <label for="numeroTarjeta" class="form-label">Número de tarjeta</label>
                            <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" value="<?php echo $input['numeroTarjeta'] ?? '' ?>" required>
                            <p class="text-danger"><?php echo $errores['numeroTarjeta'] ?? '' ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="fechaExp" class="form-label">Fecha de expiración</label>
                                <input type="text" class="form-control" id="fechaExp" name="fechaExp" placeholder="MM/AA" value="<?php echo $input['fechaExp'] ?? '' ?>" required>
                                <p class="text-danger"><?php echo $errores['fechaExp'] ?? '' ?></p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" placeholder="123" value="<?php echo $input['cvv'] ?? '' ?>" required>
                                <p class="text-danger"><?php echo $errores['cvv'] ?? '' ?></p>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-lock-fill me-2"></i>Finalizar compra
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

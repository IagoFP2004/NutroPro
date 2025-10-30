<main class="flex-grow-1 d-flex align-items-center py-5 bg-light vh-100">
    <div class="container py-4">
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
                                    <input type="number" class="form-control form-control-lg" min="1" value="<?php echo $producto['cantidad'] ?>">
                                </div>
                                <div class="col-6 col-md-2 text-end">
                                    <div class="fw-bold text-success fs-5"><?php echo number_format($producto['precio'], 2) ?> €</div>
                                    <a href="#" class="text-danger small d-inline-block mt-1"><i class="bi bi-x-circle me-1"></i>Quitar</a>
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
                        <span class="fw-bold text-success"><?php echo $total ?> €</span>
                    </div>

                    <form action="/procesar-pago" method="POST" class="mb-4">
                        <div class="mb-3">
                            <label for="nombreTitular" class="form-label">Nombre del titular</label>
                            <input type="text" class="form-control" id="nombreTitular" name="nombreTitular" placeholder="Titular" required>
                        </div>

                        <div class="mb-3">
                            <i class="bi bi-credit-card"></i>
                            <label for="numeroTarjeta" class="form-label">Número de tarjeta</label>
                            <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="fechaExp" class="form-label">Fecha de expiración</label>
                                <input type="text" class="form-control" id="fechaExp" name="fechaExp" placeholder="MM/AA" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
                            </div>
                        </div>
                    </form>

                    <div class="d-grid mb-3">
                        <form action="/carrito" method="post">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-lock-fill me-2"></i>Finalizar compra
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

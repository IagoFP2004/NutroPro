<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto - NutroPro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<main class="container py-5">

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="<?php echo $_ENV['BASE_URL'] ?>productos" class="text-success text-decoration-none">
            <i class="bi bi-arrow-left"></i> Volver a productos
        </a>
    </div>

    <!-- Contenido principal del producto -->
    <div class="row g-4">
        <!-- Imagen -->
        <div class="col-12 col-md-6">
            <div class="bg-light p-3 rounded shadow-sm">
                <img src="<?php echo $_ENV['IMG_BASE'] . $producto['imagen_url'] ?>"
                     alt="<?php echo htmlspecialchars($producto['nombre']) ?>"
                     class="img-fluid rounded mx-auto d-block"
                     style="max-height: 350px; width: 100%; object-fit: contain;">
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-12 col-md-6">
            <div class="sticky-md-top" style="top: 1rem;">
                <h1 class="h2 fw-bold text-success mb-3"><?php echo htmlspecialchars($producto['nombre']) ?></h1>
                <p class="lead text-muted">
                    <?php echo htmlspecialchars($producto['descripcion']) ?>
                </p>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold text-success mb-0"><?php echo number_format($producto['precio'], 2) ?> €</h3>
                    <p class="text-secondary mb-0">Stock: <strong><?php echo $producto['stock'] ?></strong></p>
                </div>

                <!-- Formulario para añadir al carrito -->
                <?php if (isset($_SESSION['usuario'])): ?>
                <form action="<?php echo $_ENV['BASE_URL'] ?>carrito/add" method="POST" class="mt-4">
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto'] ?>">
                    <div class="d-flex gap-3 flex-column flex-sm-row">
                        <div class="input-group" style="max-width: 120px;">
                            <input type="number" name="cantidad" class="form-control text-center" value="1" min="1" max="<?php echo $producto['stock'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i> Añadir al carrito
                        </button>
                    </div>
                </form>
                <?php else: ?>
                <div class="mt-4">
                    <a href="<?php echo $_ENV['BASE_URL'] ?>login" class="btn btn-success w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Inicia sesión para comprar
                    </a>
                </div>
                <?php endif; ?>
        </div>
    </div>

    <!--  INFORMACIÓN NUTRICIONAL O DATOS DEL PRODUCTO -->
    <?php if ($producto['id_categoria'] != 5): ?>
        <section class="mt-5">
            <?php if (in_array($producto['id_categoria'], [1,3])): ?>
                <!-- Mostrar información nutricional solo para suplementos/alimentos -->
                <h4 class="fw-bold text-center text-success mb-4">
                    Información Nutricional (por 100g)
                </h4>

                <div class="row justify-content-center text-center g-3">
                    <div class="col-4">
                        <div class="bg-light p-3 p-md-4 rounded shadow-sm h-100">
                            <i class="bi bi-egg-fried text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-1 fs-6 fs-md-5">Proteínas</h5>
                            <p class="text-muted mb-0 fs-6 fs-md-5"><?php echo $producto['proteinas'] ?? '0' ?> g</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-light p-3 p-md-4 rounded shadow-sm h-100">
                            <i class="bi bi-cookie text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-1 fs-6 fs-md-5">Carbohidratos</h5>
                            <p class="text-muted mb-0 fs-6 fs-md-5"><?php echo $producto['carbohidratos'] ?? '0' ?> g</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-light p-3 p-md-4 rounded shadow-sm h-100">
                            <i class="bi bi-droplet text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-1 fs-6 fs-md-5">Grasas</h5>
                            <p class="text-muted mb-0 fs-6 fs-md-5"><?php echo $producto['grasas'] ?? '0' ?> g</p>
                        </div>
                    </div>
                </div>

            <?php elseif ($producto['id_categoria'] == 4): // Solo para Ropa (categoría 4) ?>
                <!-- Mostrar información relevante para ropa -->
                <h4 class="fw-bold text-center text-success mb-4">
                    Detalles del producto
                </h4>

                <div class="row justify-content-center text-center g-4">
                    <div class="col-6 col-md-3">
                        <div class="bg-light p-4 rounded shadow-sm">
                            <i class="bi bi-rulers text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-0">Talla</h5>
                            <p class="text-muted fs-5 mb-0"><?php echo $producto['talla'] ?? 'Única' ?></p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="bg-light p-4 rounded shadow-sm">
                            <i class="bi bi-palette text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-0">Color</h5>
                            <p class="text-muted fs-5 mb-0"><?php echo $producto['color'] ?? 'Variedad' ?></p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="bg-light p-4 rounded shadow-sm">
                            <i class="bi bi-box-seam text-success fs-3 mb-2"></i>
                            <h5 class="fw-bold mb-0">Material</h5>
                            <p class="text-muted fs-5 mb-0"><?php echo $producto['material'] ?? 'N/A' ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>


    <!-- Productos relacionados -->
    <!-- Productos relacionados -->
    <section class="mt-5">
        <h4 class="fw-bold text-center text-success mb-4">
            Productos relacionados
        </h4>

        <div class="row g-3 g-md-4 justify-content-center">
            <?php foreach ($productosVendidos as $prod){ ?>
                <?php if ($prod['id_categoria'] == $producto['id_categoria']){ ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="/assets/img/<?php echo htmlspecialchars($prod['imagen_url']) ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($prod['nombre']) ?>"
                             style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="fw-semibold mb-2 text-truncate"><?php echo htmlspecialchars($prod['nombre']) ?></h6>
                        <p class="text-success fw-bold mb-2"><?php echo number_format($prod['precio'], 2) ?> €</p>
                        <a href="<?php echo $_ENV['BASE_URL'] ?>productos/<?php echo $prod['id_producto'] ?>" 
                           class="btn btn-success btn-sm w-100">
                            <i class="bi bi-search"></i> Ver producto
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

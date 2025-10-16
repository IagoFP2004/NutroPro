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

    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="#" class="text-success text-decoration-none">
            <i class="bi bi-arrow-left"></i> Volver a productos
        </a>
    </div>

    <!-- Contenido principal del producto -->
    <div class="row align-items-center g-5">
        <!-- Imagen -->
        <div class="col-md-6 text-center">
            <div class="bg-light p-3 rounded shadow-sm">
                <img src="<?php echo $_ENV['IMG_BASE'].$producto['imagen_url']?>"
                     alt="Nombre del producto"
                     class="img-fluid rounded"
                     style="max-height: 400px; object-fit: contain;"> <!--object-fit: contain sirve para indicarle al navegador que se adapte completamente a su caja padre-->
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-md-6">
            <h1 class="fw-bold text-success mb-3"><?php echo $producto['nombre'] ?></h1>
            <p class="lead text-muted">
                <?php echo $producto['descripcion'] ?>
            </p>

            <hr>

            <h3 class="fw-bold text-success mb-3"><?php echo $producto['precio'] ?> €</h3>
            <p class="text-secondary">Stock disponible: <strong><?php echo $producto['stock'] ?></strong></p>

            <button class="btn btn-success btn-lg px-4 mt-3">
                <i class="bi bi-cart-plus me-2"></i> Añadir al carrito
            </button>
        </div>
    </div>

    <!--  INFORMACIÓN NUTRICIONAL -->
    <section class="mt-5">
        <h4 class="fw-bold text-center text-success mb-4">
            </i> Información Nutricional (por 100g)
        </h4>

        <div class="row justify-content-center text-center g-4">
            <div class="col-6 col-md-3">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-egg-fried text-success fs-3 mb-2"></i>
                    <h5 class="fw-bold mb-0">Proteínas</h5>
                    <p class="text-muted fs-5 mb-0"><?php echo $producto['proteinas'] ?> g</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-cookie text-success fs-3 mb-2"></i>
                    <h5 class="fw-bold mb-0">Carbohidratos</h5>
                    <p class="text-muted fs-5 mb-0"><?php echo $producto['carbohidratos'] ?> g</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-droplet text-success fs-3 mb-2"></i>
                    <h5 class="fw-bold mb-0">Grasas</h5>
                    <p class="text-muted fs-5 mb-0"><?php echo $producto['grasas'] ?> g</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos relacionados -->
    <!-- Productos más vendidos -->
    <section class="mt-5">
        <h4 class="fw-bold text-center text-success mb-4">
             Los más vendidos
        </h4>

        <div class="row g-4 justify-content-center">
            <!-- Producto 1 -->
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto2.png" class="card-img-top" alt="Proteína Whey 1kg">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Proteína Whey 1kg</h6>
                            <p class="text-success fw-bold mb-0">29,99 €</p>
                            <button class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-cart-plus me-1"></i> Añadir
                            </button>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Producto 2 -->
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto3.png" class="card-img-top" alt="Shaker NutroPro">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Shaker NutroPro</h6>
                            <p class="text-success fw-bold mb-0">6,99 €</p>
                            <button class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-cart-plus me-1"></i> Añadir
                            </button>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Producto 3 -->
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto4.png" class="card-img-top" alt="Barrita energética">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Barrita energética</h6>
                            <p class="text-success fw-bold mb-0">2,49 €</p>
                            <button class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-cart-plus me-1"></i> Añadir
                            </button>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Producto 4 -->
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto5.png" class="card-img-top" alt="Creatina Monohidratada 500g">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Creatina Monohidratada 500g</h6>
                            <p class="text-success fw-bold mb-0">15,99 €</p>
                            <button class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-cart-plus me-1"></i> Añadir
                            </button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

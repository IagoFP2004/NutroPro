<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda NutroPro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- ====== Botón añadir producto ====== -->
<div class="container mt-4 d-flex justify-content-end">
    <a href="/productos/nuevo" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Añadir producto
    </a>
</div>

<!-- Contenido principal -->
<main class="container mb-5">

    <!-- CATEGORÍA 1: Proteína & Creatina -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Proteína & Creatina</h2>
        <div class="row g-4">
            <?php foreach ($proteinas as $proteina) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $proteina['imagen_url']; ?>" class="card-img-top" alt="Proteína Whey">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $proteina['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $proteina['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <button class="btn btn-success">Añadir al carrito</button>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-star me-1"></i> Destacar producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- CATEGORÍA 2: Ropa de Gimnasio -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Ropa de Gimnasio</h2>
        <div class="row g-4">
            <?php foreach ($ropas as $ropa) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $ropa['imagen_url']; ?>" class="card-img-top" alt="Ropa de gimnasio">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $ropa['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $ropa['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <button class="btn btn-success">Añadir al carrito</button>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-star me-1"></i> Destacar producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- CATEGORÍA 3: Suplementos -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Suplementos</h2>
        <div class="row g-4">
            <?php foreach ($suplementos as $suplemento) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $suplemento['imagen_url']; ?>" class="card-img-top" alt="Suplemento">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $suplemento['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $suplemento['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <button class="btn btn-success">Añadir al carrito</button>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-star me-1"></i> Destacar producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- CATEGORÍA 4: Accesorios -->
    <section>
        <h2 class="fw-bold mb-4 text-success text-center">Accesorios</h2>
        <div class="row g-4">
            <?php foreach ($accesorios as $accesorio) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $accesorio['imagen_url']; ?>" class="card-img-top" alt="Accesorio">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $accesorio['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $accesorio['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <button class="btn btn-success">Añadir al carrito</button>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-star me-1"></i> Destacar producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
                <img src="assets/img/ejemplo-producto.png"
                     alt="Nombre del producto"
                     class="img-fluid rounded"
                     style="max-height: 400px; object-fit: contain;">
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-md-6">
            <h1 class="fw-bold text-success mb-3">Creatina Monohidratada 500g</h1>
            <p class="lead text-muted">
                Creatina de alta pureza para mejorar tu rendimiento físico y aumentar la fuerza muscular. Ideal para entrenamientos intensos.
            </p>

            <hr>

            <h3 class="fw-bold text-success mb-3">15,99 €</h3>
            <p class="text-secondary">Stock disponible: <strong>120 unidades</strong></p>

            <button class="btn btn-success btn-lg px-4 mt-3">
                <i class="bi bi-cart-plus me-2"></i> Añadir al carrito
            </button>
        </div>
    </div>

    <!-- Productos relacionados -->
    <section class="mt-5">
        <h4 class="fw-bold text-center text-success mb-4">También te puede interesar</h4>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto2.png" class="card-img-top" alt="Producto relacionado">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Proteína Whey 1kg</h6>
                            <p class="text-success fw-bold mb-0">29,99 €</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="assets/img/ejemplo-producto3.png" class="card-img-top" alt="Producto relacionado">
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1">Shaker NutroPro</h6>
                            <p class="text-success fw-bold mb-0">6,99 €</p>
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

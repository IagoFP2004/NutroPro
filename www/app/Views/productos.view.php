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
<!-- Contenido principal -->
<main class="container mb-5">

    <!-- 🏋️‍♂️ CATEGORÍA 1: Proteína & Creatina -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Proteína & Creatina</h2>
        <div class="row g-4">
            <?php foreach ($proteinas as $proteina){?>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm product-card h-100">
                    <img src="<?php echo $proteina['imagen_url'] ?>" class="card-img-top" alt="Proteína Whey">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $proteina['nombre']?></h5>
                        <p class="text-success fw-bold mb-3"><?php echo $proteina['precio'] ?>€</p>
                        <button class="btn btn-success mt-auto">Añadir al carrito</button>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </section>

    <!-- CATEGORÍA 2: Ropa de Gimnasio -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Ropa de Gimnasio</h2>
        <div class="row g-4">
            <?php foreach ($ropas as $ropa){?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $ropa['imagen_url'] ?>" class="card-img-top" alt="Proteína Whey">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $ropa['nombre']?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $ropa['precio'] ?>€</p>
                            <button class="btn btn-success mt-auto">Añadir al carrito</button>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </section>

    <!-- 💊 CATEGORÍA 3: Suplementos -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Suplementos</h2>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm product-card h-100">
                    <img src="https://via.placeholder.com/300x300?text=Omega+3" class="card-img-top" alt="Omega 3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Omega 3</h5>
                        <p class="text-success fw-bold mb-3">$15.99</p>
                        <button class="btn btn-success mt-auto">Añadir al carrito</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm product-card h-100">
                    <img src="https://via.placeholder.com/300x300?text=Multivitamínico" class="card-img-top" alt="Multivitamínico">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Multivitamínico</h5>
                        <p class="text-success fw-bold mb-3">$12.99</p>
                        <button class="btn btn-success mt-auto">Añadir al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🧤 CATEGORÍA 4: Accesorios -->
    <section>
        <h2 class="fw-bold mb-4 text-success text-center">Accesorios</h2>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm product-card h-100">
                    <img src="https://via.placeholder.com/300x300?text=Shaker+NutroPro" class="card-img-top" alt="Shaker">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Shaker NutroPro</h5>
                        <p class="text-success fw-bold mb-3">$9.99</p>
                        <button class="btn btn-success mt-auto">Añadir al carrito</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm product-card h-100">
                    <img src="https://via.placeholder.com/300x300?text=Guantes+De+Entrenamiento" class="card-img-top" alt="Guantes">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Guantes de Entrenamiento</h5>
                        <p class="text-success fw-bold mb-3">$14.99</p>
                        <button class="btn btn-success mt-auto">Añadir al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

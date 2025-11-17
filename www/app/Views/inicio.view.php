<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutroPro - Tienda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<section class="bg-light text-center py-5">
        <div class="container px-3">
            <h1 class="display-5 display-md-4 fw-bold">Transforma tu cuerpo con NutroPro</h1>
            <p class="lead mb-4">Suplementos, ropa deportiva y todo lo que necesitas para mejorar tu salud y rendimiento.</p>
            <a href="/productos" class="btn btn-success btn-lg">Explora nuestros productos</a>
        </div>
    </section>
<!-- Contenido principal -->
<main class="container my-5">
    <!-- Sección de categorías -->
    <section class="mb-5">
        <h2 class="mb-4 fw-bold text-center">Categorías</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/img_690dac07959206.70283599.png" class="card-img-top" alt="Suplementos">
                    <div class="card-body">
                        <h5 class="card-title">Proteina y creatina</h5>
                        <p class="card-text">Proteínas, creatina y todo lo que necesitas para mejorar tu rendimiento.</p>
                        <a href="/proteina&creatina" class="btn btn-success">Ver productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/nano-banana-2025-10-03T23-20-21.png" class="card-img-top" alt="Ropa de Gimnasio">
                    <div class="card-body">
                        <h5 class="card-title">Ropa de Gimnasio</h5>
                        <p class="card-text">Ropa cómoda y resistente para tus entrenamientos diarios.</p>
                        <a href="/ropa" class="btn btn-success">Ver productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/ChatGPT Image 20 oct 2025, 16_28_16.png" class="card-img-top" alt="Salud y Fitness">
                    <div class="card-body">
                        <h5 class="card-title">Salud & Fitness</h5>
                        <p class="card-text">Accesorios y productos para mejorar tu bienestar integral.</p>
                        <a href="/salud&fitness" class="btn btn-success">Ver productos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de productos destacados -->
    <section class="mb-5">
        <h2 class="mb-4 fw-bold text-center">Productos Destacados</h2>

        <div class="row">
            <?php $hayDestacados = false; ?>

            <?php foreach ($productos as $producto): ?>
                <?php if (!empty($producto['destacado']) && (int)$producto['destacado'] === 1): ?>
                    <?php $hayDestacados = true; ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img
                                    src="<?php echo ($_ENV['IMG_BASE'] ?? '').($producto['imagen_url'] ?? ''); ?>"
                                    class="card-img-top"
                                    alt="<?php echo htmlspecialchars($producto['nombre'] ?? 'Producto'); ?>"
                            >
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2"><?php echo htmlspecialchars($producto['nombre'] ?? ''); ?></h5>
                                <p class="card-text text-success fw-bold mb-3">
                                    <?php echo htmlspecialchars($producto['precio'] ?? ''); ?>€
                                </p>
                                <a href="/productos/<?php echo urlencode($producto['id_producto'] ?? ''); ?>"
                                   class="btn btn-success mt-auto">Ver producto</a>

                                <?php if (!empty($_SESSION['usuario']) && ($_SESSION['usuario']['permisos'] ?? '') === 'rwd'): ?>
                                    <a href="<?php echo ($_ENV['BASE_URL'] ?? ''); ?>productos/destacar/<?php echo urlencode($producto['id_producto'] ?? ''); ?>"
                                       class="btn btn-warning mt-2">
                                        <i class="bi bi-star me-1"></i> Quitar de destacado
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (!$hayDestacados): ?>
                <div class="col-12">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        No hay productos destacados
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-5">
        <h2 class="mb-4 fw-bold text-center">Reseñas de nuestros clientes</h2>

        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if(!empty($resenas)){
                    $chunks = array_chunk($resenas, 3);
                    foreach($chunks as $index => $chunk ){?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="container">
                            <div class="row g-4 justify-content-center">
                                <?php foreach($chunk as $resena ){ ?>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card" style="border: 2px solid #198754; height: 220px ;">
                                        <div class="card-body d-flex flex-column" style="height: 100%;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0"><?php echo $resena['nombre'] ?></h5>
                                                <img class="bg-black rounded-circle" src="<?php echo $_ENV['IMG_BASE']?>logo.png" alt="Logo" style="height: 35px; width: auto;">
                                            </div>
                                            <p class="card-text my-3" style="flex: 1 1 auto;"><?php echo htmlspecialchars($resena['comentario']) ?></p>
                                            <div class="d-flex justify-content-start">
                                                <?php 
                                                for($i = 0; $i < 5; $i++){
                                                    if($i < (int)$resena['valoracion']) {
                                                        echo '<i class="bi bi-star-fill text-warning me-1"></i>';
                                                    } else {
                                                        echo '<i class="bi bi-star text-warning me-1"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                <?php } else { ?>
                    <div class="carousel-item active">
                        <div class="text-center py-4">
                            <p class="text-muted">No hay reseñas disponibles.</p>
                        </div>
                    </div>
                <?php }?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
    </div>

    </section>

    <!-- Sección de beneficios -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">¿Por qué elegir NutroPro?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="bi bi-lightning-charge-fill fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold">Resultados Reales</h5>
                    <p>Productos diseñados científicamente para maximizar tu rendimiento y resultados visibles.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-heart-fill fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold">Salud y Bienestar</h5>
                    <p>Enfocados en mejorar tu salud integral, no solo tu apariencia física.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-truck fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold">Envíos Rápidos</h5>
                    <p>Recibe tus productos en la puerta de tu casa con entregas seguras y eficientes.</p>
                </div>
            </div>
        </div>
    </section>




    <!-- Sección CTA -->
    <section class="py-5 text-center bg-success text-white">
        <div class="container">
            <h2 class="fw-bold mb-4">¿Listo para transformar tu cuerpo?</h2>
            <p class="lead mb-4">Únete a miles de personas que confían en NutroPro para alcanzar sus metas.</p>
            <a href="<?php echo $_ENV['host.folder'].(isset($_SESSION['usuario']) ? 'productos' : 'login' ) ?>" class="btn btn-light btn-lg">Comienza hoy</a>
        </div>
    </section>
    

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

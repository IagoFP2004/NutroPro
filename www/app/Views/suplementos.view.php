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

<!-- ====== Descripción de productos ====== -->
<section class="container mt-5 mb-4 text-center">
    <h1 class="fw-bold text-success mb-3">SUPLEMENTOS</h1>
    <p class="lead text-muted mx-auto" style="max-width: 800px;">
        Descubre nuestra selección de suplementos diseñados para ayudarte a alcanzar tus metas de rendimiento y bienestar.
        En NutroPro encontrarás proteínas, creatinas y productos de nutrición deportiva de alta calidad,
        cuidadosamente seleccionados para brindarte los mejores resultados.
    </p>
</section>

<!-- Contenido principal -->
<main class="container mb-5 align-items-center pb-5">

    <!-- CATEGORÍA 1: Proteína & Creatina -->
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Proteinas</h2>
        <div class="row g-4">
            <?php foreach ($proteinas as $proteina) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $_ENV['IMG_BASE'].$proteina['imagen_url']; ?>" class="card-img-top" alt="Proteína Whey">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $proteina['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $proteina['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <a href="<?php echo $_ENV['BASE_URL'] ?>productos/<?php echo $proteina['id_producto'] ?>" class="btn btn-success">Ver producto</a>
                                <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] === 'rwd'){ ?>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/editar/<?php echo $proteina['id_producto'] ?>" class="btn btn-primary">
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/destacar/<?php echo $proteina['id_producto'] ?>" class="btn btn-warning">
                                        <i class="bi bi-star me-1"></i> <?= ($proteina['destacado'] == 1) ? 'Quitar de destacados' : 'Destacar producto' ?>
                                    </a>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/delete/<?php echo $proteina['id_producto'] ?>" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Eliminar producto
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <section class="mb-5">
        <h2 class="fw-bold mb-4 text-success text-center">Creatinas</h2>
        <div class="row g-4">
            <?php foreach ($creatinas as $creatina) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm product-card h-100">
                        <img src="<?php echo $_ENV['IMG_BASE'].$creatina['imagen_url']; ?>" class="card-img-top" alt="Proteína Whey">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $creatina['nombre']; ?></h5>
                            <p class="text-success fw-bold mb-3"><?php echo $creatina['precio']; ?>€</p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <a href="<?php echo $_ENV['BASE_URL'] ?>productos/<?php echo $creatina['id_producto'] ?>" class="btn btn-success">Ver producto</a>
                                <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] === 'rwd'){ ?>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/editar/<?php echo $creatina['id_producto'] ?>" class="btn btn-primary">
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/destacar/<?php echo $creatina['id_producto'] ?>" class="btn btn-warning">
                                        <i class="bi bi-star me-1"></i> <?= ($creatina['destacado'] == 1) ? 'Quitar de destacados' : 'Destacar producto' ?>
                                    </a>
                                    <a href="<?php echo $_ENV['BASE_URL']?>productos/delete/<?php echo $creatina['id_producto'] ?>" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Eliminar producto
                                    </a>
                                <?php }?>
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

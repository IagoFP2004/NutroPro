<!-- productos.view.php (versión mínima, sin lógica) -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos — NutroPro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<main class="container my-5">
  <h1 class="h3 fw-bold mb-4 text-center">Todos los productos</h1>

  <div class="row g-4">
    <?php foreach ($productos as $p): ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?php echo $p['imagen_url']; ?>" class="card-img-top" alt="<?php echo $p['nombre']; ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-1"><?php echo $p['nombre']; ?></h5>
            <p class="card-text mb-3"><?php echo $p['descripcion']; ?></p>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="fw-bold text-success"><?php echo $p['precio']; ?> €</span>
              <span class="text-muted">Stock: <?php echo $p['stock']; ?></span>
            </div>
            <div class="mt-auto d-flex gap-2">
              <a href="producto.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-secondary w-50">
                <i class="bi bi-eye me-1"></i> Ver
              </a>
              <form action="carrito.php" method="post" class="w-50">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                <button class="btn btn-success w-100" type="submit">
                  <i class="bi bi-cart-plus me-1"></i> Añadir
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

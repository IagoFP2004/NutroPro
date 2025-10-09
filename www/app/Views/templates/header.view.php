<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NutroPro</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3 px-lg-5">
    <div class="container-fluid">

      <!-- ====== MÓVIL ====== -->
      <div class="d-flex d-lg-none w-100 align-items-center justify-content-between py-1">
        <!-- Logo a la izquierda -->
        <a class="navbar-brand fw-bold text-white" href="#">NutroPro</a>

        <!-- Iconos + hamburguesa a la derecha -->
        <div class="d-flex align-items-center ms-auto">
          <!-- Carrito -->
          <a class="nav-link text-white position-relative me-2" href="#carrito" aria-label="Carrito">
            <i class="bi bi-cart3 fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
          </a>
          <!-- Usuario -->
          <a class="nav-link text-white me-2" href="#login" title="Iniciar sesión">
            <i class="bi bi-person-circle fs-5"></i>
          </a>
          <!-- Hamburguesa -->
          <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>

      <!-- ====== ESCRITORIO ====== -->
      <div class="d-none d-lg-flex w-100 align-items-center justify-content-between">
        <!-- Logo separado del borde -->
        <a class="navbar-brand fw-bold text-white ms-4" href="#">NutroPro</a>

        <!-- Menú -->
        <div class="collapse navbar-collapse show">
          <ul class="navbar-nav ms-auto me-4">
            <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Sulpementos</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Ropa de Gimnasio</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Salud&Fitness</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Sobre Nosotros</a></li>
          </ul>
        </div>

        <!-- Iconos separados del borde derecho -->
        <div class="d-flex align-items-center gap-3 me-4">
          <a class="nav-link position-relative text-white" href="#carrito">
            <i class="bi bi-cart3 fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
          </a>
          <a class="nav-link text-white" href="#login">
            <i class="bi bi-person-circle fs-5"></i>
          </a>
        </div>
      </div>

      <!-- ====== MENÚ COLAPSABLE (solo móvil) ====== -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto d-lg-none text-center">
          <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Suplementos</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Ropa de Gimnasio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Salud&Fitness</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Sobre Nosotros</a></li>
        </ul>
      </div>

    </div>
  </nav>
</header>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Cerrar menú automáticamente en móvil
  document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      const navbarCollapse = document.getElementById('navbarNav');
      if (navbarCollapse.classList.contains('show')) {
        new bootstrap.Collapse(navbarCollapse).toggle();
      }
    });
  });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>NutroPro</title>
    <link rel="icon" type="image" href="<?php echo $_ENV['IMG_BASE'] ?>logo.png">
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
          <div class="d-flex align-items-center">
              <img src="<?php echo $_ENV['IMG_BASE']?>logo.png" alt="Logo" style="height: 40px; width: auto;">
              <a class="navbar-brand fw-bold text-white ms-2" href="/">NutroPro</a>
          </div>


          <!-- Iconos + hamburguesa a la derecha -->
        <div class="d-flex align-items-center ms-auto">
          <!-- Carrito -->
          <a class="nav-link text-white position-relative me-2" href="/carrito" aria-label="Carrito">
            <i class="bi bi-cart3 fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?php echo isset($_SESSION['carrito_count']) ? $_SESSION['carrito_count'] : 0; ?>
            </span>
          </a>
          <!-- Usuario -->
          <a class="nav-link text-white me-2" href="/login" title="Iniciar sesión">
              <?php if (isset($_SESSION['usuario'])) { ?>
                  <i class="bi bi-box-arrow-right"></i>
              <?php }else{?>
            <i class="bi bi-person-circle fs-5"></i>
              <?php }?>
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
          <div class="d-flex align-items-center">
              <img src="<?php echo $_ENV['IMG_BASE']?>logo.png" alt="Logo" style="height: 40px; width: auto;">
              <a class="navbar-brand fw-bold text-white ms-2" href="/">NutroPro</a>
          </div>


          <!-- Menú -->
        <div class="collapse navbar-collapse show">
          <ul class="navbar-nav ms-auto me-4">
              <li class="nav-item"><a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>" href="/">Inicio</a></li>
              <li class="nav-item"><a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'productos' ? 'active' : ''; ?>" href="/productos">Productos</a></li>
            <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'proteina&creatina' ? 'active' : ''; ?> " href="/proteina&creatina">Proteina & Creatina</a></li>
            <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'ropa' ? 'active' : ''; ?>" href="/ropa">Ropa</a></li>
            <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'salud&fitness' ? 'active' : ''; ?>" href="/salud&fitness">Salud & Fitness</a></li>
            <?php if (isset($_SESSION['usuario'])) { ?>
              <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'micuenta' ? 'active' : ''; ?>" href="/micuenta/<?php echo $_SESSION['usuario']['id_usuario'] ?>">Mi cuenta</a></li>
            <?php } ?>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] == 'rwd' ){ ?>
              <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'gestionUsuarios' ? 'active' : ''; ?>" href="/gestionUsuarios">Administrar usuarios</a></li>
            <?php } ?>
          </ul>
        </div>
        <?php if (isset($_SESSION['usuario'])){ ?>
        <div class="d-flex align-items-center gap-3 me-4">
          <a class="nav-link position-relative text-white" href="/carrito">
            <i class="bi bi-cart3 fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?php echo isset($_SESSION['carrito_count']) ? $_SESSION['carrito_count'] : 0; ?>
            </span>
          </a>
            <?php }?>
            <a class="nav-link text-white me-2" href="<?php echo isset($_SESSION['usuario']) ? '/logout' : '/login'; ?>" title="Iniciar sesión">
                <?php if (isset($_SESSION['usuario'])) { ?>
                    <i class="bi bi-box-arrow-right"></i>
                <?php }else{?>
                    <i class="bi bi-person-circle fs-5"></i>
                <?php }?>
            </a>
        </div>
      </div>

      <!-- ====== MENÚ COLAPSABLE (solo móvil) ====== -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto d-lg-none text-center">
          <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="/productos">Productos</a></li>
          <li class="nav-item"><a class="nav-link" href="/proteina&creatina">Proteina & Creatina</a></li>
          <li class="nav-item"><a class="nav-link" href="/ropa">Ropa</a></li>
          <li class="nav-item"><a class="nav-link" href="/salud&fitness">Salud & Fitness</a></li>
          <li class="nav-item"><a class="nav-link" href="/micuenta/<?php echo $_SESSION['usuario']['id_usuario'] ?>">Mi cuenta</a></li>
          <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] == 'rwd' ){ ?>
            <li class="nav-item"><a class="nav-link   <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'gestionUsuarios' ? 'active' : ''; ?>" href="/gestionUsuarios">Administrar usuarios</a></li>
          <?php } ?>
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

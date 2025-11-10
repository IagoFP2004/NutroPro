</body>
<footer class="bg-dark text-white text-center py-4">
  <div class="container pb-5">
    <div class="d-flex align-items-center justify-content-center mb-3">
              <img src="<?php echo $_ENV['IMG_BASE']?>logo.png" alt="Logo" style="height: 40px; width: auto;">
              <a>NutroPro</a>
     </div>
    <p class="mb-1">
      &copy; <?php echo date('Y'); ?> <strong>NutroPro</strong>. Todos los derechos reservados.
    </p>
    <small>
      Síguenos en
      <a href="#" class="text-success text-decoration-none ms-1"><i class="bi bi-instagram"></i></a>
      <a href="#" class="text-success text-decoration-none ms-1"><i class="bi bi-facebook"></i></a>
      <a href="#" class="text-success text-decoration-none ms-1"><i class="bi bi-twitter-x"></i></a>
    </small>
  </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navbarNav = document.getElementById('navbarNav');
    const navLinks = document.querySelectorAll('#navbarNav .nav-link');
    
    if (menuToggle && navbarNav) {
      // Toggle del menú
      menuToggle.addEventListener('click', function() {
        const isExpanded = navbarNav.classList.contains('show');
        
        if (isExpanded) {
          navbarNav.classList.remove('show');
          menuToggle.setAttribute('aria-expanded', 'false');
        } else {
          navbarNav.classList.add('show');
          menuToggle.setAttribute('aria-expanded', 'true');
        }
      });
      
      // Cerrar menú al hacer clic en enlaces
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (navbarNav.classList.contains('show')) {
            navbarNav.classList.remove('show');
            menuToggle.setAttribute('aria-expanded', 'false');
          }
        });
      });
    }
  });
</script>
</html>

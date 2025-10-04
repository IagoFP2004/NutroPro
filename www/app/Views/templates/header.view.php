<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutroPro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Cabecera -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="#">NutroPro</a>

            <!-- Botón hamburguesa responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Enlaces de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Proteina & Creatina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ropa de Gimnasio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Suplementos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="bg-light text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Transforma tu cuerpo con NutroPro</h1>
            <p class="lead mb-4">Suplementos, ropa deportiva y todo lo que necesitas para mejorar tu salud y rendimiento.</p>
            <a href="#" class="btn btn-success btn-lg">Explora nuestros productos</a>
        </div>
    </div>
</header>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Cerrar menú automáticamente al hacer clic en un enlace -->
<script>
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

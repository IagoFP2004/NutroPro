<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NutroPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <i class="bi bi-person-circle text-success" style="font-size: 3rem;"></i>
            <h3 class="mt-2 text-success fw-bold">Iniciar sesión</h3>
        </div>

        <form action="/login" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="nombre@correo.com" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>

            <?php if (!empty($msjErr)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($msjErr); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($msjE)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($msjE); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">Entrar</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-0">¿No tienes cuenta?</p>
            <a href="/register" class="text-success fw-semibold text-decoration-none">Regístrate aquí</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

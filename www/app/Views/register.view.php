<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - NutroPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <i class="bi bi-person-plus text-success" style="font-size: 3rem;"></i>
            <h3 class="mt-2 text-success fw-bold">Crear cuenta</h3>
        </div>

        <form action="/register" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Laura Pérez" value="<?php echo $input['nombre'] ?? '' ?>" required>
                <p class="text-danger"><?php echo $errores['nombre'] ?? '' ?></p>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="nombre@correo.com" value="<?php echo $input['email'] ?? '' ?>" required>
                <p class="text-danger"><?php echo $errores['email'] ?? '' ?></p>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle Principal 123" value="<?php echo $input['direccion'] ?? '' ?>" required>
                <p class="text-danger"><?php echo $errores['direccion'] ?? '' ?></p>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 600-12-34-56" value="<?php echo $input['telefono'] ?? '' ?>" required>
                <p class="text-danger"><?php echo $errores['telefono'] ?? '' ?></p>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                <p class="text-danger"><?php echo $errores['password'] ?? '' ?></p>
            </div>

            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Repite tu contraseña" required>
                <p class="text-danger"><?php echo $errores['confirm-password'] ?? '' ?></p>
            </div>
            
            <?php if (!empty($msjErr)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msjErr; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($msjE)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $msjE; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-0">¿Ya tienes una cuenta?</p>
            <a href="/login" class="text-success fw-semibold text-decoration-none">Inicia sesión aquí</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

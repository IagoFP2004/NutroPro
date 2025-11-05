<main role="main" class="mb-5">
    <div class="p-4 p-md-5 bg-white">
        <div class="text-success fs-3 mb-4">
            <i class="bi bi-person"></i>Gestión de usuarios
        </div>
        <p class="mb-5 mt-5">Listado de todos los usuarios registrados en el sistema. Los usuarios con rol de administrador están resaltados en verde.</p>
        <span class="bg-success fs-6 px-2 py-2 text-white rounded mb-3 d-inline-block">
            Total de usuarios: <?php echo count($usuarios); ?>
        </span>

        <div class="table-responsive mb-5">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr <?php if ($usuario['id_rol'] == 1) echo 'class="table-success"'; ?>>
                            <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                            <td>
                                <a href="#" target="_blank" class="btn btn-success ml-1 mb-2"><i class="bi bi-eye"></i></a>
                                <a href="#" target="_blank" class="btn btn-danger ml-1 mb-2"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mb-5 d-flex justify-content-between align-items-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                        </li>
                    </ul>
                </nav>
                <a href="#" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Usuario
                </a>
            </div>
        </div>
        <section class="bg-light rounded p-4 mb-3">
            <h5 class="text-success mb-3"><i class="bi bi-graph-up-arrow"></i> Resumen de usuarios</h5>
            <div class="row text-center g-3 justify-content-center">
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-success"><?= count($usuarios) ?></div>
                    <div class="small text-muted">Total registrados</div>
                </div>
                </div>
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-primary">
                    <?= $totalAdmins ?? 5 ?> <!-- ejemplo, reemplázalo -->
                    </div>
                    <div class="small text-muted">Administradores</div>
                </div>
                </div>
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-warning">
                        10
                    </div>
                    <div class="small text-muted">Usuarios estándar</div>
                </div>
                </div>
            </div>
        </section>
    </div> 
</main> 
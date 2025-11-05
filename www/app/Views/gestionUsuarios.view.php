<main role="main" class="mb-5">
    <div class="p-4 p-md-5 bg-white">
        <div class="text-success fs-3 mb-4">
            <i class="bi bi-person"></i>Gestión de usuarios
        </div>
        <p class="mb-5 mt-5">Listado de todos los usuarios registrados en el sistema. Los usuarios con rol de administrador están resaltados en verde.</p>
        <span class="bg-success fs-6 px-2 py-2 text-white rounded mb-3 d-inline-block">
            Total de usuarios: <?php echo count($usuarios); ?>
        </span>

        <div id="contenedor" class="table-responsive mb-5">
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
                        <tr class="<?php echo ($usuario['id_rol'] == 1) ? 'table-success' : (($usuario['id_usuario'] % 2 == 0) ? 'table-secondary' : ''); ?>">
                            <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                            <td>
                                <a href="/micuenta/<?php echo $usuario['id_usuario'] ?>" class="btn btn-success ml-1 mb-2"><i class="bi bi-eye"></i></a>
                                <a href="/gestionUsuarios/delete/<?php echo $usuario['id_usuario'] ?>" class="btn btn-danger ml-1 mb-2"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mb-5 d-flex justify-content-between align-items-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($page > 1){ ?>
                        <li class="page-item">
                        <a class="page-link bg-success text-white" href="<?php echo $_ENV['host.folder'].'gestionUsuarios?'.$url.'&page=1' ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        </li>

                        <li class="page-item">
                        <a class="page-link bg-success text-white" href="<?php echo $_ENV['host.folder'].'gestionUsuarios?'.$url.'&page='.($page -1)?>" aria-label="Next">
                            <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span>
                        </a>
                        </li>
                        <?php }?>
                        <li class="page-item "><a class="page-link bg-success text-white" href="#"><?php echo $page ?></a></li>
                        <?php if($page < $max_page){ ?>
                        <li class="page-item">
                        <a class="page-link bg-success text-white" href="<?php echo $_ENV['host.folder'].'gestionUsuarios?'.$url.'&page='.($page +1)?>" aria-label="Next">
                            <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                        </li>
                        
                        <li class="page-item">
                        <a class="page-link bg-success text-white" href="<?php echo $_ENV['host.folder'].'gestionUsuarios?'.$url.'&page='.$max_page?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                        </li>
                        <?php }?>
                    </ul>
                </nav>
                <button class="btn btn-success me-3" id="agregarUsuario">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Usuario
                </button>
            </div>
        </div>
        <section class="bg-light rounded p-4 mb-3">
            <h5 class="text-success mb-3 d-flex justify-content-center"><i class="bi bi-graph-up-arrow"></i> Resumen de usuarios</h5>
            <div class="row text-center g-3 justify-content-center">
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-success"><?= count($usersNum) ?></div>
                    <div class="small text-muted">Total registrados</div>
                </div>
                </div>
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-primary">
                    <?php 
                    $adminCount = 0; 
                    foreach($usersNum as $user){
                        if($user['id_rol'] == 1){
                            $adminCount++;
                        }
                    }
                    echo $adminCount;
                    ?>
                    </div>
                    <div class="small text-muted">Administradores</div>
                </div>
                </div>
                <div class="col-6 col-md-3">
                <div class="bg-white border rounded p-3 shadow-sm">
                    <div class="fs-4 fw-bold text-warning">
                        <?php 
                        $normalUsersCount = 0; 
                        foreach($usersNum as $user){
                            if($user['id_rol'] == 0){
                                $normalUsersCount++;
                            }
                        }
                        echo $normalUsersCount;
                        ?>
                    </div>
                    <div class="small text-muted">Usuarios estándar</div>
                </div>
                </div>
            </div>
        </section>
    </div> 
</main> 
<script src='/assets/js/formUsers.js'></script>
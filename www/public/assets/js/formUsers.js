document.addEventListener('DOMContentLoaded', function() {
    var boton = document.getElementById('agregarUsuario');
    var contenedorInsert = document.getElementById('contenedor');

    boton.addEventListener('click', () => {
        let formPanel = document.createElement('div');
        formPanel.className = 'container mt-4 mb-4';
        formPanel.id = 'formAgregarUsuario';
        formPanel.innerHTML = `
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Nuevo Usuario
                            </h5>
                            <div class="row g-3 mt-2 d-flex align-items-center"> 
                                <div class="col-md-4">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Agregar Nombre...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Agregar Email...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Agregar Dirección...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Agregar Teléfono...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirmar Contraseña...">
                                </div>
                                <div class="col-md-4 form-check form-switch pt-5">
                                    <input class="form-check-input" type="checkbox" id="admin">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Admin</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-success" id="btnCrearUsuario">
                                    <i class="bi bi-plus-circle me-1"></i>Crear Usuario
                                </button>
                            </div>
                            <div id="mensajeUsuario" class="mt-3"></div>
                        </div>
                    </div>
                `;
        contenedorInsert.appendChild(formPanel);

        // Añadir event listener al botón después de insertarlo
        document.getElementById('btnCrearUsuario').addEventListener('click', async function(e) {
            e.preventDefault();
            // Recoger datos
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const direccion = document.getElementById('direccion').value;
            const telefono = document.getElementById('telefono').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const esAdmin = document.getElementById('admin').checked;

            // Construir datos para POST
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('email', email);
            formData.append('direccion', direccion);
            formData.append('telefono', telefono);
            formData.append('password', password);
            formData.append('confirm-password', confirmPassword);
            if (esAdmin) formData.append('admin', '1');

            try {
                const response = await fetch('/gestionUsuarios', {
                    method: 'POST',
                    body: formData
                });
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    const html = await response.text();
                    document.getElementById('mensajeUsuario').innerHTML = '<div class="alert alert-danger">No se pudo crear el usuario. Revisa los datos.</div>';
                }
            } catch (error) {
                document.getElementById('mensajeUsuario').innerHTML = '<div class="alert alert-danger">Error de red o servidor.</div>';
            }
        });

        //Boton para cerrar el formulario
         boton.innerHTML = '<i class="bi bi-x-lg me-1"></i> Cerrar Filtros';
            boton.onclick = () => {
                formPanel.remove();
                boton.innerHTML = '<i class="bi bi-filter me-1"></i> Filtros';
                boton.onclick = null;
                location.reload();
            };
    }) 
});
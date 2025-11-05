document.addEventListener('DOMContentLoaded', function() {
    const boton = document.getElementById("filtros");
    const contenedor = document.getElementById("contenedorMain");

    if (boton && contenedor) {
        boton.addEventListener('click', () => {
            // Crear panel de filtros
            let filtrosPanel = document.createElement("div");
            filtrosPanel.className = "container mt-4 mb-4";
            filtrosPanel.id = "panelFiltros";
            filtrosPanel.innerHTML = `
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="bi bi-funnel me-2"></i>Filtros de productos
                        </h5>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" id="filtroCategoria">
                                    <option value="">Todas</option>
                                    <option value="1">Proteínas & Creatina</option>
                                    <option value="2">Suplementos</option>
                                    <option value="3">Snacks</option>
                                    <option value="4">Ropa</option>
                                    <option value="5">Accesorios</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Precio</label>
                                <select class="form-select" id="filtroPrecio">
                                    <option value="">Todos</option>
                                    <option value="0-20">0€ - 20€</option>
                                    <option value="20-40">20€ - 40€</option>
                                    <option value="40+">Más de 40€</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Búsqueda</label>
                                <input type="text" class="form-control" id="filtroBusqueda" placeholder="Buscar producto...">
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-success" onclick="aplicarFiltros()">
                                <i class="bi bi-check-lg me-1"></i>Aplicar filtros
                            </button>
                            <button class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                                <i class="bi bi-x-lg me-1"></i>Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            // Insertar el panel antes del contenedor principal
            contenedor.parentNode.insertBefore(filtrosPanel, contenedor);
            
            // Cambiar el botón para ocultar filtros
            boton.innerHTML = '<i class="bi bi-x-lg me-1"></i> Cerrar Filtros';
            boton.onclick = () => {
                filtrosPanel.remove();
                boton.innerHTML = '<i class="bi bi-filter me-1"></i> Filtros';
                boton.onclick = null;
                location.reload(); // Recargar para restaurar el event listener
            };
        });
    }
});

function aplicarFiltros() {
    const categoria = document.getElementById('filtroCategoria').value;
    const precio = document.getElementById('filtroPrecio').value;
    const busqueda = document.getElementById('filtroBusqueda').value.trim();
    
    // Construir la URL con los parámetros
    const params = new URLSearchParams();
    
    if (categoria) {
        params.append('categoria', categoria);
    }
    if (precio) {
        params.append('precio', precio);
    }
    if (busqueda) {
        params.append('busqueda', busqueda);
    }
    
    // Redirigir a la página con los filtros
    const queryString = params.toString();
    window.location.href = '/productos' + (queryString ? '?' + queryString : '');
}

function limpiarFiltros() {
    window.location.href = '/productos';
}
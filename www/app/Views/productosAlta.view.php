<div class="container py-5 min-vh-100 d-flex flex-column justify-content-center">

    <!-- ENCABEZADO -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 70px; height: 70px;">
            <i class="bi bi-box-seam fs-1"></i>
        </div>
        <h1 class="fw-bold text-success mb-2">Nuevo producto</h1>
        <p class="text-muted">Completa los detalles para añadir un nuevo producto a la tienda.</p>
    </div>

    <!-- FORMULARIO -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <form action="/productos/nuevo" method="post" enctype="multipart/form-data" class="bg-white border rounded-4 shadow-sm p-4 p-md-5">

                <div class="row g-4">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre del producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Creatina Monohidratada" value="<?php echo $input['nombre'] ?? '' ?>" required>
                    </div>

                    <!-- Precio -->
                    <div class="col-md-3">
                        <label for="precio" class="form-label fw-semibold">Precio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="15.99" required>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-3">
                        <label for="stock" class="form-label fw-semibold">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="100" required>
                    </div>

                    <!-- Descripción -->
                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe brevemente el producto..." required></textarea>
                    </div>

                    <!-- Categoría -->
                    <div class="col-md-6">
                        <label for="categoria" class="form-label fw-semibold">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nombre'] ?></option>
                            <?php }?>
                        </select>
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label fw-semibold">Imagen del producto</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="/productos" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Guardar producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

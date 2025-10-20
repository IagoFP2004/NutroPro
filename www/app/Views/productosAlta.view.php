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
                        <p class="text-danger"><?php echo $errors['nombre'] ?? ''?></p>
                    </div>

                    <!-- Precio -->
                    <div class="col-md-3">
                        <label for="precio" class="form-label fw-semibold">Precio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="15.99" value="<?php echo $input['precio'] ?? '' ?>" required>
                        <p class="text-danger"><?php echo $errors['precio'] ?? ''?></p>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-3">
                        <label for="stock" class="form-label fw-semibold">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="100" value="<?php echo $input['stock'] ?? '' ?>" required>
                        <p class="text-danger"><?php echo $errors['stock'] ?? ''?></p>
                    </div>

                    <!-- Descripción -->
                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe brevemente el producto..."  required></textarea>
                        <p class="text-danger"><?php echo $errors['descripcion'] ?? ''?></p>
                    </div>

                    <!-- Categoría -->
                    <div class="col-md-6">
                        <label for="categoria" class="form-label fw-semibold">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <?php foreach ($categorias as $categoria) { ?>
                                <option
                                        value="<?php echo $categoria['id_categoria']; ?>"
                                        <?php echo (isset($input['categoria']) && $input['categoria'] == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                                    <?php echo $categoria['nombre']; ?>
                                </option>

                            <?php }?>
                        </select>
                        <p class="text-danger"><?php echo $errors['categoria'] ?? ''?></p>
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-6">
                        <label for="imagen" class="form-label fw-semibold">Imagen del producto</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" value="<?php echo $input['imagen'] ?? '' ?>" required>
                        <p class="text-danger"><?php echo $errors['imagen'] ?? ''?></p>
                    </div>

                    <!-- Nutrientes (solo visibles para categorías 1, 2, 3) -->
                    <div id="divNutrientes" class="row g-4 mt-3" style="display: none;">
                        <div class="col-md-4">
                            <label for="proteinas" class="form-label fw-semibold">Proteínas (g)</label>
                            <input type="number" class="form-control" id="proteinas" name="proteinas" min="0" placeholder="20" value="<?php echo $input['proteinas'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['proteinas'] ?? ''?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="carbohidratos" class="form-label fw-semibold">Carbohidratos (g)</label>
                            <input type="number" class="form-control" id="carbohidratos" name="carbohidratos" min="0" placeholder="10" value="<?php echo $input['carbohidratos'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['carbohidratos'] ?? ''?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="grasas" class="form-label fw-semibold">Grasas (g)</label>
                            <input type="number" class="form-control" id="grasas" name="grasas" min="0" placeholder="5" value="<?php echo $input['grasas'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['grasas'] ?? ''?></p>
                        </div>
                    </div>

                    <!-- Atributos de Ropa (solo visibles para categoría 4) -->
                    <div id="divRopa" class="row g-4 mt-3" style="display: none;">
                        <div class="col-md-4">
                            <label for="talla" class="form-label fw-semibold">Talla</label>
                            <input type="text" class="form-control" id="talla" name="talla" placeholder="Ej: M, L, XL" value="<?php echo $input['talla'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['talla'] ?? ''?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="color" class="form-label fw-semibold">Color</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="Ej: Negro, Azul" value="<?php echo $input['color'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['color'] ?? ''?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="material" class="form-label fw-semibold">Material</label>
                            <input type="text" class="form-control" id="material" name="material" placeholder="Ej: Algodón, Poliéster" value="<?php echo $input['material'] ?? '' ?>">
                            <p class="text-danger"><?php echo $errors['material'] ?? ''?></p>
                        </div>
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

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const categoriaSelect = document.getElementById('categoria');
                        const divNutrientes = document.getElementById('divNutrientes');
                        const divRopa = document.getElementById('divRopa');

                        function toggleCampos() {
                            const categoria = parseInt(categoriaSelect.value);
                            
                            // Mostrar/ocultar nutrientes (categorías 1, 2, 3)
                            if ([1, 2, 3].includes(categoria)) {
                                divNutrientes.style.display = 'flex';
                                divRopa.style.display = 'none';
                                // Limpiar campos de ropa
                                document.getElementById('talla').value = '';
                                document.getElementById('color').value = '';
                                document.getElementById('material').value = '';
                            } 
                            // Mostrar/ocultar campos de ropa (categoría 4)
                            else if (categoria === 4) {
                                divNutrientes.style.display = 'none';
                                divRopa.style.display = 'flex';
                                // Limpiar campos de nutrientes
                                document.getElementById('proteinas').value = '';
                                document.getElementById('carbohidratos').value = '';
                                document.getElementById('grasas').value = '';
                            } 
                            // Ocultar ambos para otras categorías
                            else {
                                divNutrientes.style.display = 'none';
                                divRopa.style.display = 'none';
                                // Limpiar todos los campos
                                document.getElementById('proteinas').value = '';
                                document.getElementById('carbohidratos').value = '';
                                document.getElementById('grasas').value = '';
                                document.getElementById('talla').value = '';
                                document.getElementById('color').value = '';
                                document.getElementById('material').value = '';
                            }
                        }
                        categoriaSelect.addEventListener('change', toggleCampos);
                        toggleCampos();
                    });
                </script>

            </form>
        </div>
    </div>
</div>

<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductoModel;

class   ProductoController extends BaseController
{
    public function showProductsView(): void
    {
        $modelo = new ProductoModel();

        $filtros = [
            'categoria' => filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '',
            'precio' => filter_input(INPUT_GET, 'precio', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '',
            'busqueda' => filter_input(INPUT_GET, 'busqueda', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? ''
        ];

        $hayFiltros = !empty($filtros['categoria']) || !empty($filtros['precio']) || !empty($filtros['busqueda']);

        if ($hayFiltros) {
            $productosFiltrados = $modelo->getProductosFiltrados($filtros);
            $data['proteinas'] = $productosFiltrados['proteinas'];
            $data['ropas'] = $productosFiltrados['ropas'];
            $data['suplementos'] = $productosFiltrados['suplementos'];
            $data['accesorios'] = $productosFiltrados['accesorios'];
            $data['snacks'] = $productosFiltrados['snacks'];
        } else {
            $data['proteinas'] = $modelo->getProductosProteinasCreatina();
            $data['ropas'] = $modelo->getProductosRopa();
            $data['suplementos'] = $modelo->getProductosSuplementos();
            $data['accesorios'] = $modelo->getProductosAccesorios();
            $data['snacks'] = $modelo->getProductosSnacks();
        }

        $data['filtros'] = $filtros;
        $data['hayFiltros'] = $hayFiltros;

        if (isset($_SESSION['msjE'])) {
            $data['msjE'] = $_SESSION['msjE'];
            unset($_SESSION['msjE']);
        }
        if (isset($_SESSION['msjErr'])) {
            $data['msjErr'] = $_SESSION['msjErr'];
            unset($_SESSION['msjErr']);
        }
        $this->view->showViews(array('templates/header.view.php', 'productos.view.php','templates/footer.view.php'), $data);
    }

    public function showDetailsView(int $id): void
    {
        $modelo = new ProductoModel();
        $producto = $modelo->getProductoById($id);
        $data['producto'] = $producto;
        // Forzamos la conversión a int del id_categoria
        $data['productosVendidos'] = $modelo->getProductosRelacionados($id, (int)$producto['id_categoria']);

        $this->view->showViews(array('templates/header.view.php', 'productoDetalle.view.php','templates/footer.view.php'), $data);
    }

    public function showAltaProductsView(): void
    {
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();
        $this->view->showViews(array('templates/header.view.php', 'productosAlta.view.php','templates/footer.view.php'), $data);
    }

    public function showEditView(int $id): void
    {
        $productoModel = new ProductoModel();
        $producto = $productoModel->getProductoById($id);
        
        if (!$producto) {
            $_SESSION['msjErr'] = "Producto no encontrado";
            header("Location: /productos");
            exit;
        }
        
        // Pasar los datos del producto a la vista
        $data['producto'] = $producto;
        $data['modo'] = 'editar'; // Indicar que estamos en modo edición
        $data['input'] = [
            'nombre' => $producto['nombre'],
            'descripcion' => $producto['descripcion'],
            'precio' => $producto['precio'],
            'stock' => $producto['stock'],
            'categoria' => $producto['id_categoria'],
            'proteinas' => $producto['proteinas'] ?? '',
            'carbohidratos' => $producto['carbohidratos'] ?? '',
            'grasas' => $producto['grasas'] ?? '',
            'talla' => $producto['talla'] ?? '',
            'color' => $producto['color'] ?? '',
            'material' => $producto['material'] ?? ''
        ];
        
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();
        
        $this->view->showViews(array('templates/header.view.php', 'productosAlta.view.php','templates/footer.view.php'), $data);
    }

    public function showSuplements(): void
    {
        $modelo = new ProductoModel();

        $data['proteinas'] = $modelo->getProductosProteinas();
        $data['creatinas'] = $modelo->getProductosCreatina();

        if (isset($_SESSION['msjE'])) {
            $data['msjE'] = $_SESSION['msjE'];
            unset($_SESSION['msjE']);
        }
        if (isset($_SESSION['msjErr'])) {
            $data['msjErr'] = $_SESSION['msjErr'];
            unset($_SESSION['msjErr']);
        }
        $this->view->showViews(array('templates/header.view.php', 'suplementos.view.php','templates/footer.view.php'), $data);
    }

    public function showClothes(): void
    {
        $modelo = new ProductoModel();

        $data['ropas'] = $modelo->getProductosRopa();

        if (isset($_SESSION['msjE'])) {
            $data['msjE'] = $_SESSION['msjE'];
            unset($_SESSION['msjE']);
        }
        if (isset($_SESSION['msjErr'])) {
            $data['msjErr'] = $_SESSION['msjErr'];
            unset($_SESSION['msjErr']);
        }
        $this->view->showViews(array('templates/header.view.php', 'ropa.view.php','templates/footer.view.php'), $data);
    }

    public function showSaludFitness(): void
    {
        $modelo = new ProductoModel();

        $data['suplementos'] = $modelo->getProductosSuplementos();
        $data['accesorios'] = $modelo->getProductosAccesorios();
        $data['snacks'] = $modelo->getProductosSnacks();

        if (isset($_SESSION['msjE'])) {
            $data['msjE'] = $_SESSION['msjE'];
            unset($_SESSION['msjE']);
        }
        if (isset($_SESSION['msjErr'])) {
            $data['msjErr'] = $_SESSION['msjErr'];
            unset($_SESSION['msjErr']);
        }
        $this->view->showViews(array('templates/header.view.php', 'saludFitness.view.php','templates/footer.view.php'), $data);
    }

    public function insertProducts(): void
    {
        $categoriaModel = new CategoriaModel();
        $errors = $this->checkData($_POST, $_FILES, true);

        if (empty($errors)) {
            // ====== Subir imagen ======
            $publicPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
            $uploadDir  = $publicPath . '/assets/img/';

            // Crear la carpeta si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            // Procesar la imagen si se subió correctamente
            if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $filename = uniqid('img_', true) . '.' . $ext;

                // Mover la imagen al directorio final
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                    $_SESSION['msjErr'] = "Error al guardar la imagen (verifica permisos de la carpeta)";
                    header("Location: /productos");
                    exit;
                }

                // Solo guardamos el nombre del archivo (sin la ruta completa)
                // porque en la vista se concatena con IMG_BASE
                $_POST['imagen_url'] = $filename;
            } else {
                $_SESSION['msjErr'] = "No se seleccionó ninguna imagen o hubo un error en la subida";
                header("Location: /productos");
                exit;
            }

            // ====== Insertar producto ======
            $modelo = new ProductoModel();
            $insert = $modelo->insert($_POST);

            if ($insert !== false) {
                $_SESSION['msjE'] = "Producto insertado correctamente";
            } else {
                $_SESSION['msjErr'] = "Error al insertar el producto";
            }

            header("Location: /productos");
            exit;

        } else {
            // ====== Si hay errores, volver a la vista de alta ======
            $data['categorias'] = $categoriaModel->getAllCategorias();
            $data['errors']     = $errors;
            $data['input']      = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->view->showViews(
                ['templates/header.view.php', 'productosAlta.view.php', 'templates/footer.view.php'],
                $data
            );
        }
    }

    public function updateProducts(int $id): void
    {
        $categoriaModel = new CategoriaModel();
        $productoModel = new ProductoModel();
        
        // Obtener el producto actual
        $producto = $productoModel->getProductoById($id);
        
        if (!$producto) {
            $_SESSION['msjErr'] = "Producto no encontrado";
            header("Location: /productos");
            exit;
        }

        $errors = $this->checkData($_POST, $_FILES, false); // La imagen no es requerida en edición

        if (empty($errors)) {
            // Verificar si se subió una nueva imagen
            if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Subir nueva imagen
                $publicPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
                $uploadDir  = $publicPath . '/assets/img/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $filename = uniqid('img_', true) . '.' . $ext;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                    $_POST['imagen_url'] = $filename;
                    
                    // Eliminar imagen antigua (opcional)
                    if (!empty($producto['imagen_url']) && file_exists($uploadDir . $producto['imagen_url'])) {
                        @unlink($uploadDir . $producto['imagen_url']);
                    }
                } else {
                    $_SESSION['msjErr'] = "Error al guardar la imagen";
                    header("Location: /productos");
                    exit;
                }
            }

            // Actualizar producto
            $update = $productoModel->update($id, $_POST);

            if ($update !== false) {
                $_SESSION['msjE'] = "Producto actualizado correctamente";
            } else {
                $_SESSION['msjErr'] = "Error al actualizar el producto";
            }

            header("Location: /productos");
            exit;

        } else {
            // Si hay errores, volver a la vista de edición
            $data['categorias'] = $categoriaModel->getAllCategorias();
            $data['errors']     = $errors;
            $data['input']      = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['producto']   = $producto;

            $this->view->showViews(
                ['templates/header.view.php', 'productosAlta.view.php', 'templates/footer.view.php'],
                $data
            );
        }
    }

    public function deleteProducts(int $id): void
    {
        $modelo = new ProductoModel();

        try {
            $borrado = $modelo->delete($id);

            if ($borrado) {
                $_SESSION['msjE'] = "Producto eliminado correctamente";
            } else {
                $_SESSION['msjErr'] = "No se encontró el producto o no se pudo eliminar";
            }
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                $_SESSION['msjErr'] = "No se puede eliminar este producto porque está asociado a uno o más pedidos.";
            } else {
                $_SESSION['msjErr'] = "Error al eliminar el producto: " . $e->getMessage();
            }
        }

        header("Location: /productos");
        exit;
    }


    public function destacarProductos(int $id): void
    {
        $modelo = new ProductoModel();
        
        // Obtener el estado actual del producto antes de actualizar
        $producto = $modelo->getProductoById($id);
        
        if (!$producto) {
            $_SESSION['msjErr'] = "Producto no encontrado";
            header("Location: /productos");
            exit;
        }
        
        $estabaDestacado = $producto['destacado'] == 1;
        
        // Realizar el toggle
        $destacar = $modelo->destacar($id);

        if ($destacar !== false) {
            // Mostrar mensaje según si se destacó o se quitó de destacados
            if ($estabaDestacado) {
                $_SESSION['msjE'] = "Producto quitado de destacados correctamente";
            } else {
                $_SESSION['msjE'] = "Producto destacado correctamente";
            }
            header("Location: /productos");
            exit;
        } else {
            $_SESSION['msjErr'] = "Error al actualizar el producto";
            header("Location: /productos");
            exit;
        }
    }

    public function checkData(array $data, array $files = [], bool $imagenRequerida = true): array
    {
        $errors = [];
        // nombre
        if (empty($data['nombre'])) {
            $errors['nombre'] = 'El nombre es requerido';
        } elseif (strlen($data['nombre']) < 3 || strlen($data['nombre']) > 50) {
            $errors['nombre'] = 'El nombre debe tener entre 3 y 50 caracteres';
        }

        // descripcion
        if (empty($data['descripcion'])) {
            $errors['descripcion'] = 'La descripción es requerida';
        } elseif (strlen($data['descripcion']) < 3 || strlen($data['descripcion']) > 300) {
            $errors['descripcion'] = 'La descripción debe tener entre 3 y 255 caracteres';
        }

        // precio
        if (!isset($data['precio']) || $data['precio'] === '') {
            $errors['precio'] = 'El precio es requerido';
        } elseif (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', (string)$data['precio'])) {
            $errors['precio'] = 'Formato de precio inválido (usa punto decimal, ej: 15.99)';
        } elseif ((float)$data['precio'] <= 0) {
            $errors['precio'] = 'El precio debe ser mayor que 0';
        }

        // stock
        if (!isset($data['stock']) || $data['stock'] === '') {
            $errors['stock'] = 'El stock es requerido';
        } elseif (!ctype_digit((string)$data['stock'])) {
            $errors['stock'] = 'El stock debe ser un entero';
        } elseif ((int)$data['stock'] < 0) {
            $errors['stock'] = 'El stock no puede ser negativo';
        }

        if (empty($data['categoria'])) {
            $errors['categoria'] = 'La categoría es requerida';
        }

        $categoriasNutricionales = [1, 2, 3]; // Proteínas, suplementos, snacks
        $categoriaRopa = 4; // Ropa

        if (in_array((int)$data['categoria'], $categoriasNutricionales, true)) {

            if (!isset($data['proteinas']) || $data['proteinas'] === '') {
                $errors['proteinas'] = 'Las proteínas son requeridas';
            } elseif (!ctype_digit((string)$data['proteinas'])) {
                $errors['proteinas'] = 'Las proteínas deben ser un número entero';
            } elseif ((int)$data['proteinas'] < 0) {
                $errors['proteinas'] = 'Las proteínas no pueden ser negativas';
            }

            if (!isset($data['carbohidratos']) || $data['carbohidratos'] === '') {
                $errors['carbohidratos'] = 'Los carbohidratos son requeridos';
            } elseif (!ctype_digit((string)$data['carbohidratos'])) {
                $errors['carbohidratos'] = 'Los carbohidratos deben ser un número entero';
            } elseif ((int)$data['carbohidratos'] < 0) {
                $errors['carbohidratos'] = 'Los carbohidratos no pueden ser negativos';
            }

            if (!isset($data['grasas']) || $data['grasas'] === '') {
                $errors['grasas'] = 'Las grasas son requeridas';
            } elseif (!ctype_digit((string)$data['grasas'])) {
                $errors['grasas'] = 'Las grasas deben ser un número entero';
            } elseif ((int)$data['grasas'] < 0) {
                $errors['grasas'] = 'Las grasas no pueden ser negativas';
            }
        } elseif ((int)$data['categoria'] === $categoriaRopa) {
            // Validación de campos de ropa
            if (empty($data['talla'])) {
                $errors['talla'] = 'La talla es requerida';
            } elseif (strlen($data['talla']) > 20) {
                $errors['talla'] = 'La talla no puede exceder 20 caracteres';
            }

            if (empty($data['color'])) {
                $errors['color'] = 'El color es requerido';
            } elseif (strlen($data['color']) < 2 || strlen($data['color']) > 50) {
                $errors['color'] = 'El color debe tener entre 2 y 50 caracteres';
            }

            if (empty($data['material'])) {
                $errors['material'] = 'El material es requerido';
            } elseif (strlen($data['material']) < 2 || strlen($data['material']) > 100) {
                $errors['material'] = 'El material debe tener entre 2 y 100 caracteres';
            }
        }



        // imagen (ahora por $_FILES)
        // Solo validar si es requerida o si se intentó subir una
        if ($imagenRequerida && empty($files['imagen']['name'])) {
            $errors['imagen'] = 'La imagen es requerida';
        } elseif (!empty($files['imagen']['name']) && $files['imagen']['error'] !== UPLOAD_ERR_OK) {
            // Mensajes de error más específicos según el código de error
            switch ($files['imagen']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors['imagen'] = 'La imagen es demasiado grande (máx. 2GB)';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors['imagen'] = 'La imagen se subió parcialmente, intenta de nuevo';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errors['imagen'] = 'Error del servidor: carpeta temporal no encontrada';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errors['imagen'] = 'Error del servidor: no se pudo escribir el archivo';
                    break;
                default:
                    $errors['imagen'] = 'Error al subir la imagen';
                    break;
            }
        } elseif (!empty($files['imagen']['name'])) {
            // Validar formato solo si se subió una imagen
            $extOk = ['jpg','jpeg','png','gif','webp'];
            $ext = strtolower(pathinfo($files['imagen']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $extOk, true)) {
                $errors['imagen'] = 'Formato de imagen no permitido';
            }
        }

        return $errors;
    }

}
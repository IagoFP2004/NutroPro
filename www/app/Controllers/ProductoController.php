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
        $data = array(
            'titulo' => 'Productos',
            'breadcrumb' => ['Inicio/productos'],
            'seccion' => '/productos'
        );

        $modelo = new ProductoModel();

        $data['proteinas'] = $modelo->getProductosProteinas();
        $data['ropas'] = $modelo->getProductosRopa();
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
        $this->view->showViews(array('templates/header.view.php', 'productos.view.php','templates/footer.view.php'), $data);
    }

    public function showAltaProductsView(): void
    {
        $data = array(
            'titulo' => 'Productos Alta',
            'breadcrumb' => ['Inicio/productos/altas'],
            'seccion' => '/productos/altas'
        );
        $categoriaModel = new CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();
        $this->view->showViews(array('templates/header.view.php', 'productosAlta.view.php','templates/footer.view.php'), $data);
    }

    public function insertProducts(): void
    {
        $data = array(
            'titulo'     => 'Productos Alta',
            'breadcrumb' => ['Inicio/productos/altas'],
            'seccion'    => '/productos/altas'
        );

        $categoriaModel = new CategoriaModel();
        $errors = $this->checkData($_POST, $_FILES);

        if (empty($errors)) {
            // ====== Subir imagen ======
            $publicPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/');        // Ruta base del servidor (ej: /var/www/html/public)
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
            var_dump($errors);
            $data['categorias'] = $categoriaModel->getAllCategorias();
            $data['errors']     = $errors;
            $data['input']      = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->view->showViews(
                ['templates/header.view.php', 'productosAlta.view.php', 'templates/footer.view.php'],
                $data
            );
        }
    }

    public function deleteProducts(int $id): void
    {
        $modelo = new ProductoModel();
        $borrado = $modelo->delete($id);

        if ($borrado !== false) {
            $_SESSION['msjE'] = "Producto eliminado correctamente";
            header("Location: /productos");
            unset($_SESSION['msjE']);
        }else{
            $_SESSION['msjErr'] = "Error al eliminar el producto";
            header("Location: /productos");
            unset($_SESSION['msjE']);
        }

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




    public function checkData(array $data, array $files = []): array
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
        } elseif (strlen($data['descripcion']) < 3 || strlen($data['descripcion']) > 255) {
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

        // categoria
        if (empty($data['categoria'])) {
            $errors['categoria'] = 'La categoría es requerida';
        }

        // imagen (ahora por $_FILES)
        if (empty($files['imagen']['name'])) {
            $errors['imagen'] = 'La imagen es requerida';
        } elseif ($files['imagen']['error'] !== UPLOAD_ERR_OK) {
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
        } else {
            $extOk = ['jpg','jpeg','png','gif','webp'];
            $ext = strtolower(pathinfo($files['imagen']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $extOk, true)) {
                $errors['imagen'] = 'Formato de imagen no permitido';
            }
        }

        return $errors;
    }

}
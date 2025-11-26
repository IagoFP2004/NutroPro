<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UserModel;

class UserController extends BaseController
{
 public function showLoginForm():void
 {
     $this->view->show('login.view.php');
 }

 public function register():void
 {
     $this->view->show('register.view.php');
 }

 public function doRegister():void
 {
    $errores = $this->checkErrors($_POST);
    
    if (empty($errores)) {
        $userModel = new UserModel();
        
        // Verificar si el email ya existe
        if ($userModel->getByEmail($_POST['email'])) {
            $data['errores']['email'] = 'Este email ya está registrado';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->view->show('register.view.php', $data);
            return;
        }
        
        // Determinar el rol del usuario
        $_POST['id_rol'] = isset($_POST['admin']) && $_POST['admin'] == '1' ? 1 : 0;
        
        // Hashear la contraseña
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Insertar usuario
        $inserted = $userModel->insert($_POST);
        
        if ($inserted) {
            $data['msjE'] = 'Usuario registrado correctamente. Ya puedes iniciar sesión.';
            $this->view->show('login.view.php', $data);
        } else {
            $data['msjErr'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->view->show('register.view.php', $data);
        }
    } else {
        $data['errores'] = $errores;
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->view->show('register.view.php', $data);
    }
 }

 public function doLogin():void
 {
    $modelo = new UserModel();

    $login = $modelo->getByEmail($_POST['email']);
    if ($login !== false) {
        if(password_verify($_POST['password'], $login['password'])) {
            $_SESSION['usuario'] = $login;
            $_SESSION['usuario']['permisos'] = $this->getPermisos($login['id_rol']);
            
            // Inicializar contador del carrito
            $carritoModel = new \Com\Daw2\Models\CarritoModel();
            $_SESSION['carrito_count'] = $carritoModel->contarProductosCarrito($login['id_usuario']);
            
            header('Location: /productos');
            exit;
        }else{
            $data['msjErr'] = "Correo o contraseña incorrectos";
            $this->view->show('login.view.php', $data);
        }
    }else{
        $data['msjErr'] = "Correo o contraseña incorrectos";
        $this->view->show('login.view.php', $data);
    }
 }

    public function getPermisos(int $idRol):string
    {
        $permisos = '';

        if ($idRol === 1)
        {
            $permisos = 'rwd';  // Admin: read, write, delete
        }else{
            $permisos = 'r';
        }

        return $permisos;
    }

    public function checkErrors(array $data):array
    {
        $errores = [];
        $modelo = new UserModel();

        if (empty($data['nombre'])) {
            $errores['nombre'] = 'El nombre es requerido';
        }else if (strlen($data['nombre']) < 3) {
            $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres';
        }else if (!preg_match('/^[\p{L}\s\'-]+$/u', $data['nombre'])) {
            $errores['nombre'] = 'El nombre es incorrecto';
        }

        if (empty($data['email'])) {
            $errores['email'] = 'El email es requerido';
        }else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es valido';
        }else if ($modelo->getByEmail($data['email']) !== false) {
            $errores['email'] = 'El email ya existe';
        }

        if (empty($data['direccion'])){
            $errores['direccion'] = 'La direccion es requerido';
        }

        if (empty($data['telefono'])){
            $errores['telefono'] = 'El telefono es requerido';
        }else if ($modelo->getByPhone($data['telefono']) !== false) {
            $errores['telefono'] = 'El telefono ya existe';
        }

        if (empty($data['password'])) {
            $errores['password'] = 'El password es requerido';
        }

        if (empty($data['confirm-password'])) {
            $errores['confirm-password'] = "El confirm password es requerido";
        }else if ($data['password'] !== $data['confirm-password']) {
            $errores['confirm-password'] = "Las passwords no coinciden";
        }

        return $errores;
    }

    public function showUserData(int $idUsuario):void
    {
        $modelo = new UserModel();
        $pedidoModel = new \Com\Daw2\Models\PedidoModel();

        $user = $modelo->getById($idUsuario);
        $pedidos = $pedidoModel->getPedidosByIdUsuario($idUsuario);

        $data['usuario'] = $user;
        $data['pedidos'] = is_array($pedidos) ? $pedidos : [];

        $this->view->showViews(array('templates/header.view.php', 'user.view.php','templates/footer.view.php'), $data);
    }

    public function editUSer(int $idUsuario):void
    {
        $modelo = new UserModel();
        $usuarioActual = $modelo->getById($idUsuario);
        
        // Validar errores
        $errores = $this->checkEditErrors($_POST, $idUsuario);

        if (empty($errores)) {
            // Preparar datos para actualizar
            $datosUpdate = [
                'idUsuario' => $idUsuario,
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'direccion' => $_POST['direccion'],
                'telefono' => $_POST['telefono'],
                'id_rol' => $usuarioActual['id_rol'],
                'password' => $usuarioActual['password']
            ];
            $editado = $modelo->editInfoUser($datosUpdate, $idUsuario);
            $editado = $modelo->editInfoUser($datosUpdate,$idUsuario);
            if ($editado !== false) {
                // Actualizar datos en sesión
                $_SESSION['usuario']['nombre'] = $datosUpdate['nombre'];
                $_SESSION['usuario']['email'] = $datosUpdate['email'];
                $_SESSION['usuario']['direccion'] = $datosUpdate['direccion'];
                $_SESSION['usuario']['telefono'] = $datosUpdate['telefono'];
                
                $_SESSION['msjE'] = 'Tu información ha sido actualizada correctamente';
                header('Location: /micuenta/' . $idUsuario);
                exit;
            } else {
                $_SESSION['msjErr'] = 'Error al actualizar la información';
                header('Location: /micuenta/' . $idUsuario);
                exit;
            }

        } else {
            // Hay errores - mostrar formulario con errores
            $pedidoModel = new \Com\Daw2\Models\PedidoModel();
            
            $data['errores'] = $errores;
            $data['input'] = $_POST;
            $data['usuario'] = $usuarioActual;
            $data['pedidos'] = $pedidoModel->getPedidosByIdUsuario($idUsuario);
            
            $this->view->showViews(array('templates/header.view.php', 'user.view.php','templates/footer.view.php'), $data);
        }
    }

    public function checkEditErrors(array $data, int $idUsuario):array
    {
        $errores = [];
        $modelo = new UserModel();

        if (empty($data['nombre'])) {
            $errores['nombre'] = 'El nombre es requerido';
        }

        if (empty($data['email'])) {
            $errores['email'] = 'El email es requerido';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es válido';
        } else {
            // Verificar si el email ya existe para OTRO usuario
            $existeEmail = $modelo->getByEmail($data['email']);
            if ($existeEmail !== false && $existeEmail['id_usuario'] != $idUsuario) {
                $errores['email'] = 'Este email ya está en uso';
            }
        }

        if (empty($data['direccion'])){
            $errores['direccion'] = 'La dirección es requerida';
        }

        if (empty($data['telefono'])){
            $errores['telefono'] = 'El teléfono es requerido';
        } else {
            // Verificar si el teléfono ya existe para OTRO usuario
            $existeTelefono = $modelo->getByPhone($data['telefono']);
            if ($existeTelefono !== false && $existeTelefono['id_usuario'] != $idUsuario) {
                $errores['telefono'] = 'Este teléfono ya está en uso';
            }
        }

        return $errores;
    }

 //============= ADMIN FUNCTIONS =============//
    public function showgestionUsuarios():void
    {
        $modelo = new UserModel();

        $copia_GET = $_GET;
        unset($copia_GET['page']);
        $data['url'] = http_build_query($copia_GET);

        $numeroTotalUsuarios = $modelo->countNumberItems();
        $numeroPaginas = $this->getNumeroPaginas($numeroTotalUsuarios);
        $data['page'] = $this->getNumeroPagina($numeroPaginas);
        $data['max_page'] = $numeroPaginas;

        $data['usersNum'] = $modelo->getAllUsers();
        $data['usuarios'] = $modelo->getAllUsersAdmin($data['page']);

        $this->view->showViews(array('templates/header.view.php', 'gestionUsuarios.view.php','templates/footer.view.php'), $data);
    }

    public function createUserByAdmin():void
    {
        $errores = $this->checkErrors($_POST);
        
        if (empty($errores)) {
            $userModel = new UserModel();
                if ($userModel->getByEmail($_POST['email'])) {
                $data['errores']['email'] = 'Este email ya está registrado';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->view->show('gestionUsuarios.view.php', $data);
                return;
            }
            $_POST['id_rol'] = isset($_POST['admin']) && $_POST['admin'] == '1' ? 1 : 0;
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $inserted = $userModel->insert($_POST);

            if ($inserted !== false) {
                header('Location: /gestionUsuarios');
                exit;
            } else {
                $data['msjErr'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->view->show('gestionUsuarios.view.php', $data);
            }
        } else {
            $data['errores'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->view->show('gestionUsuarios.view.php', $data);
        }
    }

    public function deleteUserByAdmin(int $idUsuario):void
    {
        $userModel = new UserModel();
        $deleted = $userModel->deleteUser($idUsuario);

        if ($deleted !== false) {
            header('Location: /gestionUsuarios');
            exit;
        } else {
            $data['msjErr'] = 'Error al eliminar el usuario. Inténtalo de nuevo.';
            $this->view->show('gestionUsuarios.view.php', $data);
        }
    }

    public function getNumeroPaginas(int $numeroTotalItems):int
    {
        return (int)ceil($numeroTotalItems / $_ENV['numero.pagina']);
    }

    public function getNumeroPagina(int $numeroPaginas):int
    {
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
            if ($page >= 1 && $page <= $numeroPaginas) {
                return (int) $page;
            }
        }
        return 1;
    }

}
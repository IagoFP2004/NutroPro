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
     var_dump($_SESSION);
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
            header('Location: /productos');
            exit;
        }else{
            $data['errores']['password'] = 'Contraseña incorrecta';
            $this->view->show('login.view.php',$data);
        }
    }else{
        $data['msjErr'] = "El usuario no existe";
        $this->view->show('login.view.php', $data);
    }
 }

    public function getPermisos(int $idRol):string
    {
        $permisos = '';

        if ($idRol === 1)
        {
            $permisos = 'rwd';  // Admin: read, write, delete
        }else if ($idRol === 2)
        {
            $permisos = 'rw';   // Editor: read, write
        }else if ($idRol === 3){
            $permisos = 'r';    // Viewer: solo read
        }else{
            $permisos = 'r';    // Por defecto: solo lectura
        }

        return $permisos;
    }

    public function checkErrors(array $data):array
    {
        $errores = [];

        if (empty($data['nombre'])) {
            $errores['nombre'] = 'El nombre es requerido';
        }

        if (empty($data['email'])) {
            $errores['email'] = 'El email es requerido';
        }else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es valido';
        }

        if (empty($data['direccion'])){
            $errores['direccion'] = 'La direccion es requerido';
        }

        if (empty($data['telefono'])){
            $errores['telefono'] = 'El telefono es requerido';
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
}
<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CarritoController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\ProductoController;
use Com\Daw2\Controllers\UserController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();
        
        // Inicializar contador del carrito si el usuario está logueado
        if (isset($_SESSION['usuario']) && !isset($_SESSION['carrito_count'])) {
            $carritoModel = new \Com\Daw2\Models\CarritoModel();
            $_SESSION['carrito_count'] = $carritoModel->contarProductosCarrito($_SESSION['usuario']['id_usuario']);
        }
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
            },
            'get'
        );
        if (!isset($_SESSION['usuario'])){
            Route::add(
                '/login',
                function () {
                    $controlador = new UserController();
                    $controlador->showLoginForm();
                },
                'get'
            );


            Route::add(
                '/login',
                function () {
                    $controlador = new UserController();
                    $controlador->doLogin();
                },
                'post'
            );

            Route::add(
                '/register',
                function () {
                    $controlador = new UserController();
                    $controlador->register();
                },
                'get'
            );

            Route::add(
                '/register',
                function () {
                    $controlador = new UserController();
                    $controlador->doRegister();
                },
                'post'
            );
        }

        Route::add(
            '/logout',
            function () {
                $_SESSION = array();
                session_destroy();
                header('Location: /');
                exit;
            },
            'get'
        );

        Route::add(
            '/productos',
            function () {
                $controlador = new productoController();
                $controlador->showProductsView();
            },
            'get'
        );
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['permisos'] == 'rwd') {
            Route::add(
                '/productos/nuevo',
                function () {
                    $controlador = new productoController();
                    $controlador->showAltaProductsView();
                },
                'get'
            );
            Route::add(
                '/productos/nuevo',
                function () {
                    $controlador = new productoController();
                    $controlador->insertProducts();
                },
                'post'
            );

            Route::add(
                '/productos/editar/([0-9]+)',
                function (int $id) {
                    $controlador = new productoController();
                    $controlador->showEditView($id);
                },
                'get'
            );
            Route::add(
                '/productos/editar/([0-9]+)',
                function (int $id) {
                    $controlador = new productoController();
                    $controlador->updateProducts($id);
                },
                'post'
            );
            Route::add(
                '/productos/delete/([0-9]+)',
                function (int $id) {
                    $controlador = new productoController();
                    $controlador->deleteProducts($id);
                },
                'get'
            );

            Route::add(
                '/productos/destacar/([0-9]+)',
                function (int $id) {
                    $controlador = new productoController();
                    $controlador->destacarProductos($id);
                },
                'get'
            );
        }
        Route::add(
            '/productos/([0-9]+)',
            function (int $id) {
                $controlador = new productoController();
                $controlador->showDetailsView($id);
            },
            'get'
        );

        Route::add(
            '/carrito',
            function () {
                if (!isset($_SESSION['usuario'])) {
                    $_SESSION['error'] = 'Debes iniciar sesión para ver el carrito';
                    header('Location: /login');
                    exit;
                }
                $controlador = new CarritoController();
                $controlador->showCarrito();
            },
            'get'
        );

        Route::add(
            '/carrito/add',
            function ():void {
                if (!isset($_SESSION['usuario'])) {
                    $_SESSION['error'] = 'Debes iniciar sesión para agregar al carrito';
                    header('Location: /login');
                    exit;
                }
                $controlador = new CarritoController();
                $controlador->addCarrito();
            },
            'post'
        );

        Route::pathNotFound(function () {
            if (!isset($_SESSION['usuario'])) {
                header('Location: /login');
            } else {
                header('Location: /');
            }
        });

        Route::methodNotAllowed(
            function () {
                header('Location: /');
            }
        );
        Route::run();
    }
}

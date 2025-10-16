<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\ProductoController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
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

        Route::add(
            '/productos/([0-9]+)',
            function () {
                $controlador = new productoController();
                $controlador->showDetailsView();
            },
            'get'
        );

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

        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );
        Route::methodNotAllowed(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}

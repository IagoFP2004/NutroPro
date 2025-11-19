<?php

declare(strict_types=1);

namespace Com\Daw2\Tests;

use Com\Daw2\Models\ProductoModel;
use PHPUnit\Framework\TestCase;

class ProductoModelTest extends TestCase
{
    private ProductoModel $productoModel;

    public function setUp(): void
    {
        $this->productoModel = new ProductoModel();
    }

    public function testCreateProduct(): void
    {
        $data = [
            'nombre' => 'Producto Prueba',
            'descripcion' => 'Descripcion Prueba',
            'precio' => 100,
            'stock' => 500,
            'categoria' => 1,
            'destacado' => 0,
            'imagen_url' => 'imagen.jpg',
            'proteinas' => 20,
            'carbohidratos' => 20,
            'grasas' => 20,
            'talla' => null,
            'color' => null,
            'material' => null,
        ];

        $resultado = $this->productoModel->insert($data);
        $this->assertTrue((bool)$resultado);
    }

    public function testGetProductosReturnsArray(): void
    {
        $productos = $this->productoModel->getProductos();
        $this->assertIsArray($productos);
    }

    public function testGetProductoById(): void
    {
        $data = [
            'nombre' => 'Producto Test ID',
            'descripcion' => 'Producto para test de ID',
            'precio' => 50,
            'stock' => 100,
            'categoria' => 1,
            'destacado' => 0,
            'imagen_url' => 'test.jpg',
            'proteinas' => 10,
            'carbohidratos' => 10,
            'grasas' => 10,
            'talla' => null,
            'color' => null,
            'material' => null,
        ];

        $this->productoModel->insert($data);

        $productos = $this->productoModel->getProductos();
        $ultimoProducto = end($productos);
        $idProducto = $ultimoProducto['id_producto'];

        $producto = $this->productoModel->getProductoById($idProducto);
        $this->assertIsArray($producto);
        $this->assertEquals('Producto Test ID', $producto['nombre']);
    }

    public function testDeleteProduct(): void
    {
        $data = [
            'nombre' => 'Producto Para Borrar',
            'descripcion' => 'Este producto será borrado',
            'precio' => 25,
            'stock' => 50,
            'categoria' => 2,
            'destacado' => 0,
            'imagen_url' => 'borrar.jpg',
            'proteinas' => 5,
            'carbohidratos' => 5,
            'grasas' => 5,
            'talla' => null,
            'color' => null,
            'material' => null,
        ];

        $this->productoModel->insert($data);

        $productos = $this->productoModel->getProductos();
        $ultimoProducto = end($productos);
        $idProducto = $ultimoProducto['id_producto'];

        $resultado = $this->productoModel->delete($idProducto);
        $this->assertTrue($resultado);

        $productoBorrado = $this->productoModel->getProductoById($idProducto);
        $this->assertNull($productoBorrado);
    }

    public function testUpdateProduct(): void
    {
        $data = [
            'nombre' => 'Producto Original',
            'descripcion' => 'Descripción original',
            'precio' => 30,
            'stock' => 75,
            'categoria' => 3,
            'destacado' => 0,
            'imagen_url' => 'original.jpg',
            'proteinas' => 15,
            'carbohidratos' => 15,
            'grasas' => 15,
            'talla' => null,
            'color' => null,
            'material' => null,
        ];

        $this->productoModel->insert($data);

        $productos = $this->productoModel->getProductos();
        $ultimoProducto = end($productos);
        $idProducto = $ultimoProducto['id_producto'];

        $dataActualizada = [
            'nombre' => 'Producto Actualizado',
            'descripcion' => 'Descripción actualizada',
            'precio' => 35,
            'stock' => 80,
            'categoria' => 3,
            'proteinas' => 20,
            'carbohidratos' => 20,
            'grasas' => 20,
            'talla' => null,
            'color' => null,
            'material' => null,
        ];

        $resultado = $this->productoModel->update($idProducto, $dataActualizada);
        $this->assertTrue($resultado);

        $productoActualizado = $this->productoModel->getProductoById($idProducto);
        $this->assertEquals('Producto Actualizado', $productoActualizado['nombre']);
        $this->assertEquals(35, $productoActualizado['precio']);
    }

}
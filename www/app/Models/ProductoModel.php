<?php
declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{
    public function getProductos(): array
    {
        $sql = 'SELECT * FROM productos';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosFiltrados(array $filtros): array
    {
        $sql = "SELECT * FROM productos WHERE 1=1";
        $params = [];

        if (!empty($filtros['categoria'])) {
            $sql .= " AND id_categoria = :categoria";
            $params['categoria'] = (int)$filtros['categoria'];
        }

        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (nombre LIKE :busqueda OR descripcion LIKE :busqueda)";
            $params['busqueda'] = '%' . $filtros['busqueda'] . '%';
        }

        if (!empty($filtros['precio'])) {
            switch ($filtros['precio']) {
                case '0-20':
                    $sql .= " AND precio BETWEEN 0 AND 20";
                    break;
                case '20-40':
                    $sql .= " AND precio BETWEEN 20 AND 40";
                    break;
                case '40+':
                    $sql .= " AND precio > 40";
                    break;
            }
        }

        $sql .= " ORDER BY id_categoria, nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $productos = $stmt->fetchAll();

        $resultado = [
            'proteinas' => [],
            'ropas' => [],
            'suplementos' => [],
            'accesorios' => [],
            'snacks' => []
        ];

        foreach ($productos as $producto) {
            switch ($producto['id_categoria']) {
                case 1:
                    $resultado['proteinas'][] = $producto;
                    break;
                case 2:
                    $resultado['suplementos'][] = $producto;
                    break;
                case 3:
                    $resultado['snacks'][] = $producto;
                    break;
                case 4:
                    $resultado['ropas'][] = $producto;
                    break;
                case 5:
                    $resultado['accesorios'][] = $producto;
                    break;
            }
        }

        return $resultado;
    }

    public function getProductosProteinasCreatina(): array
    {
        $sql = "SELECT * FROM productos WHERE id_categoria = 1 AND nombre LIKE '%protein%' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosProteinas(): array
    {
        $sql = "SELECT * FROM productos WHERE id_categoria = 1 AND nombre LIKE '%protein%'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosCreatina(): array
    {
        $sql = "SELECT * FROM productos WHERE id_categoria = 1 AND nombre LIKE '%creat%'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosRopa(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 4 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosSuplementos(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 2 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosAccesorios(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 5 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosSnacks(): array
    {
        $sql = 'SELECT * FROM productos WHERE id_categoria = 3 ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert(array $data): bool
    {
        $sql = "INSERT INTO `productos`
        (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`, `talla`, `color`, `material`) 
        VALUES 
        (:nombre, :descripcion, :precio, :stock, :id_categoria, 0, :imagen_url, :proteinas, :carbohidratos, :grasas, :talla, :color, :material)";

        $stmt = $this->pdo->prepare($sql);

        // 🔹 Convertimos cadenas vacías en NULL para campos nutricionales
        $proteinas = $data['proteinas'] ?? null;
        $carbohidratos = $data['carbohidratos'] ?? null;
        $grasas = $data['grasas'] ?? null;

        if ($proteinas === '') $proteinas = null;
        if ($carbohidratos === '') $carbohidratos = null;
        if ($grasas === '') $grasas = null;

        // 🔹 Convertimos cadenas vacías en NULL para campos de ropa
        $talla = $data['talla'] ?? null;
        $color = $data['color'] ?? null;
        $material = $data['material'] ?? null;

        if ($talla === '') $talla = null;
        if ($color === '') $color = null;
        if ($material === '') $material = null;

        return $stmt->execute([
            'nombre'         => $data['nombre'],
            'descripcion'    => $data['descripcion'],
            'precio'         => $data['precio'],
            'stock'          => $data['stock'],
            'id_categoria'   => $data['categoria'],
            'imagen_url'     => $data['imagen_url'],
            'proteinas'      => $proteinas,
            'carbohidratos'  => $carbohidratos,
            'grasas'         => $grasas,
            'talla'          => $talla,
            'color'          => $color,
            'material'       => $material
        ]);
    }





    public function getProductoById(int $id): ?array
    {
        $sql = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM productos WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function destacar(int $id): bool
    {
        $sql = "UPDATE productos SET destacado = 1 - destacado WHERE id_producto = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE `productos` SET
            `nombre` = :nombre,
            `descripcion` = :descripcion,
            `precio` = :precio,
            `stock` = :stock,
            `id_categoria` = :id_categoria,
            `proteinas` = :proteinas,
            `carbohidratos` = :carbohidratos,
            `grasas` = :grasas,
            `talla` = :talla,
            `color` = :color,
            `material` = :material";
        
        // Si se proporciona una nueva imagen, actualizarla también
        if (isset($data['imagen_url'])) {
            $sql .= ", `imagen_url` = :imagen_url";
        }
        
        $sql .= " WHERE `id_producto` = :id";

        $stmt = $this->pdo->prepare($sql);

        // Convertimos cadenas vacías en NULL para campos nutricionales
        $proteinas = $data['proteinas'] ?? null;
        $carbohidratos = $data['carbohidratos'] ?? null;
        $grasas = $data['grasas'] ?? null;

        if ($proteinas === '') $proteinas = null;
        if ($carbohidratos === '') $carbohidratos = null;
        if ($grasas === '') $grasas = null;

        // Convertimos cadenas vacías en NULL para campos de ropa
        $talla = $data['talla'] ?? null;
        $color = $data['color'] ?? null;
        $material = $data['material'] ?? null;

        if ($talla === '') $talla = null;
        if ($color === '') $color = null;
        if ($material === '') $material = null;

        $params = [
            'id'             => $id,
            'nombre'         => $data['nombre'],
            'descripcion'    => $data['descripcion'],
            'precio'         => $data['precio'],
            'stock'          => $data['stock'],
            'id_categoria'   => $data['categoria'],
            'proteinas'      => $proteinas,
            'carbohidratos'  => $carbohidratos,
            'grasas'         => $grasas,
            'talla'          => $talla,
            'color'          => $color,
            'material'       => $material
        ];

        // Si hay imagen nueva, agregarla a los parámetros
        if (isset($data['imagen_url'])) {
            $params['imagen_url'] = $data['imagen_url'];
        }

        return $stmt->execute($params);
    }
}
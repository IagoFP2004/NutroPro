-- =====================================================
-- Script de base de datos NutroPro (actualizado)
-- Compatible con MySQL 8.4 / phpMyAdmin 5.2+
-- Generado el: 2025-10-15
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------
-- ELIMINAR TABLAS SI EXISTEN (orden inverso por dependencias)
-- --------------------------------------------------
DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS detalle_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

-- --------------------------------------------------
-- TABLAS
-- --------------------------------------------------

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    id_categoria INT NULL,
    destacado TINYINT(1) DEFAULT 0,
    imagen_url VARCHAR(255),
    CONSTRAINT fk_productos_categorias
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_pedidos_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_producto INT NULL,
    producto_nombre VARCHAR(150) NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_detalle_pedido_pedidos
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_detalle_pedido_productos
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_carrito_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_carrito_productos
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------
-- DATOS DE PRUEBA
-- --------------------------------------------------

-- Categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Proteinas', 'Suplementos de proteínas en polvo y batidos'),
('Vitaminas', 'Vitaminas y minerales esenciales'),
('Snacks', 'Barras y snacks saludables'),
('Ropa', 'Ropa deportiva y accesorios'),
('Accesorios', 'Accesorios para entrenar y suplementación');

-- Productos (usando solo nombres de archivo, no rutas completas)
INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, destacado, imagen_url) VALUES
('Proteína Whey 1kg Vainilla', 'Proteína de suero de leche sabor vainilla.', 29.99, 50, 1, 1, 'ChatGPT Image 9 oct 2025, 16_52_32.png'),
('Multivitamínico Daily', 'Complejo vitamínico para uso diario.', 14.99, 100, 2, 0, 'nano-banana-2025-10-13T14-46-54.png'),
('Barrita proteica', 'Barritas proteicas', 2.50, 200, 3, 0, 'img_68efad827ef610.06845329.jpeg'),
('Sudadera Deportiva Negra', 'Sudadera deportiva para entrenar con estilo y comodidad.', 19.99, 75, 4, 0, 'ChatGPT Image 9 oct 2025, 15_02_05.png'),
('Creatina', 'Creatina monohidratada de alta pureza.', 15.00, 100, 1, 1, 'ChatGPT Image 9 oct 2025, 15_49_15.png'),
('Camiseta básica blanca', 'Camiseta deportiva cómoda y ligera.', 11.99, 50, 4, 1, 'ChatGPT Image 9 oct 2025, 16_31_30.png'),
('Shaker', 'Vaso mezclador para proteínas NutroPro.', 6.00, 500, 5, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png');

-- Usuarios
INSERT INTO usuarios (nombre, email, password, direccion, telefono) VALUES
('Juan Pérez', 'juan@example.com', '1234', 'Calle Falsa 123', '600123456'),
('Ana Gómez', 'ana@example.com', '1234', 'Avenida Siempre Viva 456', '600654321');

-- Pedidos
INSERT INTO pedidos (id_usuario, estado, total) VALUES
(1, 'pendiente', 32.49),
(2, 'pagado', 44.98);

-- Detalle de pedidos (guardando snapshot de nombre del producto)
INSERT INTO detalle_pedido (id_pedido, id_producto, producto_nombre, cantidad, precio_unitario) VALUES
(1, 1, 'Proteína Whey 1kg Vainilla', 1, 29.99),
(1, 3, 'Barrita proteica', 1, 2.50),
(2, 2, 'Multivitamínico Daily', 2, 14.99),
(2, 4, 'Sudadera Deportiva Negra', 1, 19.99);

-- Carrito
INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES
(1, 2, 1),
(2, 3, 2);

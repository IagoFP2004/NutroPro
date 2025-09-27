-- Desactivar temporalmente checks de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------
-- TABLAS
-- --------------------------------------------------

DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS detalle_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    id_categoria INT,
    imagen_url VARCHAR(255),
    INDEX (id_categoria),
    CONSTRAINT fk_productos_categorias FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL,
    INDEX (id_usuario),
    CONSTRAINT fk_pedidos_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_producto INT,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    INDEX (id_pedido),
    INDEX (id_producto),
    CONSTRAINT fk_detalle_pedido_pedidos FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    CONSTRAINT fk_detalle_pedido_productos FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_producto INT,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (id_usuario),
    INDEX (id_producto),
    CONSTRAINT fk_carrito_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_carrito_productos FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reactivar checks de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------
-- DATOS DE PRUEBA
-- --------------------------------------------------

-- Categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Proteínas', 'Suplementos de proteínas en polvo y batidos'),
('Vitaminas', 'Vitaminas y minerales esenciales'),
('Snacks', 'Barras y snacks saludables'),
('Ropa', 'Ropa deportiva y accesorios');

-- Productos
INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, imagen_url) VALUES
('Proteína Whey 1kg', 'Proteína de suero de leche sabor chocolate', 29.99, 50, 1, 'img/whey_chocolate.jpg'),
('Multivitamínico Daily', 'Complejo vitamínico para uso diario', 14.99, 100, 2, 'img/multivitamin.jpg'),
('Barra energética', 'Barras de avena y proteína', 2.50, 200, 3, 'img/barra_energetica.jpg'),
('Camiseta Deportiva', 'Camiseta transpirable para entrenar', 19.99, 75, 4, 'img/camiseta_deportiva.jpg');

-- Usuarios
INSERT INTO usuarios (nombre, email, password, direccion, telefono) VALUES
('Juan Pérez', 'juan@example.com', '1234', 'Calle Falsa 123', '600123456'),
('Ana Gómez', 'ana@example.com', '1234', 'Avenida Siempre Viva 456', '600654321');

-- Pedidos
INSERT INTO pedidos (id_usuario, estado, total) VALUES
(1, 'pendiente', 32.49),
(2, 'pagado', 44.98);

-- Detalle de pedidos
INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 1, 29.99),
(1, 3, 1, 2.50),
(2, 2, 2, 14.99),
(2, 4, 1, 19.99);

-- Carrito
INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES
(1, 2, 1),
(2, 3, 2);

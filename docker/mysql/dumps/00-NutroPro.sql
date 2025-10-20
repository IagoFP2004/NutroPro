-- 001-nutropro-init.sql
-- MySQL 8.x
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `nutropro` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `nutropro`;

START TRANSACTION;

-- =========================
-- Tablas base
-- =========================

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre`     VARCHAR(100) NOT NULL,
  `email`      VARCHAR(100) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `direccion`  VARCHAR(255) DEFAULT NULL,
  `telefono`   VARCHAR(20)  DEFAULT NULL,
  `fecha_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uq_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nombre`       VARCHAR(100) NOT NULL,
  `descripcion`  TEXT,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto`  INT NOT NULL AUTO_INCREMENT,
  `nombre`       VARCHAR(150) NOT NULL,
  `descripcion`  TEXT,
  `precio`       DECIMAL(10,2) NOT NULL,
  `stock`        INT DEFAULT '0',
  `id_categoria` INT DEFAULT NULL,
  `destacado`    INT NOT NULL DEFAULT 0,
  `imagen_url`   VARCHAR(255) DEFAULT NULL,
  -- macros (se aseguran también más abajo por si la tabla ya existía)
  `proteinas`     INT DEFAULT 0,
  `carbohidratos` INT DEFAULT 0,
  `grasas`        INT DEFAULT 0,
  PRIMARY KEY (`id_producto`),
  KEY `idx_productos_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Asegurar columnas macros si la tabla ya existía sin ellas
ALTER TABLE `productos`
  ADD COLUMN IF NOT EXISTS `proteinas`     INT DEFAULT 0 AFTER `imagen_url`,
  ADD COLUMN IF NOT EXISTS `carbohidratos` INT DEFAULT 0 AFTER `proteinas`,
  ADD COLUMN IF NOT EXISTS `grasas`        INT DEFAULT 0 AFTER `carbohidratos`,
  MODIFY `destacado` INT NOT NULL DEFAULT 0;

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido`   INT NOT NULL AUTO_INCREMENT,
  `id_usuario`  INT DEFAULT NULL,
  `fecha_pedido` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `idx_pedidos_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detalle`   INT NOT NULL AUTO_INCREMENT,
  `id_pedido`    INT DEFAULT NULL,
  `id_producto`  INT DEFAULT NULL,
  `cantidad`     INT NOT NULL,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `idx_detalle_pedido` (`id_pedido`),
  KEY `idx_detalle_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `carrito` (
  `id_carrito`    INT NOT NULL AUTO_INCREMENT,
  `id_usuario`    INT DEFAULT NULL,
  `id_producto`   INT DEFAULT NULL,
  `cantidad`      INT NOT NULL DEFAULT 1,
  `fecha_agregado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carrito`),
  KEY `idx_carrito_usuario` (`id_usuario`),
  KEY `idx_carrito_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- =========================
-- Foreign Keys (condicionales)
-- Nota: en CREATE TABLE ya quedan si se crea de cero; aquí las añadimos
-- solo si faltan en tablas existentes.
-- =========================
-- fk_productos_categorias
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_productos_categorias'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `productos` ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias`(`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- fk_pedidos_usuarios
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_pedidos_usuarios'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `pedidos` ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- fk_detalle_pedido_pedidos
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_detalle_pedido_pedidos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `detalle_pedido` ADD CONSTRAINT `fk_detalle_pedido_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- fk_detalle_pedido_productos
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_detalle_pedido_productos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `detalle_pedido` ADD CONSTRAINT `fk_detalle_pedido_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id_producto`) ON DELETE RESTRICT ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- fk_carrito_usuarios
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_carrito_usuarios'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `carrito` ADD CONSTRAINT `fk_carrito_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- fk_carrito_productos
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_carrito_productos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `carrito` ADD CONSTRAINT `fk_carrito_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- =========================
-- Datos semilla (idempotentes)
-- =========================

-- Usuarios (demo: password en texto plano, cambia a hash en prod)
INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `direccion`, `telefono`)
VALUES
(1, 'Juan Pérez', 'juan@example.com', '1234', 'Calle Falsa 123', '600123456'),
(2, 'Ana Gómez',  'ana@example.com',  '1234', 'Avenida Siempre Viva 456', '600654321')
ON DUPLICATE KEY UPDATE
  `nombre`=VALUES(`nombre`),
  `email`=VALUES(`email`),
  `password`=VALUES(`password`),
  `direccion`=VALUES(`direccion`),
  `telefono`=VALUES(`telefono`);

-- Categorías
INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1,'Proteínas','Suplementos de proteínas en polvo y batidos'),
(2,'Vitaminas','Vitaminas y minerales esenciales'),
(3,'Snacks','Barras y snacks saludables'),
(4,'Ropa','Ropa deportiva y accesorios'),
(5,'Accesorios','Accesorios para entrenar y suplementación')
ON DUPLICATE KEY UPDATE
  `nombre`=VALUES(`nombre`),
  `descripcion`=VALUES(`descripcion`);

-- Productos (con macros)
INSERT INTO `productos`
(`id_producto`,`nombre`,`descripcion`,`precio`,`stock`,`id_categoria`,`destacado`,`imagen_url`,`proteinas`,`carbohidratos`,`grasas`)
VALUES
(1,  'Proteína Whey 1kg Vainilla','Proteína de suero de leche sabor chocolate', 29.99, 50, 1, 1, 'ChatGPT Image 9 oct 2025, 16_52_32.png', 24, 3, 2),
(2,  'Pack de suplementación NutroPro','Pack con la mejor suplementación diaria para mantener la salud', 14.99,100,2,0,'img_68ef4b9c90a1c8.30665722.png', 0, 0, 0),
(3,  'Barrita proteica','Barras de avena y proteína', 2.50, 200, 3, 0, 'img_68efbd6b0bca56.85626268.png', 10, 18, 6),
(4,  'Sudadera Deportiva Negra','Sudadera deportiva para entrenar con estilo y comodidad', 19.99, 75, 4, 0, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 0, 0, 0),
(7,  'Shaker', NULL, 6.00, 500, 5, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png', 0, 0, 0),
(10, 'Creatina Monohidrate', 'Mejora tu fuerza y energía en entrenamientos intensos. Ideal para potencia, recuperación y rendimiento muscular rápido.', 15.00, 500, 1, 0, 'img_68f166d86522f0.78190263.png', 5, 15, 5)
ON DUPLICATE KEY UPDATE
  `nombre`=VALUES(`nombre`),
  `descripcion`=VALUES(`descripcion`),
  `precio`=VALUES(`precio`),
  `stock`=VALUES(`stock`),
  `id_categoria`=VALUES(`id_categoria`),
  `destacado`=VALUES(`destacado`),
  `imagen_url`=VALUES(`imagen_url`),
  `proteinas`=VALUES(`proteinas`),
  `carbohidratos`=VALUES(`carbohidratos`),
  `grasas`=VALUES(`grasas`);

-- Pedidos
INSERT INTO `pedidos` (`id_pedido`,`id_usuario`,`fecha_pedido`,`estado`,`total`) VALUES
(1,1,'2025-10-09 11:31:30','pendiente',32.49),
(2,2,'2025-10-09 11:31:30','pagado',44.98)
ON DUPLICATE KEY UPDATE
  `id_usuario`=VALUES(`id_usuario`),
  `fecha_pedido`=VALUES(`fecha_pedido`),
  `estado`=VALUES(`estado`),
  `total`=VALUES(`total`);

-- Detalle pedido
INSERT INTO `detalle_pedido` (`id_detalle`,`id_pedido`,`id_producto`,`cantidad`,`precio_unitario`) VALUES
(1,1,1,1,29.99),
(2,1,3,1,2.50),
(3,2,2,2,14.99),
(4,2,4,1,19.99)
ON DUPLICATE KEY UPDATE
  `id_pedido`=VALUES(`id_pedido`),
  `id_producto`=VALUES(`id_producto`),
  `cantidad`=VALUES(`cantidad`),
  `precio_unitario`=VALUES(`precio_unitario`);

-- Carrito
INSERT INTO `carrito` (`id_carrito`,`id_usuario`,`id_producto`,`cantidad`,`fecha_agregado`) VALUES
(1,1,2,1,'2025-10-09 11:31:30'),
(2,2,3,2,'2025-10-09 11:31:30'),
(3,1,2,1,'2025-10-16 18:01:08'),
(4,2,3,2,'2025-10-16 18:01:08')
ON DUPLICATE KEY UPDATE
  `id_usuario`=VALUES(`id_usuario`),
  `id_producto`=VALUES(`id_producto`),
  `cantidad`=VALUES(`cantidad`),
  `fecha_agregado`=VALUES(`fecha_agregado`);

COMMIT;

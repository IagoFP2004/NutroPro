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
  -- macros
  `proteinas`     INT DEFAULT 0,
  `carbohidratos` INT DEFAULT 0,
  `grasas`        INT DEFAULT 0,
  -- atributos de ropa
  `color`         VARCHAR(50)  DEFAULT NULL,
  `material`      VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `idx_productos_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Asegurar columnas si la tabla ya existía
ALTER TABLE `productos`
  ADD COLUMN IF NOT EXISTS `proteinas`     INT DEFAULT 0 AFTER `imagen_url`,
  ADD COLUMN IF NOT EXISTS `carbohidratos` INT DEFAULT 0 AFTER `proteinas`,
  ADD COLUMN IF NOT EXISTS `grasas`        INT DEFAULT 0 AFTER `carbohidratos`,
  ADD COLUMN IF NOT EXISTS `color`         VARCHAR(50)  DEFAULT NULL AFTER `grasas`,
  ADD COLUMN IF NOT EXISTS `material`      VARCHAR(100) DEFAULT NULL AFTER `color`,
  MODIFY `destacado` INT NOT NULL DEFAULT 0;

-- (Opcional) Índices útiles para filtros en tienda
CREATE INDEX IF NOT EXISTS `idx_productos_color`   ON `productos`(`color`);
CREATE INDEX IF NOT EXISTS `idx_productos_material` ON `productos`(`material`);

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
-- Foreign Keys (solo si faltan)
-- =========================
SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_productos_categorias'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `productos` ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias`(`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_pedidos_usuarios'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `pedidos` ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_detalle_pedido_pedidos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `detalle_pedido` ADD CONSTRAINT `fk_detalle_pedido_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos`(`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_detalle_pedido_productos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `detalle_pedido` ADD CONSTRAINT `fk_detalle_pedido_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id_producto`) ON DELETE RESTRICT ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_carrito_usuarios'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `carrito` ADD CONSTRAINT `fk_carrito_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @missing_fk := (
  SELECT COUNT(*) = 0 FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_carrito_productos'
);
SET @sql := IF(@missing_fk,
  'ALTER TABLE `carrito` ADD CONSTRAINT `fk_carrito_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE',
  'SELECT 1'); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- =========================
-- Datos semilla (idempotentes)
-- ============

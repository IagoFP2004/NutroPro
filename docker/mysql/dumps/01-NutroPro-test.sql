-- 002-nutropro-test-init.sql
-- MySQL 8.x
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `nutropro_test`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;

USE `nutropro_test`;

START TRANSACTION;

-- =========================
-- Tablas base (mismas que en nutropro)
-- =========================

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id_usuario` INT NOT NULL AUTO_INCREMENT,
    `nombre`     VARCHAR(100) NOT NULL,
    `email`      VARCHAR(100) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `direccion`  VARCHAR(255) DEFAULT NULL,
    `telefono`   VARCHAR(20)  DEFAULT NULL,
    `fecha_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `id_rol`     INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id_usuario`),
    UNIQUE KEY `uq_usuarios_email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `categorias` (
    `id_categoria` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    `descripcion`  TEXT,
    PRIMARY KEY (`id_categoria`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `productos` (
    `id_producto`  INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
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
    `talla`         VARCHAR(20)  DEFAULT NULL,
    `color`         VARCHAR(50)  DEFAULT NULL,
    `material`      VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id_producto`),
    KEY `idx_productos_categoria` (`id_categoria`),
    CONSTRAINT `fk_productos_categoria_test` FOREIGN KEY (`id_categoria`)
    REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `pedidos` (
    `id_pedido`    INT NOT NULL AUTO_INCREMENT,
    `id_usuario`   INT DEFAULT NULL,
    `fecha_pedido` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `estado` VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    `total` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id_pedido`),
    KEY `idx_pedidos_usuario` (`id_usuario`),
    CONSTRAINT `fk_pedidos_usuario_test` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
    `id_detalle` INT NOT NULL AUTO_INCREMENT,
    `id_pedido` INT DEFAULT NULL,
    `id_producto` INT DEFAULT NULL,
    `cantidad` INT NOT NULL,
    `precio_unitario` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id_detalle`),
    KEY `idx_detalle_pedido` (`id_pedido`),
    KEY `idx_detalle_producto` (`id_producto`),
    CONSTRAINT `fk_detalle_pedido_test` FOREIGN KEY (`id_pedido`)
    REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
    CONSTRAINT `fk_detalle_producto_test` FOREIGN KEY (`id_producto`)
    REFERENCES `productos` (`id_producto`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `carrito` (
    `id_carrito` INT NOT NULL AUTO_INCREMENT,
    `id_usuario` INT DEFAULT NULL,
    `id_producto` INT DEFAULT NULL,
    `cantidad` INT NOT NULL DEFAULT '1',
    `fecha_agregado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_carrito`),
    KEY `idx_carrito_usuario` (`id_usuario`),
    KEY `idx_carrito_producto` (`id_producto`),
    CONSTRAINT `fk_carrito_usuario_test` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
    CONSTRAINT `fk_carrito_producto_test` FOREIGN KEY (`id_producto`)
    REFERENCES `productos` (`id_producto`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `resenas` (
    `id_reseña` INT NOT NULL AUTO_INCREMENT,
    `id_usuario` INT NOT NULL,
    `valoracion` INT NOT NULL,
    `comentario` VARCHAR(255) NOT NULL,
    `fecha_coment` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_reseña`),
    KEY `idx_resenas_usuario` (`id_usuario`),
    CONSTRAINT `fk_resenas_usuario_test` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
    CONSTRAINT `chk_valoracion_test` CHECK ((`valoracion` >= 1) AND (`valoracion` <= 5))
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

COMMIT;

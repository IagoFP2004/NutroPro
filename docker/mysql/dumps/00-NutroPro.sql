-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Servidor: myproject-mysql
-- Tiempo de generación: 2025-10-19 16:39:32
-- Versión del servidor: 8.4.6
-- Versión de PHP: 8.2.27

CREATE DATABASE IF NOT EXISTS `nutropro` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `nutropro`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Tabla: carrito
-- --------------------------------------------------------
CREATE TABLE `carrito` (
  `id_carrito` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `fecha_agregado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carrito`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `id_producto`, `cantidad`, `fecha_agregado`) VALUES
(1, 1, 2, 1, '2025-10-09 11:31:30'),
(2, 2, 3, 2, '2025-10-09 11:31:30'),
(3, 1, 2, 1, '2025-10-16 18:01:08'),
(4, 2, 3, 2, '2025-10-16 18:01:08');

-- --------------------------------------------------------
-- Tabla: categorias
-- --------------------------------------------------------
CREATE TABLE `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas', 'Suplementos de proteínas en polvo y batidos'),
(2, 'Vitaminas', 'Vitaminas y minerales esenciales'),
(3, 'Snacks', 'Barras y snacks saludables'),
(4, 'Ropa', 'Ropa deportiva y accesorios'),
(5, 'Accesorios', 'Accesorios para entrenar y suplementación');

-- --------------------------------------------------------
-- Tabla: detalle_pedido
-- --------------------------------------------------------
CREATE TABLE `detalle_pedido` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 1, 29.99),
(2, 1, 3, 1, 2.50),
(3, 2, 2, 2, 14.99),
(4, 2, 4, 1, 19.99);

-- --------------------------------------------------------
-- Tabla: pedidos
-- --------------------------------------------------------
CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `fecha_pedido` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `estado`, `total`) VALUES
(1, 1, '2025-10-09 11:31:30', 'pendiente', 32.49),
(2, 2, '2025-10-09 11:31:30', 'pagado', 44.98);

-- --------------------------------------------------------
-- Tabla: productos
-- --------------------------------------------------------
CREATE TABLE `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `stock` int DEFAULT '0',
  `id_categoria` int DEFAULT NULL,
  `destacado` int NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `proteinas` int DEFAULT NULL,
  `carbohidratos` int DEFAULT NULL,
  `grasas` int DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`) VALUES
(1, 'Proteína Whey 1kg Vainilla', 'Proteína de suero de leche sabor chocolate', 29.99, 50, 1, 1, 'ChatGPT Image 9 oct 2025, 16_52_32.png', 0, 0, 0),
(2, 'Pack de suplementación NutroPro', 'Pack con la mejor suplementación diaria para mantener la salud', 14.99, 100, 2, 0, 'img_68ef4b9c90a1c8.30665722.png', 0, 0, 0),
(3, 'Barrita proteica', 'Barras de avena y proteína', 2.50, 200, 3, 0, 'img_68efbd6b0bca56.85626268.png', 0, 0, 0),
(4, 'Sudadera Deportiva Negra', 'Sudadera deportiva para entrenar con estilo y comodidad', 19.99, 75, 4, 0, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 0, 0, 0),
(7, 'Shaker', NULL, 6.00, 500, 5, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png', 0, 0, 0),
(10, 'Creatina Monohidrate', 'Mejora tu fuerza y energía en entrenamientos intensos. Ideal para potencia, recuperación y rendimiento muscular rápido.', 15.00, 500, 1, 0, 'img_68f166d86522f0.78190263.png', 5, 15, 5);

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `direccion`, `telefono`, `fecha_registro`) VALUES
(1, 'Juan Pérez', 'juan@example.com', '1234', 'Calle Falsa 123', '600123456', '2025-10-09 11:31:30'),
(2, 'Ana Gómez', 'ana@example.com', '1234', 'Avenida Siempre Viva 456', '600654321', '2025-10-09 11:31:30');

-- --------------------------------------------------------
-- Relaciones (Foreign Keys)
-- --------------------------------------------------------
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `fk_carrito_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedido_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_detalle_pedido_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

COMMIT;

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
  `id_rol`     INT NOT NULL DEFAULT 0,
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
  `talla`         VARCHAR(20)  DEFAULT NULL,
  `color`         VARCHAR(50)  DEFAULT NULL,
  `material`      VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `idx_productos_categoria` (`id_categoria`),
  CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido`    INT NOT NULL AUTO_INCREMENT,
  `id_usuario`   INT DEFAULT NULL,
  `fecha_pedido` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `estado`       VARCHAR(50) NOT NULL DEFAULT 'pendiente',
  `total`        DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `idx_pedidos_usuario` (`id_usuario`),
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detalle`       INT NOT NULL AUTO_INCREMENT,
  `id_pedido`        INT DEFAULT NULL,
  `id_producto`      INT DEFAULT NULL,
  `cantidad`         INT NOT NULL,
  `precio_unitario`  DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `idx_detalle_pedido` (`id_pedido`),
  KEY `idx_detalle_producto` (`id_producto`),
  CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE SET NULL
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
  CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `fk_carrito_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `reseñas` (
  `id_reseña` INT NOT NULL AUTO_INCREMENT,
  `id_producto` INT DEFAULT NULL,
  `id_usuario` INT DEFAULT NULL,
  `calificacion` INT NOT NULL,
  `comentario` TEXT,
  `fecha_reseña` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reseña`),
  KEY `idx_reseñas_producto` (`id_producto`),
  KEY `idx_reseñas_usuario` (`id_usuario`),
  CONSTRAINT `fk_reseñas_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  CONSTRAINT `fk_reseñas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `chk_calificacion` CHECK ((`calificacion` >= 1) AND (`calificacion` <= 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- =========================
-- Datos iniciales
-- =========================

-- Insertar categorías
INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas', 'Suplementos de proteína para el desarrollo muscular'),
(2, 'Suplementos', 'Vitaminas, minerales y otros suplementos nutricionales'),
(3, 'Snacks', 'Snacks saludables y barritas energéticas'),
(4, 'Ropa', 'Ropa deportiva y de entrenamiento'),
(5, 'Accesorios', 'Accesorios para el gimnasio y entrenamiento');

-- Insertar usuarios
INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `direccion`, `telefono`, `fecha_registro`, `id_rol`) VALUES
(1, 'Admin Usuario', 'admin@nutropro.com', '$2y$10$Fb8zTfCpd2PevmiMcN2SuOkkTpg3j9AonfQ./.hppH1a0T6.WtjYC', 'Calle Principal 123, Madrid', '600123456', '2025-10-29 07:32:53', 1),
(2, 'Juan Pérez', 'juan.perez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Avenida Libertad 45, Barcelona', '611234567', '2025-10-29 07:32:53', 0),
(3, 'María García', 'maria.garcia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Plaza Mayor 8, Valencia', '622345678', '2025-10-29 07:32:53', 0),
(4, 'Carlos López', 'carlos.lopez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Calle Nueva 67, Sevilla', '633456789', '2025-10-29 07:32:53', 0),
(5, 'IagoFP', 'iagofranciscoperez@gmail.com', '$2y$10$SYpzm45LrQRuXNnbmaZvCeh0tOTY0p5oOrrki.D.nzOvM7kLZumu.', 'San Lorenzo de Oliveira Barrio de Souto 16', '642513802', '2025-10-29 14:09:12', 0),
(6, 'Iago Francisco Perez', 'iagofranciscoperez123@gmail.com', '$2y$10$d5rhPKVLCCO5oVpXDbXSwu6oGrXiRZgKGd5BQ7SXYlQ8F17KFkKNe', 'San Lorenzo de Oliveira Barrio de Souto 16', '642513803', '2025-11-04 09:27:11', 0),
(10, 'Usuario Prueba', 'usuariodePrueba@gmail.com', '$2y$10$EuCX8rvAdxvgSqU9PnwVROxo7Tle6fXNsPiDA8CUzcuyY3BPk6rk6', 'Mi casa', '621739201', '2025-11-05 15:12:22', 1);

-- Insertar productos
INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`, `talla`, `color`, `material`) VALUES
(1, 'Whey Protein Isolate', 'Proteína de suero aislada de alta calidad, perfecta para aumentar masa muscular. 90% de proteína pura.', 45.99, 150, 1, 1, 'ChatGPT Image 9 oct 2025, 13_50_44.png', 90, 3, 2, NULL, NULL, NULL),
(2, 'Whey Protein Concentrate', 'Proteína de suero concentrada con excelente sabor a chocolate. Ideal post-entrenamiento.', 35.99, 200, 1, 1, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 80, 8, 5, NULL, NULL, NULL),
(4, 'Proteína Vegana', 'Mezcla de proteínas vegetales (guisante, arroz, hemp). 100% vegano y sin lactosa.', 38.99, 120, 1, 1, 'ChatGPT Image 9 oct 2025, 15_49_15.png', 75, 12, 6, NULL, NULL, NULL),
(6, 'Pre-Workout Extreme', 'Pre-entreno con cafeína, beta-alanina y citrulina para máxima energía y bombeo muscular.', 29.99, 180, 2, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png', 2, 15, 0, NULL, NULL, NULL),
(7, 'BCAA 2:1:1', 'Aminoácidos ramificados para recuperación muscular. Sabor limón refrescante.', 24.99, 220, 2, 0, 'ChatGPT Image 9 oct 2025, 16_52_32.png', 8, 2, 0, NULL, NULL, NULL),
(8, 'Multivitamínico Completo', 'Complejo vitamínico con 25 vitaminas y minerales esenciales. Una cápsula al día.', 15.99, 250, 2, 0, 'ChatGPT Image 13 oct 2025, 16_50_23.png', 0, 5, 0, NULL, NULL, NULL),
(9, 'Barritas Proteicas Chocolate', 'Pack de 12 barritas con 20g de proteína cada una. Sabor chocolate intenso.', 24.99, 150, 3, 0, 'ChatGPT Image 13 oct 2025, 17_01_29.png', 20, 25, 8, NULL, NULL, NULL),
(11, 'Mantequilla de Cacahuete', 'Mantequilla 100% natural sin azúcares añadidos. Rica en proteínas y grasas saludables.', 8.99, 180, 3, 0, 'img_68ef4b9c90a1c8.30665722.png', 25, 15, 50, NULL, NULL, NULL),
(14, 'Mallas Deportivas Mujer', 'Mallas de compresión con cintura alta. Diseño ergonómico y gran comodidad.', 34.99, 80, 4, 1, 'img_68efbd6b0bca56.85626268.png', 0, 0, 0, 'L', 'Azul Marino', 'Nylon 80% Spandex 20%'),
(15, 'Pantalón Jogger Hombre', 'Pantalón deportivo con ajuste cómodo y bolsillos. Ideal para gimnasio o casual.', 39.99, 60, 4, 1, 'nano-banana-2025-10-13T14-46-54.png', 0, 0, 0, 'XL', 'Gris', 'Algodón 70% Poliéster 30%'),
(16, 'Sudadera con Capucha', 'Sudadera térmica perfecta para calentamiento. Con capucha ajustable y bolsillo canguro.', 44.99, 50, 4, 1, 'ChatGPT Image 9 oct 2025, 13_50_44.png', 0, 0, 0, 'L', 'Negro', 'Algodón 80% Poliéster 20%'),
(17, 'Top Deportivo Mujer', 'Sujetador deportivo de alto impacto con soporte reforzado. Transpirable y cómodo.', 29.99, 70, 4, 1, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 0, 0, 0, 'M', 'Rosa', 'Poliamida 85% Elastano 15%'),
(19, 'Shaker Profesional 700ml', 'Mezclador de proteínas con bola mezcladora y compartimento para suplementos. Libre de BPA.', 9.99, 250, 5, 0, 'ChatGPT Image 9 oct 2025, 15_49_15.png', 0, 0, 0, NULL, NULL, NULL),
(21, 'Banda Elástica Resistencia', 'Set de 5 bandas de resistencia con diferentes niveles. Incluye anclajes y bolsa de transporte.', 19.99, 150, 5, 0, 'ChatGPT Image 9 oct 2025, 16_43_32.png', 0, 0, 0, NULL, NULL, NULL),
(22, 'Botella de Agua 1L', 'Botella deportiva con marcador de hidratación. Aislada térmicamente, mantiene frío 24h.', 16.99, 200, 5, 0, 'ChatGPT Image 9 oct 2025, 16_52_32.png', 0, 0, 0, NULL, NULL, NULL),
(23, 'Toalla Microfibra', 'Toalla ultra absorbente y de secado rápido. Perfecta para el gimnasio. 80x40cm.', 12.99, 180, 5, 0, 'ChatGPT Image 13 oct 2025, 16_50_23.png', 0, 0, 0, NULL, NULL, NULL),
(24, 'Cinturón Lumbar', 'Cinturón de soporte lumbar para levantamiento pesado. Ajustable y ergonómico.', 29.99, 80, 5, 0, 'ChatGPT Image 13 oct 2025, 17_01_29.png', 0, 0, 0, NULL, NULL, NULL),
(25, 'Creatina Monohidratada ', 'Creatina de la mas alta calidad', 15.00, 200, 1, 0, 'img_69023e1befe772.98130851.png', 5, 10, 5, NULL, NULL, NULL);

-- Insertar pedidos
INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `estado`, `total`) VALUES
(19, 5, '2025-11-04 15:54:29', 'pendiente', 115.47),
(20, 6, '2025-11-05 15:17:04', 'pendiente', 43.49);

-- Insertar detalles de pedidos
INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(3, 19, 14, 1, 34.99),
(4, 19, 15, 1, 39.99),
(5, 19, 2, 1, 35.99),
(6, 20, 4, 1, 38.99);

COMMIT;

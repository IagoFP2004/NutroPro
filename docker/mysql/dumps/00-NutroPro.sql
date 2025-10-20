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
  KEY `idx_productos_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
-- =========================

-- Insertar usuarios de ejemplo
-- Nota: Contraseña del admin: 'abc123.' | Contraseña de otros usuarios: 'password'
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `direccion`, `telefono`, `id_rol`) VALUES
('Admin Usuario', 'admin@nutropro.com', '$2y$10$Fb8zTfCpd2PevmiMcN2SuOkkTpg3j9AonfQ./.hppH1a0T6.WtjYC', 'Calle Principal 123, Madrid', '600123456', 1),
('Juan Pérez', 'juan.perez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Avenida Libertad 45, Barcelona', '611234567', 0),
('María García', 'maria.garcia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Plaza Mayor 8, Valencia', '622345678', 0),
('Carlos López', 'carlos.lopez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Calle Nueva 67, Sevilla', '633456789', 0)
ON DUPLICATE KEY UPDATE nombre=nombre;

-- Insertar categorías
INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Proteínas', 'Suplementos de proteína para el desarrollo muscular'),
(2, 'Suplementos', 'Vitaminas, minerales y otros suplementos nutricionales'),
(3, 'Snacks', 'Snacks saludables y barritas energéticas'),
(4, 'Ropa', 'Ropa deportiva y de entrenamiento'),
(5, 'Accesorios', 'Accesorios para el gimnasio y entrenamiento')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), descripcion=VALUES(descripcion);

-- Insertar productos de PROTEÍNAS (categoría 1)
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`) VALUES
('Whey Protein Isolate', 'Proteína de suero aislada de alta calidad, perfecta para aumentar masa muscular. 90% de proteína pura.', 45.99, 150, 1, 1, 'ChatGPT Image 9 oct 2025, 13_50_44.png', 90, 3, 2),
('Whey Protein Concentrate', 'Proteína de suero concentrada con excelente sabor a chocolate. Ideal post-entrenamiento.', 35.99, 200, 1, 1, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 80, 8, 5),
('Caseína Micelar', 'Proteína de absorción lenta, ideal para tomar antes de dormir. Mantiene los músculos nutridos toda la noche.', 42.50, 100, 1, 0, 'ChatGPT Image 9 oct 2025, 15_16_14.png', 85, 4, 1),
('Proteína Vegana', 'Mezcla de proteínas vegetales (guisante, arroz, hemp). 100% vegano y sin lactosa.', 38.99, 120, 1, 1, 'ChatGPT Image 9 oct 2025, 15_49_15.png', 75, 12, 6)
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Insertar productos de SUPLEMENTOS (categoría 2)
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`) VALUES
('Creatina Monohidratada', 'Creatina pura micronizada para aumentar fuerza y potencia. 5g por porción.', 19.99, 300, 2, 1, 'ChatGPT Image 9 oct 2025, 16_31_30.png', 0, 0, 0),
('Pre-Workout Extreme', 'Pre-entreno con cafeína, beta-alanina y citrulina para máxima energía y bombeo muscular.', 29.99, 180, 2, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png', 2, 15, 0),
('BCAA 2:1:1', 'Aminoácidos ramificados para recuperación muscular. Sabor limón refrescante.', 24.99, 220, 2, 0, 'ChatGPT Image 9 oct 2025, 16_52_32.png', 8, 2, 0),
('Multivitamínico Completo', 'Complejo vitamínico con 25 vitaminas y minerales esenciales. Una cápsula al día.', 15.99, 250, 2, 0, 'ChatGPT Image 13 oct 2025, 16_50_23.png', 0, 5, 0)
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Insertar productos de SNACKS (categoría 3)
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `proteinas`, `carbohidratos`, `grasas`) VALUES
('Barritas Proteicas Chocolate', 'Pack de 12 barritas con 20g de proteína cada una. Sabor chocolate intenso.', 24.99, 150, 3, 1, 'ChatGPT Image 13 oct 2025, 17_01_29.png', 20, 25, 8),
('Galletas Proteicas', 'Galletas crujientes con 15g de proteína. Perfectas para un snack entre comidas.', 12.99, 200, 3, 0, 'ChatGPT Image 15 oct 2025, 17_16_43.png', 15, 30, 10),
('Mantequilla de Cacahuete', 'Mantequilla 100% natural sin azúcares añadidos. Rica en proteínas y grasas saludables.', 8.99, 180, 3, 1, 'img_68ef4b9c90a1c8.30665722.png', 25, 15, 50),
('Chips de Proteína BBQ', 'Chips crujientes altos en proteína y bajos en carbohidratos. Sabor BBQ ahumado.', 3.99, 300, 3, 0, 'img_68efad827ef610.06845329.jpeg', 18, 12, 5)
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Insertar productos de ROPA (categoría 4) - CON TALLA, COLOR Y MATERIAL
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`, `talla`, `color`, `material`) VALUES
('Camiseta Técnica Transpirable', 'Camiseta deportiva de alto rendimiento con tecnología anti-sudor. Perfecta para entrenamientos intensos.', 24.99, 100, 4, 1, 'img_68efb97600f074.28991256.jpeg', 'M', 'Negro', 'Poliéster 92% Elastano 8%'),
('Mallas Deportivas Mujer', 'Mallas de compresión con cintura alta. Diseño ergonómico y gran comodidad.', 34.99, 80, 4, 1, 'img_68efbd6b0bca56.85626268.png', 'L', 'Azul Marino', 'Nylon 80% Spandex 20%'),
('Pantalón Jogger Hombre', 'Pantalón deportivo con ajuste cómodo y bolsillos. Ideal para gimnasio o casual.', 39.99, 60, 4, 0, 'nano-banana-2025-10-13T14-46-54.png', 'XL', 'Gris', 'Algodón 70% Poliéster 30%'),
('Sudadera con Capucha', 'Sudadera térmica perfecta para calentamiento. Con capucha ajustable y bolsillo canguro.', 44.99, 50, 4, 1, 'ChatGPT Image 9 oct 2025, 13_50_44.png', 'L', 'Negro', 'Algodón 80% Poliéster 20%'),
('Top Deportivo Mujer', 'Sujetador deportivo de alto impacto con soporte reforzado. Transpirable y cómodo.', 29.99, 70, 4, 0, 'ChatGPT Image 9 oct 2025, 15_02_05.png', 'M', 'Rosa', 'Poliamida 85% Elastano 15%'),
('Shorts Running Hombre', 'Pantalón corto ultra ligero con tecnología quick-dry. Perfecto para running.', 22.99, 90, 4, 0, 'ChatGPT Image 9 oct 2025, 15_16_14.png', 'L', 'Azul', 'Poliéster 100%')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Insertar productos de ACCESORIOS (categoría 5)
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`, `id_categoria`, `destacado`, `imagen_url`) VALUES
('Shaker Profesional 700ml', 'Mezclador de proteínas con bola mezcladora y compartimento para suplementos. Libre de BPA.', 9.99, 250, 5, 0, 'ChatGPT Image 9 oct 2025, 15_49_15.png'),
('Guantes de Entrenamiento', 'Guantes acolchados para levantamiento de pesas. Protección y agarre mejorado.', 14.99, 120, 5, 0, 'ChatGPT Image 9 oct 2025, 16_31_30.png'),
('Banda Elástica Resistencia', 'Set de 5 bandas de resistencia con diferentes niveles. Incluye anclajes y bolsa de transporte.', 19.99, 150, 5, 1, 'ChatGPT Image 9 oct 2025, 16_43_32.png'),
('Botella de Agua 1L', 'Botella deportiva con marcador de hidratación. Aislada térmicamente, mantiene frío 24h.', 16.99, 200, 5, 0, 'ChatGPT Image 9 oct 2025, 16_52_32.png'),
('Toalla Microfibra', 'Toalla ultra absorbente y de secado rápido. Perfecta para el gimnasio. 80x40cm.', 12.99, 180, 5, 0, 'ChatGPT Image 13 oct 2025, 16_50_23.png'),
('Cinturón Lumbar', 'Cinturón de soporte lumbar para levantamiento pesado. Ajustable y ergonómico.', 29.99, 80, 5, 1, 'ChatGPT Image 13 oct 2025, 17_01_29.png')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

COMMIT;

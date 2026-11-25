-- Script de base de datos para Sistema de Inventario
-- Aplicaciones Web - Unidad IV

CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventario_db;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos iniciales
INSERT INTO productos (nombre, categoria, descripcion, cantidad) VALUES
('Lápiz', 'Papelería', 'Lápiz de grafito HB', 120),
('Cuaderno', 'Papelería', 'Cuaderno profesional raya 100 hojas', 50),
('Borrador', 'Papelería', 'Borrador blanco de migajón', 35),
('Regla', 'Papelería', 'Regla de plástico transparente 30cm', 40);

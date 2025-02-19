-- ============================================================
-- Script para la creación de la base de datos y tablas
-- ============================================================

-- 1. Creación de la base de datos
DROP DATABASE IF EXISTS tienda_ropa;
CREATE DATABASE tienda_ropa;
USE tienda_ropa;

-- Desactivar claves foráneas para evitar conflictos al eliminar tablas existentes
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS detalle_ventas;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS prendas;
DROP TABLE IF EXISTS marcas;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- 2. Creación de tablas

-- Tabla de usuarios (empleados/vendedores) con contraseña
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    rol ENUM('vendedor', 'admin') NOT NULL,
    contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    direccion TEXT
) ENGINE=InnoDB;

-- Tabla de marcas
CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabla de prendas
CREATE TABLE prendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_marca INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    stock INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_marca) REFERENCES marcas(id)
) ENGINE=InnoDB;

-- Tabla de ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_vendedor INT NOT NULL,
    fecha DATE NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id),
    FOREIGN KEY (id_vendedor) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- Tabla de detalle de ventas
CREATE TABLE detalle_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_prenda INT NOT NULL,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_prenda) REFERENCES prendas(id)
) ENGINE=InnoDB;

-- ============================================================
-- Fin del script de creación
-- ============================================================

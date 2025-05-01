-- ============================================================
-- Script para agregar columnas de imágenes
-- ============================================================

-- Agregar columna imagen_url a la tabla Prendas
ALTER TABLE Prendas
ADD COLUMN imagen_url VARCHAR(255);  -- Columna para almacenar el enlace de la imagen de la prenda

-- Agregar columna logo_url a la tabla Marcas
ALTER TABLE Marcas
ADD COLUMN logo_url VARCHAR(255);  -- Columna para almacenar el enlace del logo de la marca

-- ============================================================
-- Fin del script para agregar columnas de imágenes
-- ============================================================
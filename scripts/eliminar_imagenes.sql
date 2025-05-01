-- ============================================================
-- Script para eliminar columnas de imágenes
-- ============================================================

-- Eliminar columna imagen_url de la tabla Prendas
ALTER TABLE Prendas
DROP COLUMN imagen_url;  -- Eliminar la columna que almacena el enlace de la imagen de la prenda

-- Eliminar columna logo_url de la tabla Marcas
ALTER TABLE Marcas
DROP COLUMN logo_url;  -- Eliminar la columna que almacena el enlace del logo de la marca

-- ============================================================
-- Fin del script para eliminar columnas de imágenes
-- ============================================================
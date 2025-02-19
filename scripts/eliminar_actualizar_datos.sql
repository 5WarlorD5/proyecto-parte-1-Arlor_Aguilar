-- ============================================================
-- Script para eliminar y actualizar datos
-- ============================================================

-- Eliminar un cliente por ID
DELETE FROM clientes WHERE id = 4;  -- Cambiar por el ID del cliente que desea eliminar

-- Actualizar el stock de una prenda
UPDATE prendas SET stock = 35 WHERE id = 3;  -- Cambiar por el ID de la prenda y el nuevo stock

-- Actualizar el precio de una prenda
UPDATE prendas SET precio = 12994.00 WHERE id = 2;  -- Cambiar por el ID de la prenda y el nuevo precio

-- ============================================================
-- Fin del script de eliminación y actualización
-- ============================================================

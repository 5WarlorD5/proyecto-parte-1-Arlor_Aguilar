-- ============================================================
-- Script para consultas y select
-- ============================================================

-- Consulta i: Obtener la cantidad vendida de prendas por fecha y fíltrala con una fecha específica
SELECT p.nombre AS prenda, SUM(dv.cantidad) AS cantidad_vendida, v.fecha
FROM detalle_ventas dv
JOIN ventas v ON dv.id_venta = v.id
JOIN prendas p ON dv.id_prenda = p.id
WHERE v.fecha = '2024-06-01'  -- Se puede cambiar por la fecha deseada
GROUP BY p.nombre, v.fecha;

-- ============================================================
-- Fin de las consultas
-- ============================================================

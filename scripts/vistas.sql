-- ============================================================
-- Script para crear vistas
-- ============================================================

-- Vista 1: Lista de todas las marcas que tienen al menos una venta
DROP VIEW IF EXISTS v_marcas_con_ventas;
CREATE VIEW v_marcas_con_ventas AS
SELECT DISTINCT m.id, m.nombre
FROM marcas m
JOIN prendas p ON m.id = p.id_marca
JOIN detalle_ventas dv ON p.id = dv.id_prenda;

-- Vista 2: Prendas vendidas y su cantidad restante en stock
DROP VIEW IF EXISTS v_prendas_stock;
CREATE VIEW v_prendas_stock AS
SELECT p.id, p.nombre, p.stock - IFNULL(v.total_vendido, 0) AS stock_restante
FROM prendas p
LEFT JOIN (
    SELECT id_prenda, SUM(cantidad) AS total_vendido
    FROM detalle_ventas
    GROUP BY id_prenda
) v ON p.id = v.id_prenda;

-- Vista 3: Listado de las 5 marcas más vendidas y su cantidad de ventas
DROP VIEW IF EXISTS v_top5_marcas;
CREATE VIEW v_top5_marcas AS
SELECT m.id, m.nombre, SUM(dv.cantidad) AS total_ventas
FROM marcas m
JOIN prendas p ON m.id = p.id_marca
JOIN detalle_ventas dv ON p.id = dv.id_prenda
GROUP BY m.id, m.nombre;

-- Para obtener las 5 marcas más vendidas, ejecutar:
-- SELECT * FROM v_top5_marcas ORDER BY total_ventas DESC LIMIT 5;

-- ============================================================
-- Fin del script de vistas
-- ============================================================

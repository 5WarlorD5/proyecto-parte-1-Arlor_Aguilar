<?php
require_once __DIR__ . '/../models/Marca.php';
require_once __DIR__ . '/../models/Prenda.php';
require_once __DIR__ . '/../models/DetalleVenta.php';

class ReporteController {
    public static function getMarcasConVentas() {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT DISTINCT m.id, m.nombre 
                              FROM marcas m 
                              JOIN prendas p ON m.id = p.id_marca 
                              JOIN detalle_ventas dv ON p.id = dv.id_prenda");
            $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($marcas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getPrendasStock() {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT p.id, p.nombre, p.stock - IFNULL(v.total_vendido, 0) AS stock_restante
                               FROM prendas p
                               LEFT JOIN (
                                   SELECT id_prenda, SUM(cantidad) AS total_vendido
                                   FROM detalle_ventas
                                   GROUP BY id_prenda
                               ) v ON p.id = v.id_prenda");
            $prendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($prendas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getTop5Marcas() {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT m.id, m.nombre, SUM(dv.cantidad) AS total_ventas
                               FROM marcas m
                               JOIN prendas p ON m.id = p.id_marca
                               JOIN detalle_ventas dv ON p.id = dv.id_prenda
                               GROUP BY m.id, m.nombre
                               ORDER BY total_ventas DESC
                               LIMIT 5");
            $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($marcas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
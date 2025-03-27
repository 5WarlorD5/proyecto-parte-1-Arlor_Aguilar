<?php
require_once __DIR__ . '/../models/DetalleVenta.php';

class DetalleVentaController {
    public static function getAll() {
        try {
            $detalles = DetalleVenta::getAll();
            header('Content-Type: application/json');
            echo json_encode($detalles);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $detalle = DetalleVenta::getById($id);
            if ($detalle) {
                header('Content-Type: application/json');
                echo json_encode($detalle);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Detalle de venta no encontrado']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getByVentaId($ventaId) {
        try {
            $detalles = DetalleVenta::getByVentaId($ventaId);
            header('Content-Type: application/json');
            echo json_encode($detalles);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = DetalleVenta::create($data);
            header('Content-Type: application/json');
            echo json_encode(['id' => $id]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function update($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $affectedRows = DetalleVenta::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = DetalleVenta::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
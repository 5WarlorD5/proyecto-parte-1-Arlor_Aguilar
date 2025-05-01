<?php
require_once __DIR__ . '/../models/Venta.php';

class VentaController {
    public static function getAll() {
        try {
            $ventas = Venta::getAll();
            header('Content-Type: application/json');
            echo json_encode($ventas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $venta = Venta::getById($id);
            if ($venta) {
                header('Content-Type: application/json');
                echo json_encode($venta);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Venta no encontrada']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = Venta::create($data);
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
            $affectedRows = Venta::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = Venta::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
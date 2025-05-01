<?php
require_once __DIR__ . '/../models/Prenda.php';

class PrendaController {
    public static function getAll() {
        try {
            $prendas = Prenda::getAll();
            header('Content-Type: application/json');
            echo json_encode($prendas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $prenda = Prenda::getById($id);
            if ($prenda) {
                header('Content-Type: application/json');
                echo json_encode($prenda);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Prenda no encontrada']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = Prenda::create($data);
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
            $affectedRows = Prenda::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = Prenda::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
<?php
require_once __DIR__ . '/../models/Marca.php';

class MarcaController {
    public static function getAll() {
        try {
            $marcas = Marca::getAll();
            header('Content-Type: application/json');
            echo json_encode($marcas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $marca = Marca::getById($id);
            if ($marca) {
                header('Content-Type: application/json');
                echo json_encode($marca);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Marca no encontrada']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = Marca::create($data);
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
            $affectedRows = Marca::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = Marca::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    public static function getAll() {
        try {
            $clientes = Cliente::getAll();
            header('Content-Type: application/json');
            echo json_encode($clientes);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $cliente = Cliente::getById($id);
            if ($cliente) {
                header('Content-Type: application/json');
                echo json_encode($cliente);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Cliente no encontrado']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = Cliente::create($data);
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
            $affectedRows = Cliente::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = Cliente::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['affected_rows' => $affectedRows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    public static function getAll() {
        try {
            $usuarios = Usuario::getAll();
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getById($id) {
        try {
            $usuario = Usuario::getById($id);
            if ($usuario) {
                header('Content-Type: application/json');
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validar campos obligatorios
            if (empty($data['nombre']) || empty($data['email']) || empty($data['rol']) || empty($data['contrasena'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Todos los campos (nombre, email, rol, contrasena) son obligatorios']);
                return;
            }

            // Hashear la contraseña antes de guardarla
            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            
            $id = Usuario::create($data);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => 'Usuario creado correctamente',
                'id' => $id
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function update($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Si se envía contraseña, hashearla xd
            if (!empty($data['contrasena'])) {
                $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            }
            
            $affectedRows = Usuario::update($id, $data);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => 'Usuario actualizado correctamente',
                'affected_rows' => $affectedRows
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function delete($id) {
        try {
            $affectedRows = Usuario::delete($id);
            header('Content-Type: application/json');
            if ($affectedRows > 0) {
                echo json_encode([
                    'success' => 'Usuario eliminado correctamente',
                    'affected_rows' => $affectedRows
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario no encontrado o no se pudo eliminar']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
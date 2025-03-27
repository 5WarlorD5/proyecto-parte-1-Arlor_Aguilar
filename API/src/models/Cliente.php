<?php
require_once __DIR__ . '/../db/Database.php';

class Cliente {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO clientes (nombre, email, telefono, direccion) 
            VALUES (:nombre, :email, :telefono, :direccion)"
        );
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "UPDATE clientes SET 
            nombre = :nombre, 
            email = :email, 
            telefono = :telefono,
            direccion = :direccion
            WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
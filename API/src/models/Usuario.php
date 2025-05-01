<?php
require_once __DIR__ . '/../db/Database.php';

class Usuario {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO usuarios (nombre, email, rol, contrasena) 
            VALUES (:nombre, :email, :rol, :contrasena)"
        );
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':rol', $data['rol']);
        $stmt->bindParam(':contrasena', password_hash($data['contrasena'], PASSWORD_DEFAULT));
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "UPDATE usuarios SET 
            nombre = :nombre, 
            email = :email, 
            rol = :rol 
            WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':rol', $data['rol']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
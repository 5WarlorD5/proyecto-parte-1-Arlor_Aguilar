<?php
require_once __DIR__ . '/../db/Database.php';

class Marca {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM marcas")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM marcas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO marcas (nombre) 
            VALUES (:nombre)"
        );
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "UPDATE marcas SET 
            nombre = :nombre
            WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM marcas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
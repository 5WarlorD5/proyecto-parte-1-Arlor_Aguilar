<?php
require_once __DIR__ . '/../db/Database.php';

class Prenda {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT p.*, m.nombre as marca_nombre FROM prendas p JOIN marcas m ON p.id_marca = m.id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT p.*, m.nombre as marca_nombre FROM prendas p JOIN marcas m ON p.id_marca = m.id WHERE p.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO prendas (id_marca, nombre, stock, precio) 
            VALUES (:id_marca, :nombre, :stock, :precio)"
        );
        $stmt->bindParam(':id_marca', $data['id_marca'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "UPDATE prendas SET 
            id_marca = :id_marca,
            nombre = :nombre,
            stock = :stock,
            precio = :precio
            WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_marca', $data['id_marca'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM prendas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
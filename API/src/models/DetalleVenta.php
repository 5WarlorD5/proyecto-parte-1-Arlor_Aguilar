<?php
require_once __DIR__ . '/../db/Database.php';

class DetalleVenta {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT dv.*, p.nombre as prenda_nombre 
                          FROM detalle_ventas dv 
                          JOIN prendas p ON dv.id_prenda = p.id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT dv.*, p.nombre as prenda_nombre 
                             FROM detalle_ventas dv 
                             JOIN prendas p ON dv.id_prenda = p.id 
                             WHERE dv.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByVentaId($ventaId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT dv.*, p.nombre as prenda_nombre, p.precio as precio_unitario
                             FROM detalle_ventas dv 
                             JOIN prendas p ON dv.id_prenda = p.id 
                             WHERE dv.id_venta = :ventaId");
        $stmt->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO detalle_ventas (id_venta, id_prenda, cantidad, subtotal) 
            VALUES (:id_venta, :id_prenda, :cantidad, :subtotal)"
        );
        $stmt->bindParam(':id_venta', $data['id_venta'], PDO::PARAM_INT);
        $stmt->bindParam(':id_prenda', $data['id_prenda'], PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
        $stmt->bindParam(':subtotal', $data['subtotal']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "UPDATE detalle_ventas SET 
            id_venta = :id_venta,
            id_prenda = :id_prenda,
            cantidad = :cantidad,
            subtotal = :subtotal
            WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_venta', $data['id_venta'], PDO::PARAM_INT);
        $stmt->bindParam(':id_prenda', $data['id_prenda'], PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_INT);
        $stmt->bindParam(':subtotal', $data['subtotal']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM detalle_ventas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
<?php
require_once __DIR__ . '/../db/Database.php';

class Venta {
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT v.*, c.nombre as cliente_nombre, u.nombre as vendedor_nombre 
                          FROM ventas v 
                          JOIN clientes c ON v.id_cliente = c.id 
                          JOIN usuarios u ON v.id_vendedor = u.id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT v.*, c.nombre as cliente_nombre, u.nombre as vendedor_nombre 
                             FROM ventas v 
                             JOIN clientes c ON v.id_cliente = c.id 
                             JOIN usuarios u ON v.id_vendedor = u.id 
                             WHERE v.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance();
        $db->beginTransaction();
        
        try {
            // Insertar la venta
            $stmt = $db->prepare(
                "INSERT INTO ventas (id_cliente, id_vendedor, fecha, total) 
                VALUES (:id_cliente, :id_vendedor, :fecha, :total)"
            );
            $stmt->bindParam(':id_cliente', $data['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_vendedor', $data['id_vendedor'], PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $data['fecha']);
            $stmt->bindParam(':total', $data['total']);
            $stmt->execute();
            $ventaId = $db->lastInsertId();

            // Insertar detalles de venta
            foreach ($data['detalles'] as $detalle) {
                $stmt = $db->prepare(
                    "INSERT INTO detalle_ventas (id_venta, id_prenda, cantidad, subtotal) 
                    VALUES (:id_venta, :id_prenda, :cantidad, :subtotal)"
                );
                $stmt->bindParam(':id_venta', $ventaId, PDO::PARAM_INT);
                $stmt->bindParam(':id_prenda', $detalle['id_prenda'], PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt->bindParam(':subtotal', $detalle['subtotal']);
                $stmt->execute();

                // Actualizar stock
                $stmt = $db->prepare("UPDATE prendas SET stock = stock - :cantidad WHERE id = :id_prenda");
                $stmt->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt->bindParam(':id_prenda', $detalle['id_prenda'], PDO::PARAM_INT);
                $stmt->execute();
            }

            $db->commit();
            return $ventaId;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function update($id, $data) {
        // Implementación similar a create pero con actualización
        // Omitida por brevedad, pero seguiría el mismo patrón
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM ventas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
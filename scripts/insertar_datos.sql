-- ============================================================
-- Script para insertar datos en las tablas
-- ============================================================

-- Inserción de datos de ejemplo

-- Usuarios
INSERT INTO usuarios (nombre, email, rol, contrasena) VALUES 
('Juan Pérez', 'juan@tienda.com', 'vendedor', 'contraseña123'),
('Ana López', 'ana@tienda.com', 'admin', 'admin123');

-- Clientes
INSERT INTO clientes (nombre, email, telefono, direccion) VALUES 
('Carlos Ramírez', 'carlos@gmail.com', '8888-9999', 'Calle 123, Ciudad'),
('María González', 'maria@gmail.com', '7777-6666', 'Avenida 456, Ciudad'),
('Luis Fernández', 'luis@gmail.com', '6666-5555', 'Boulevard 789, Ciudad'),
('Andrea Rojas', 'andrea@gmail.com', '9999-3333', 'Residencial 101, Ciudad');

-- Marcas
INSERT INTO marcas (nombre) VALUES 
('Nike'),
('Adidas'),
('Puma'),
('Reebok'),
('Under Armour');

-- Prendas
INSERT INTO prendas (id_marca, nombre, stock, precio) VALUES 
(1, 'Camiseta Deportiva', 50, 11994.00),
(2, 'Pantalón Deportivo', 30, 17994.00),
(3, 'Zapatillas Running', 20, 29994.00),
(4, 'Chaqueta Impermeable', 25, 35994.00),
(5, 'Short de Entrenamiento', 40, 14994.00);

-- Ventas
INSERT INTO ventas (id_cliente, id_vendedor, fecha, total) VALUES 
(1, 1, '2024-06-01', 47982.00),  -- Venta de camisetas y pantalón
(2, 2, '2024-06-02', 44988.00),  -- Zapatillas y short
(3, 1, '2024-06-03', 29994.00),  -- Unas zapatillas
(4, 2, '2024-06-04', 71988.00);  -- Chaqueta y pantalón

-- Detalle de ventas
INSERT INTO detalle_ventas (id_venta, id_prenda, cantidad, subtotal) VALUES 
(1, 1, 2, 23988.00),  -- 2 camisetas deportivas (11994 * 2)
(1, 2, 1, 17994.00),  -- 1 pantalón deportivo (17994 * 1)
(2, 3, 1, 29994.00),  -- 1 zapatilla running (29994 * 1)
(2, 5, 1, 14994.00),  -- 1 short de entrenamiento (14994 * 1)
(3, 3, 1, 29994.00),  -- 1 zapatilla running (29994 * 1)
(4, 4, 1, 35994.00),  -- 1 chaqueta impermeable (35994 * 1)
(4, 2, 2, 35994.00);  -- 2 pantalones deportivos (17994 * 2)

-- ============================================================
-- Fin del script de inserción
-- ============================================================

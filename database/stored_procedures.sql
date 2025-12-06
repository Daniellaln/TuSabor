-- ============================================
-- PROCEDIMIENTOS ALMACENADOS PARA TUSABOR
-- ============================================

DELIMITER $$

-- 1. Procedimiento: Obtener productos disponibles por categoría
DROP PROCEDURE IF EXISTS sp_productos_por_categoria$$
CREATE PROCEDURE sp_productos_por_categoria(IN categoria_id_param INT)
BEGIN
    SELECT 
        p.id,
        p.nombre,
        p.descripcion,
        p.precio,
        p.imagen,
        p.destacado,
        c.nombre AS categoria_nombre
    FROM productos p
    INNER JOIN categorias c ON p.categoria_id = c.id
    WHERE p.categoria_id = categoria_id_param
      AND p.disponible = 1
      AND c.activo = 1
    ORDER BY p.destacado DESC, p.nombre ASC;
END$$

-- 2. Procedimiento: Calcular total del carrito de un usuario
DROP PROCEDURE IF EXISTS sp_calcular_total_carrito$$
CREATE PROCEDURE sp_calcular_total_carrito(IN user_id_param INT)
BEGIN
    SELECT 
        SUM(p.precio * c.cantidad) AS total,
        COUNT(c.id) AS total_items,
        SUM(c.cantidad) AS total_productos
    FROM carrito c
    INNER JOIN productos p ON c.producto_id = p.id
    WHERE c.user_id = user_id_param
      AND p.disponible = 1;
END$$

-- 3. Procedimiento: Obtener estadísticas de ventas por período
DROP PROCEDURE IF EXISTS sp_estadisticas_ventas$$
CREATE PROCEDURE sp_estadisticas_ventas(
    IN fecha_inicio DATE,
    IN fecha_fin DATE
)
BEGIN
    SELECT 
        DATE(p.created_at) AS fecha,
        COUNT(p.id) AS total_pedidos,
        SUM(p.total) AS total_ventas,
        AVG(p.total) AS promedio_venta,
        SUM(CASE WHEN p.estado = 'entregado' THEN 1 ELSE 0 END) AS pedidos_entregados,
        SUM(CASE WHEN p.estado = 'cancelado' THEN 1 ELSE 0 END) AS pedidos_cancelados
    FROM pedidos p
    WHERE DATE(p.created_at) BETWEEN fecha_inicio AND fecha_fin
    GROUP BY DATE(p.created_at)
    ORDER BY fecha DESC;
END$$

-- 4. Procedimiento: Obtener productos más vendidos
DROP PROCEDURE IF EXISTS sp_productos_mas_vendidos$$
CREATE PROCEDURE sp_productos_mas_vendidos(IN limite INT)
BEGIN
    SELECT 
        p.id,
        p.nombre,
        p.imagen,
        c.nombre AS categoria,
        SUM(dp.cantidad) AS total_vendido,
        SUM(dp.subtotal) AS ingresos_totales
    FROM detalle_pedidos dp
    INNER JOIN productos p ON dp.producto_id = p.id
    INNER JOIN categorias c ON p.categoria_id = c.id
    INNER JOIN pedidos ped ON dp.pedido_id = ped.id
    WHERE ped.estado != 'cancelado'
    GROUP BY p.id, p.nombre, p.imagen, c.nombre
    ORDER BY total_vendido DESC
    LIMIT limite;
END$$

-- 5. Procedimiento: Verificar disponibilidad de mesa para reserva
DROP PROCEDURE IF EXISTS sp_verificar_disponibilidad_mesa$$
CREATE PROCEDURE sp_verificar_disponibilidad_mesa(
    IN mesa_id_param INT,
    IN fecha_hora_param DATETIME
)
BEGIN
    DECLARE conflictos INT;
    
    -- Verificar si hay reservas en un rango de 2 horas
    SELECT COUNT(*) INTO conflictos
    FROM reservas
    WHERE mesa_id = mesa_id_param
      AND estado IN ('pendiente', 'confirmada')
      AND (
          (fecha_hora_param BETWEEN fecha_hora AND DATE_ADD(fecha_hora, INTERVAL 2 HOUR))
          OR
          (DATE_ADD(fecha_hora_param, INTERVAL 2 HOUR) BETWEEN fecha_hora AND DATE_ADD(fecha_hora, INTERVAL 2 HOUR))
      );
    
    -- Retornar disponibilidad
    IF conflictos > 0 THEN
        SELECT 0 AS disponible, 'Mesa no disponible en ese horario' AS mensaje;
    ELSE
        SELECT 1 AS disponible, 'Mesa disponible' AS mensaje;
    END IF;
END$$

-- 6. Procedimiento: Crear pedido desde carrito
DROP PROCEDURE IF EXISTS sp_crear_pedido_desde_carrito$$
CREATE PROCEDURE sp_crear_pedido_desde_carrito(
    IN user_id_param INT,
    IN direccion_param VARCHAR(255),
    IN telefono_param VARCHAR(20),
    IN costo_envio_param DECIMAL(10,2),
    IN observaciones_param TEXT
)
BEGIN
    DECLARE subtotal_calc DECIMAL(10,2);
    DECLARE total_calc DECIMAL(10,2);
    DECLARE nuevo_pedido_id INT;
    
    -- Calcular subtotal
    SELECT SUM(p.precio * c.cantidad) INTO subtotal_calc
    FROM carrito c
    INNER JOIN productos p ON c.producto_id = p.id
    WHERE c.user_id = user_id_param AND p.disponible = 1;
    
    -- Calcular total
    SET total_calc = subtotal_calc + costo_envio_param;
    
    -- Crear pedido
    INSERT INTO pedidos (user_id, direccion_entrega, telefono, subtotal, costo_envio, total, observaciones, created_at, updated_at)
    VALUES (user_id_param, direccion_param, telefono_param, subtotal_calc, costo_envio_param, total_calc, observaciones_param, NOW(), NOW());
    
    SET nuevo_pedido_id = LAST_INSERT_ID();
    
    -- Copiar items del carrito al detalle del pedido
    INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, subtotal, created_at, updated_at)
    SELECT 
        nuevo_pedido_id,
        c.producto_id,
        c.cantidad,
        p.precio,
        p.precio * c.cantidad,
        NOW(),
        NOW()
    FROM carrito c
    INNER JOIN productos p ON c.producto_id = p.id
    WHERE c.user_id = user_id_param AND p.disponible = 1;
    
    -- Limpiar carrito
    DELETE FROM carrito WHERE user_id = user_id_param;
    
    -- Retornar ID del pedido creado
    SELECT nuevo_pedido_id AS pedido_id, total_calc AS total;
END$$

-- 7. Procedimiento: Obtener reservas por fecha
DROP PROCEDURE IF EXISTS sp_reservas_por_fecha$$
CREATE PROCEDURE sp_reservas_por_fecha(IN fecha_param DATE)
BEGIN
    SELECT 
        r.id,
        r.fecha_hora,
        r.num_personas,
        r.estado,
        r.observaciones,
        u.name AS cliente_nombre,
        u.email AS cliente_email,
        m.numero AS mesa_numero,
        m.capacidad AS mesa_capacidad,
        m.ubicacion AS mesa_ubicacion
    FROM reservas r
    INNER JOIN users u ON r.user_id = u.id
    INNER JOIN mesas m ON r.mesa_id = m.id
    WHERE DATE(r.fecha_hora) = fecha_param
    ORDER BY r.fecha_hora ASC;
END$$

DELIMITER ;

-- ============================================
-- FIN DE PROCEDIMIENTOS ALMACENADOS
-- ============================================

-- ============================================
-- Procedimiento Almacenado: sp_verificar_disponibilidad_mesa
-- Descripción: Verifica si una mesa está disponible en una fecha/hora específica
-- ============================================

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_verificar_disponibilidad_mesa$$

CREATE PROCEDURE sp_verificar_disponibilidad_mesa(
    IN p_mesa_id INT,
    IN p_fecha_hora DATETIME
)
BEGIN
    DECLARE v_disponible INT DEFAULT 1;
    DECLARE v_mensaje VARCHAR(255);
    
    -- Verificar si la mesa existe y está disponible
    IF NOT EXISTS (SELECT 1 FROM mesas WHERE id = p_mesa_id AND disponible = 1) THEN
        SET v_disponible = 0;
        SET v_mensaje = 'La mesa no existe o no está disponible';
    -- Verificar si hay reservas en conflicto (2 horas antes/después)
    ELSEIF EXISTS (
        SELECT 1 FROM reservas 
        WHERE mesa_id = p_mesa_id 
        AND estado IN ('pendiente', 'confirmada')
        AND ABS(TIMESTAMPDIFF(MINUTE, fecha_hora, p_fecha_hora)) < 120
    ) THEN
        SET v_disponible = 0;
        SET v_mensaje = 'La mesa no está disponible en ese horario. Hay otra reserva cercana.';
    ELSE
        SET v_disponible = 1;
        SET v_mensaje = 'Mesa disponible para reservar';
    END IF;
    
    -- Retornar resultado
    SELECT v_disponible AS disponible, v_mensaje AS mensaje;
END$$

DELIMITER ;

-- Verificar que se creó correctamente
SHOW PROCEDURE STATUS WHERE Name = 'sp_verificar_disponibilidad_mesa';

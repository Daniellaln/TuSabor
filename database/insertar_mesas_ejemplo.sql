-- ============================================
-- Script: Insertar Mesas de Ejemplo
-- Descripción: Crea mesas de ejemplo para el sistema de reservas
-- ============================================

-- Verificar si ya existen mesas
SELECT COUNT(*) as total_mesas FROM mesas;

-- Si no hay mesas, insertar algunas de ejemplo
INSERT INTO mesas (numero, capacidad, ubicacion, disponible) VALUES
(1, 2, 'Ventana - Vista a la calle', 1),
(2, 2, 'Ventana - Vista al jardín', 1),
(3, 4, 'Interior - Zona central', 1),
(4, 4, 'Interior - Zona tranquila', 1),
(5, 6, 'Terraza - Exterior', 1),
(6, 6, 'Salón Principal', 1),
(7, 8, 'Salón Principal - Mesa grande', 1),
(8, 10, 'Salón VIP', 1);

-- Verificar que se insertaron correctamente
SELECT * FROM mesas ORDER BY capacidad, numero;

-- Estadísticas
SELECT 
    COUNT(*) as total_mesas,
    SUM(capacidad) as capacidad_total,
    SUM(CASE WHEN disponible = 1 THEN 1 ELSE 0 END) as mesas_disponibles
FROM mesas;

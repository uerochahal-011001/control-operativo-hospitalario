-- =====================================================
-- SISTEMA: Control Operativo Hospitalario Demo
-- BASE DE DATOS: control_operativo_demo
-- FECHA: 2026-07-08
-- =====================================================

CREATE DATABASE IF NOT EXISTS `control_operativo_demo` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `control_operativo_demo`;

-- =====================================================
-- TABLA: usuarios
-- =====================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('Administrador', 'Supervisor', 'Capturista') NOT NULL DEFAULT 'Capturista',
  `estado` ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`),
  INDEX `idx_rol` (`rol`),
  INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: incidencias
-- =====================================================
CREATE TABLE IF NOT EXISTS `incidencias` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `hora` TIME NOT NULL,
  `area` VARCHAR(100) NOT NULL,
  `tipo_incidencia` VARCHAR(100) NOT NULL,
  `prioridad` ENUM('Baja', 'Media', 'Alta', 'Crítica') NOT NULL DEFAULT 'Media',
  `descripcion` TEXT NOT NULL,
  `responsable_asignado` VARCHAR(100),
  `estatus` ENUM('Abierta', 'En proceso', 'Cerrada') NOT NULL DEFAULT 'Abierta',
  `usuario_registro` INT NOT NULL,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_registro`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  INDEX `idx_area` (`area`),
  INDEX `idx_prioridad` (`prioridad`),
  INDEX `idx_estatus` (`estatus`),
  INDEX `idx_fecha` (`fecha`),
  INDEX `idx_usuario_registro` (`usuario_registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: bitacora_movimientos
-- =====================================================
CREATE TABLE IF NOT EXISTS `bitacora_movimientos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `tipo_accion` ENUM('Login', 'Logout', 'Crear Incidencia', 'Editar Incidencia', 'Eliminar Incidencia', 'Ver Reporte') NOT NULL,
  `usuario_id` INT NOT NULL,
  `usuario_email` VARCHAR(100) NOT NULL,
  `detalles` TEXT,
  `fecha_hora` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ip_address` VARCHAR(45),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_tipo_accion` (`tipo_accion`),
  INDEX `idx_fecha_hora` (`fecha_hora`),
  INDEX `idx_usuario_email` (`usuario_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERTAR USUARIOS DE PRUEBA
-- =====================================================
-- Contraseñas:
-- admin@hospital.com: Admin123
-- supervisor@hospital.com: Supervisor123
-- captura@hospital.com: Captura123

INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `estado`) VALUES
('Administrador General', 'admin@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'Activo'),
('Supervisor Operativo', 'supervisor@hospital.com', '$2y$10$R9h/cIPz0gi.URNN3kh2OPST9/PgBkqquzi8Ay0IWUgf3qqTtI49e', 'Supervisor', 'Activo'),
('Capturista Hospital', 'captura@hospital.com', '$2y$10$13eW4G3gMT1nq8D6cJPbMeJHPxJ8nPDBPaHl0G8eVqRgYTvBRY3YK', 'Capturista', 'Activo');

-- =====================================================
-- INSERTAR DATOS DE PRUEBA
-- =====================================================

-- Incidencias de prueba
INSERT INTO `incidencias` (`fecha`, `hora`, `area`, `tipo_incidencia`, `prioridad`, `descripcion`, `responsable_asignado`, `estatus`, `usuario_registro`) VALUES
('2026-07-08', '08:30:00', 'Urgencias', 'Falla de Equipamiento Médico', 'Crítica', 'Equipo de monitoreo cardiaco no funciona en Urgencias', 'Dr. García', 'Abierta', 1),
('2026-07-08', '10:15:00', 'Quirófano', 'Problema de Infraestructura', 'Alta', 'Falla de iluminación quirúrgica en Sala 2', 'Ing. López', 'En proceso', 1),
('2026-07-08', '11:45:00', 'Farmacia', 'Error Administrativo', 'Media', 'Inconsistencia en inventario de medicamentos', 'Lic. Martínez', 'Abierta', 2),
('2026-07-07', '14:20:00', 'Laboratorio', 'Falla de Equipamiento Médico', 'Alta', 'Analizador de muestras dañado', 'Dr. Fernández', 'Cerrada', 2),
('2026-07-07', '16:00:00', 'Radiología', 'Problema de Infraestructura', 'Media', 'Servidor de almacenamiento de imágenes lento', 'Ing. Rodríguez', 'En proceso', 3),
('2026-07-06', '09:00:00', 'Pediatría', 'Otra Incidencia', 'Baja', 'Solicitud de material de limpieza', 'Sup. González', 'Cerrada', 1),
('2026-07-06', '13:30:00', 'Cirugía', 'Falla de Equipamiento Médico', 'Crítica', 'Falla de cama quirúrgica motorizada', 'Tec. Hernández', 'En proceso', 2),
('2026-07-05', '10:00:00', 'Emergencia', 'Problema de Infraestructura', 'Alta', 'Avería de sistema de climatización', 'Ing. Morales', 'Cerrada', 1),
('2026-07-05', '15:45:00', 'Oncología', 'Error Administrativo', 'Media', 'Retrasos en procesamiento de órdenes médicas', 'Adm. Castro', 'Cerrada', 3),
('2026-07-04', '12:00:00', 'Cuidados Intensivos', 'Falla de Equipamiento Médico', 'Crítica', 'Ventilador mecánico requiere mantenimiento', 'Dr. López', 'Cerrada', 1);

-- Registros de bitácora de ejemplo
INSERT INTO `bitacora_movimientos` (`tipo_accion`, `usuario_id`, `usuario_email`, `detalles`, `ip_address`) VALUES
('Login', 1, 'admin@hospital.com', 'Inicio de sesión exitoso', '127.0.0.1'),
('Crear Incidencia', 1, 'admin@hospital.com', 'Creada incidencia ID: 1', '127.0.0.1'),
('Login', 2, 'supervisor@hospital.com', 'Inicio de sesión exitoso', '127.0.0.1'),
('Editar Incidencia', 2, 'supervisor@hospital.com', 'Actualizado estatus de incidencia ID: 2', '127.0.0.1'),
('Logout', 1, 'admin@hospital.com', 'Cierre de sesión', '127.0.0.1');

-- =====================================================
-- CREAR VISTAS ÚTILES
-- =====================================================

CREATE VIEW `vw_incidencias_activas` AS
SELECT 
    i.id,
    i.fecha,
    i.hora,
    i.area,
    i.tipo_incidencia,
    i.prioridad,
    i.descripcion,
    i.responsable_asignado,
    i.estatus,
    u.nombre as usuario_registro_nombre,
    u.email as usuario_registro_email
FROM `incidencias` i
LEFT JOIN `usuarios` u ON i.usuario_registro = u.id
WHERE i.estatus IN ('Abierta', 'En proceso')
ORDER BY i.prioridad DESC, i.fecha DESC;

CREATE VIEW `vw_estadisticas_incidencias` AS
SELECT 
    COUNT(*) as total_incidencias,
    SUM(CASE WHEN estatus = 'Abierta' THEN 1 ELSE 0 END) as abiertas,
    SUM(CASE WHEN estatus = 'En proceso' THEN 1 ELSE 0 END) as en_proceso,
    SUM(CASE WHEN estatus = 'Cerrada' THEN 1 ELSE 0 END) as cerradas,
    SUM(CASE WHEN prioridad = 'Crítica' THEN 1 ELSE 0 END) as criticas,
    SUM(CASE WHEN prioridad = 'Alta' THEN 1 ELSE 0 END) as altas
FROM `incidencias`;

CREATE VIEW `vw_incidencias_por_area` AS
SELECT 
    area,
    COUNT(*) as total,
    SUM(CASE WHEN prioridad = 'Crítica' THEN 1 ELSE 0 END) as criticas,
    SUM(CASE WHEN estatus = 'Abierta' THEN 1 ELSE 0 END) as abiertas,
    SUM(CASE WHEN estatus = 'Cerrada' THEN 1 ELSE 0 END) as cerradas
FROM `incidencias`
GROUP BY area
ORDER BY total DESC;

-- =====================================================
-- FIN DEL SCRIPT SQL
-- =====================================================

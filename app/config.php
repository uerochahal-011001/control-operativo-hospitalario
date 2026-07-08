<?php
/**
 * CONFIGURACIÓN DE LA APLICACIÓN
 * Control Operativo Hospitalario Demo
 */

// ============================================
// CONFIGURACIÓN DE BASE DE DATOS
// ============================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'control_operativo_demo');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// CONFIGURACIÓN DE LA APLICACIÓN
// ============================================
define('APP_NAME', 'Control Operativo Hospitalario Demo');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/control-operativo-hospitalario');
define('APP_PATH', '/control-operativo-hospitalario');
define('PUBLIC_PATH', APP_URL . '/public');

// ============================================
// CONFIGURACIÓN DE SESIÓN
// ============================================
define('SESSION_TIMEOUT', 1800); // 30 minutos en segundos
define('SESSION_NAME', 'hospital_session');

// ============================================
// CONFIGURACIÓN DE SEGURIDAD
// ============================================
define('PASSWORD_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_OPTIONS', ['cost' => 10]);
define('SALT_LENGTH', 32);

// ============================================
// CONFIGURACIÓN DE ROLES
// ============================================
define('ROLES', array(
    'Administrador' => 1,
    'Supervisor' => 2,
    'Capturista' => 3
));

// ============================================
// PERMISOS POR ROL
// ============================================
define('PERMISOS', array(
    'Administrador' => array(
        'ver_dashboard' => true,
        'crear_incidencia' => true,
        'editar_incidencia' => true,
        'eliminar_incidencia' => true,
        'ver_todas_incidencias' => true,
        'ver_bitacora' => true,
        'filtrar_incidencias' => true,
        'exportar_reportes' => true
    ),
    'Supervisor' => array(
        'ver_dashboard' => true,
        'crear_incidencia' => true,
        'editar_incidencia' => true,
        'eliminar_incidencia' => false,
        'ver_todas_incidencias' => true,
        'ver_bitacora' => true,
        'filtrar_incidencias' => true,
        'exportar_reportes' => false
    ),
    'Capturista' => array(
        'ver_dashboard' => true,
        'crear_incidencia' => true,
        'editar_incidencia' => false,
        'eliminar_incidencia' => false,
        'ver_todas_incidencias' => false,
        'ver_bitacora' => false,
        'filtrar_incidencias' => false,
        'exportar_reportes' => false
    )
));

// ============================================
// ÁREAS HOSPITALARIAS
// ============================================
define('AREAS_HOSPITALARIAS', array(
    'Urgencias',
    'Quirófano',
    'Farmacia',
    'Laboratorio',
    'Radiología',
    'Pediatría',
    'Cirugía',
    'Emergencia',
    'Oncología',
    'Cuidados Intensivos',
    'Obstetricia',
    'Cardiología',
    'Neurología',
    'Traumatología',
    'Dermatología'
));

// ============================================
// TIPOS DE INCIDENCIA
// ============================================
define('TIPOS_INCIDENCIA', array(
    'Falla de Equipamiento Médico',
    'Problema de Infraestructura',
    'Error Administrativo',
    'Seguridad del Paciente',
    'Recurso Humano',
    'Otra Incidencia'
));

// ============================================
// NIVELES DE PRIORIDAD
// ============================================
define('PRIORIDADES', array(
    'Baja',
    'Media',
    'Alta',
    'Crítica'
));

// ============================================
// ESTADOS DE INCIDENCIA
// ============================================
define('ESTATUS_INCIDENCIA', array(
    'Abierta',
    'En proceso',
    'Cerrada'
));

// ============================================
// CONFIGURACIÓN DE PAGINACIÓN
// ============================================
define('ITEMS_PER_PAGE', 10);
define('MAX_ITEMS_PER_PAGE', 100);

// ============================================
// CONFIGURACIÓN DE TIMEZONE
// ============================================
date_default_timezone_set('America/Mexico_City');

// ============================================
// CONFIGURACIÓN DE ERRORES
// ============================================
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// ============================================
// INCLUIR ARCHIVOS NECESARIOS
// ============================================
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/bitacora.php';

?>

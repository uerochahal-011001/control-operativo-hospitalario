<?php
/**
 * FUNCIONES AUXILIARES
 * Control Operativo Hospitalario Demo
 */

/**
 * Redirigir a una URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit();
}

/**
 * Verificar si la sesión está activa
 */
function requireLogin() {
    global $auth;
    if (!$auth->isLoggedIn()) {
        redirect(PUBLIC_PATH . '/login.php');
    }
}

/**
 * Verificar si tiene permiso específico
 */
function requirePermission($permission) {
    global $auth;
    if (!$auth->hasPermission($permission)) {
        die('Acceso denegado. No tienes permiso para realizar esta acción.');
    }
}

/**
 * Sanitizar entrada HTML
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitizar para salida HTML
 */
function escapeOutput($data) {
    if (is_array($data)) {
        return array_map('escapeOutput', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Validar email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validar fecha
 */
function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validar hora
 */
function isValidTime($time, $format = 'H:i:s') {
    $t = DateTime::createFromFormat($format, $time);
    return $t && $t->format($format) === $time;
}

/**
 * Obtener fecha actual en formato
 */
function getCurrentDate($format = 'Y-m-d') {
    return date($format);
}

/**
 * Obtener hora actual en formato
 */
function getCurrentTime($format = 'H:i:s') {
    return date($format);
}

/**
 * Formatear fecha legible
 */
function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

/**
 * Formatear hora legible
 */
function formatTime($time, $format = 'H:i') {
    return date($format, strtotime($time));
}

/**
 * Obtener color de prioridad
 */
function getPriorityColor($prioridad) {
    $colores = array(
        'Baja' => '#28a745',
        'Media' => '#ffc107',
        'Alta' => '#fd7e14',
        'Crítica' => '#dc3545'
    );
    return isset($colores[$prioridad]) ? $colores[$prioridad] : '#6c757d';
}

/**
 * Obtener badge de prioridad
 */
function getPriorityBadge($prioridad) {
    $colores = array(
        'Baja' => 'success',
        'Media' => 'warning',
        'Alta' => 'warning',
        'Crítica' => 'danger'
    );
    $clase = isset($colores[$prioridad]) ? $colores[$prioridad] : 'secondary';
    return '<span class="badge badge-' . $clase . '">' . escapeOutput($prioridad) . '</span>';
}

/**
 * Obtener badge de estatus
 */
function getStatusBadge($estatus) {
    $colores = array(
        'Abierta' => 'danger',
        'En proceso' => 'info',
        'Cerrada' => 'success'
    );
    $clase = isset($colores[$estatus]) ? $colores[$estatus] : 'secondary';
    return '<span class="badge badge-' . $clase . '">' . escapeOutput($estatus) . '</span>';
}

/**
 * Generar mensaje flash
 */
function setFlash($tipo, $mensaje) {
    $_SESSION['flash'] = array(
        'tipo' => $tipo,
        'mensaje' => $mensaje
    );
}

/**
 * Obtener y limpiar mensaje flash
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Mostrar mensaje flash
 */
function displayFlash() {
    $flash = getFlash();
    if ($flash) {
        $tipo = isset($flash['tipo']) ? $flash['tipo'] : 'info';
        $mensaje = isset($flash['mensaje']) ? $flash['mensaje'] : '';
        echo '<div class="alert alert-' . $tipo . ' alert-dismissible fade show" role="alert">';
        echo escapeOutput($mensaje);
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
    }
}

/**
 * Verificar si existe un campo POST
 */
function hasPost($field) {
    return isset($_POST[$field]) && $_POST[$field] !== '';
}

/**
 * Obtener valor POST con sanitización
 */
function getPost($field, $default = '') {
    if (isset($_POST[$field])) {
        return sanitizeInput($_POST[$field]);
    }
    return $default;
}

/**
 * Obtener valor GET con sanitización
 */
function getGet($field, $default = '') {
    if (isset($_GET[$field])) {
        return sanitizeInput($_GET[$field]);
    }
    return $default;
}

/**
 * Obtener dirección IP del cliente
 */
function getClientIp() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Contar incidencias por criterio
 */
function countIncidencias($campo = null, $valor = null) {
    global $db;
    
    $sql = "SELECT COUNT(*) as total FROM incidencias";
    
    if ($campo && $valor) {
        $sql .= " WHERE " . $campo . " = :valor";
    }
    
    $result = $db->prepare($sql);
    
    if ($campo && $valor) {
        $result->bind(':valor', $valor);
    }
    
    $row = $result->getRow();
    return $row['total'] ?? 0;
}

/**
 * Obtener estadísticas de incidencias
 */
function getIncidenciasStats() {
    global $db;
    
    $sql = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN estatus = 'Abierta' THEN 1 ELSE 0 END) as abiertas,
        SUM(CASE WHEN estatus = 'En proceso' THEN 1 ELSE 0 END) as en_proceso,
        SUM(CASE WHEN estatus = 'Cerrada' THEN 1 ELSE 0 END) as cerradas,
        SUM(CASE WHEN prioridad = 'Crítica' THEN 1 ELSE 0 END) as criticas
    FROM incidencias";
    
    return $db->prepare($sql)->getRow();
}

/**
 * Obtener incidencias por área
 */
function getIncidenciasPoArea() {
    global $db;
    
    $sql = "SELECT area, COUNT(*) as total FROM incidencias GROUP BY area ORDER BY total DESC";
    return $db->prepare($sql)->getRows();
}

/**
 * Obtener incidencias por prioridad
 */
function getIncidenciasPoprioridad() {
    global $db;
    
    $sql = "SELECT prioridad, COUNT(*) as total FROM incidencias GROUP BY prioridad ORDER BY FIELD(prioridad, 'Crítica', 'Alta', 'Media', 'Baja')";
    return $db->prepare($sql)->getRows();
}

/**
 * Validar CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar CSRF token
 */
function verifyCsrfToken() {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

?>

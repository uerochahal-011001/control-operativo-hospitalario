<?php
/**
 * GESTIÓN DE BITÁCORA DE MOVIMIENTOS
 * Control Operativo Hospitalario Demo
 */

/**
 * Registrar acción en la bitácora
 */
function registrarBitacora($tipo_accion, $usuario_id, $usuario_email, $detalles = '', $ip_address = '') {
    global $db;
    
    try {
        if (empty($ip_address)) {
            $ip_address = getClientIp();
        }
        
        $sql = "INSERT INTO bitacora_movimientos 
                (tipo_accion, usuario_id, usuario_email, detalles, ip_address, fecha_hora) 
                VALUES (:tipo_accion, :usuario_id, :usuario_email, :detalles, :ip_address, NOW())";
        
        $db->prepare($sql)
            ->bind(':tipo_accion', $tipo_accion)
            ->bind(':usuario_id', $usuario_id)
            ->bind(':usuario_email', $usuario_email)
            ->bind(':detalles', $detalles)
            ->bind(':ip_address', $ip_address)
            ->execute();
        
        return true;
        
    } catch (Exception $e) {
        error_log('Error registrando bitácora: ' . $e->getMessage());
        return false;
    }
}

/**
 * Obtener bitácora completa con paginación
 */
function getBitacora($pagina = 1, $items_por_pagina = ITEMS_PER_PAGE) {
    global $db;
    
    try {
        $inicio = ($pagina - 1) * $items_por_pagina;
        
        $sql = "SELECT * FROM bitacora_movimientos 
                ORDER BY fecha_hora DESC 
                LIMIT :inicio, :limite";
        
        return $db->prepare($sql)
            ->bind(':inicio', $inicio, PDO::PARAM_INT)
            ->bind(':limite', $items_por_pagina, PDO::PARAM_INT)
            ->getRows();
        
    } catch (Exception $e) {
        error_log('Error obteniendo bitácora: ' . $e->getMessage());
        return array();
    }
}

/**
 * Obtener total de registros en bitácora
 */
function getTotalBitacora() {
    global $db;
    
    try {
        $sql = "SELECT COUNT(*) as total FROM bitacora_movimientos";
        $result = $db->prepare($sql)->getRow();
        return $result['total'] ?? 0;
        
    } catch (Exception $e) {
        error_log('Error contando bitácora: ' . $e->getMessage());
        return 0;
    }
}

/**
 * Obtener bitácora filtrada por usuario
 */
function getBitacoraByUsuario($usuario_id, $pagina = 1, $items_por_pagina = ITEMS_PER_PAGE) {
    global $db;
    
    try {
        $inicio = ($pagina - 1) * $items_por_pagina;
        
        $sql = "SELECT * FROM bitacora_movimientos 
                WHERE usuario_id = :usuario_id 
                ORDER BY fecha_hora DESC 
                LIMIT :inicio, :limite";
        
        return $db->prepare($sql)
            ->bind(':usuario_id', $usuario_id)
            ->bind(':inicio', $inicio, PDO::PARAM_INT)
            ->bind(':limite', $items_por_pagina, PDO::PARAM_INT)
            ->getRows();
        
    } catch (Exception $e) {
        error_log('Error obteniendo bitácora por usuario: ' . $e->getMessage());
        return array();
    }
}

/**
 * Obtener bitácora filtrada por tipo de acción
 */
function getBitacoraByTipo($tipo_accion, $pagina = 1, $items_por_pagina = ITEMS_PER_PAGE) {
    global $db;
    
    try {
        $inicio = ($pagina - 1) * $items_por_pagina;
        
        $sql = "SELECT * FROM bitacora_movimientos 
                WHERE tipo_accion = :tipo_accion 
                ORDER BY fecha_hora DESC 
                LIMIT :inicio, :limite";
        
        return $db->prepare($sql)
            ->bind(':tipo_accion', $tipo_accion)
            ->bind(':inicio', $inicio, PDO::PARAM_INT)
            ->bind(':limite', $items_por_pagina, PDO::PARAM_INT)
            ->getRows();
        
    } catch (Exception $e) {
        error_log('Error obteniendo bitácora por tipo: ' . $e->getMessage());
        return array();
    }
}

/**
 * Obtener bitácora por rango de fechas
 */
function getBitacoraByFechas($fecha_inicio, $fecha_fin, $pagina = 1, $items_por_pagina = ITEMS_PER_PAGE) {
    global $db;
    
    try {
        $inicio = ($pagina - 1) * $items_por_pagina;
        
        $sql = "SELECT * FROM bitacora_movimientos 
                WHERE DATE(fecha_hora) >= :fecha_inicio AND DATE(fecha_hora) <= :fecha_fin 
                ORDER BY fecha_hora DESC 
                LIMIT :inicio, :limite";
        
        return $db->prepare($sql)
            ->bind(':fecha_inicio', $fecha_inicio)
            ->bind(':fecha_fin', $fecha_fin)
            ->bind(':inicio', $inicio, PDO::PARAM_INT)
            ->bind(':limite', $items_por_pagina, PDO::PARAM_INT)
            ->getRows();
        
    } catch (Exception $e) {
        error_log('Error obteniendo bitácora por fechas: ' . $e->getMessage());
        return array();
    }
}

/**
 * Limpiar bitácora antigua (más de N días)
 */
function limpiarBitacoraAntigua($dias = 30) {
    global $db;
    
    try {
        $sql = "DELETE FROM bitacora_movimientos 
                WHERE fecha_hora < DATE_SUB(NOW(), INTERVAL :dias DAY)";
        
        $db->prepare($sql)
            ->bind(':dias', $dias, PDO::PARAM_INT)
            ->execute();
        
        return true;
        
    } catch (Exception $e) {
        error_log('Error limpiando bitácora: ' . $e->getMessage());
        return false;
    }
}

?>

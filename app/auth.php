<?php
/**
 * GESTIÓN DE AUTENTICACIÓN
 * Control Operativo Hospitalario Demo
 */

class Auth {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
        $this->initSession();
    }

    /**
     * Inicializar sesión
     */
    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            session_name(SESSION_NAME);
            
            // Regenerar ID de sesión por seguridad
            if (!isset($_SESSION['iniciada']) || $_SESSION['iniciada'] === false) {
                session_regenerate_id(true);
                $_SESSION['iniciada'] = true;
            }
        }
    }

    /**
     * Validar credenciales de usuario
     */
    public function login($email, $password) {
        try {
            $sql = "SELECT id, nombre, email, password, rol, estado FROM usuarios WHERE email = :email LIMIT 1";
            $result = $this->db->prepare($sql)
                ->bind(':email', $email)
                ->getRow();

            if (!$result) {
                return array('success' => false, 'message' => 'El usuario no existe');
            }

            if ($result['estado'] !== 'Activo') {
                return array('success' => false, 'message' => 'Usuario inactivo');
            }

            if (!password_verify($password, $result['password'])) {
                return array('success' => false, 'message' => 'Contraseña incorrecta');
            }

            // Establecer sesión
            $_SESSION['usuario_id'] = $result['id'];
            $_SESSION['usuario_email'] = $result['email'];
            $_SESSION['usuario_nombre'] = $result['nombre'];
            $_SESSION['usuario_rol'] = $result['rol'];
            $_SESSION['login_time'] = time();

            // Registrar en bitácora
            registrarBitacora('Login', $result['id'], $result['email'], 'Inicio de sesión exitoso');

            return array('success' => true, 'message' => 'Login exitoso', 'user' => $result);

        } catch (Exception $e) {
            return array('success' => false, 'message' => 'Error en la autenticación: ' . $e->getMessage());
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        try {
            if ($this->isLoggedIn()) {
                $usuario_id = $_SESSION['usuario_id'];
                $usuario_email = $_SESSION['usuario_email'];
                
                // Registrar en bitácora
                registrarBitacora('Logout', $usuario_id, $usuario_email, 'Cierre de sesión');
            }

            // Destruir sesión
            $_SESSION = array();
            session_destroy();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Verificar si existe sesión activa
     */
    public function isLoggedIn() {
        if (!isset($_SESSION['usuario_id'])) {
            return false;
        }

        // Verificar timeout de sesión
        if (isset($_SESSION['login_time'])) {
            if (time() - $_SESSION['login_time'] > SESSION_TIMEOUT) {
                $this->logout();
                return false;
            }
        }

        // Renovar tiempo de sesión
        $_SESSION['login_time'] = time();
        return true;
    }

    /**
     * Obtener rol del usuario
     */
    public function getRol() {
        return $_SESSION['usuario_rol'] ?? null;
    }

    /**
     * Obtener ID del usuario
     */
    public function getUsuarioId() {
        return $_SESSION['usuario_id'] ?? null;
    }

    /**
     * Obtener email del usuario
     */
    public function getUsuarioEmail() {
        return $_SESSION['usuario_email'] ?? null;
    }

    /**
     * Obtener nombre del usuario
     */
    public function getUsuarioNombre() {
        return $_SESSION['usuario_nombre'] ?? null;
    }

    /**
     * Verificar permiso específico
     */
    public function hasPermission($permission) {
        $rol = $this->getRol();
        
        if (!isset(PERMISOS[$rol])) {
            return false;
        }

        return isset(PERMISOS[$rol][$permission]) && PERMISOS[$rol][$permission] === true;
    }

    /**
     * Verificar si es administrador
     */
    public function isAdmin() {
        return $this->getRol() === 'Administrador';
    }

    /**
     * Verificar si es supervisor
     */
    public function isSupervisor() {
        return $this->getRol() === 'Supervisor';
    }

    /**
     * Verificar si es capturista
     */
    public function isCapturista() {
        return $this->getRol() === 'Capturista';
    }
}

// Instancia global de autenticación
$auth = new Auth();

?>

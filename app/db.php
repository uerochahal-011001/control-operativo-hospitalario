<?php
/**
 * CLASE DE CONEXIÓN A BASE DE DATOS
 * Control Operativo Hospitalario Demo
 */

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;
    private $charset = DB_CHARSET;
    private $conn;
    private $stmt;
    private $error;

    /**
     * Constructor: Conectar a la base de datos
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Conectar a MySQL
     */
    private function connect() {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name . ';charset=' . $this->charset;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    /**
     * Preparar consulta SQL
     */
    public function prepare($sql) {
        $this->stmt = $this->conn->prepare($sql);
        return $this;
    }

    /**
     * Vincular parámetros
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Ejecutar consulta preparada
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Obtener un resultado (una fila)
     */
    public function getRow() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Obtener todos los resultados (múltiples filas)
     */
    public function getRows() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Obtener cantidad de filas afectadas
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Obtener último ID insertado
     */
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    /**
     * Obtener último error
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Iniciar transacción
     */
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    /**
     * Confirmar transacción
     */
    public function commit() {
        return $this->conn->commit();
    }

    /**
     * Revertir transacción
     */
    public function rollBack() {
        return $this->conn->rollBack();
    }

    /**
     * Obtener instancia de conexión
     */
    public function getConnection() {
        return $this->conn;
    }
}

// Instancia global de la base de datos
$db = new Database();

?>

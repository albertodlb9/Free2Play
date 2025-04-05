<?php
require_once '../config.php';
class Db {
    public $db;

    function crearConexion() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
    }

    function cerrarConexion() {
        if ($this->db != null) {
            $this->db->close();
            $this->db = null;
        }
    }

    function consultaSelect($sql) {
        $resArray = array();
        $res = $this->db->query($sql);
        if ($res) {
            $resArray = $res->fetch_all(MYSQLI_ASSOC); // Corrección aquí
            $res->free();
        } else {
            die("Error en la consulta: " . $this->db->error);
        }
        return $resArray;
    }

    function manipulacionDatos($sql) {
        $this->db->query($sql);
        return $this->db->affected_rows; // Corrección aquí
    }
}
?>

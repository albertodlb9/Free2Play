<?php
    require_once "Model.php";
    class Desarrollador extends Model{
        protected $table = "desarrolladores";
        public $id;
        public $nombre;
        public $pais;

        public function __construct($nombre=null, $pais=null) {
            parent::__construct();
            $this->nombre = $nombre;
            $this->pais = $pais;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (nombre, pais) VALUES (?, ?)";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->nombre, $this->pais]);
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET nombre = ?, pais = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->nombre, $this->pais, $id]);
        }
    }
?>
<?php
    require_once "Model.php";
    class Plataforma extends Model{
        
        protected $table = "plataformas";
        public $id;
        public $nombre;
        public $empresa;

        public function __construct($nombre=null, $empresa=null) {
            parent::__construct();
            $this->nombre = $nombre;
            $this->empresa = $empresa;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (nombre, empresa) VALUES (?, ?)";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("ss", $this->nombre, $this->empresa);
            return $stmt->execute();
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET nombre = ?, empresa = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("ssi", $this->nombre, $this->empresa, $id);
            return $stmt->execute();
        }
    }
?>
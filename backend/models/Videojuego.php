<?php
    require_once "Model.php";
    class Videojuego extends Model{
        
        protected $table = "videojuegos";
        public $id;
        public $titulo;
        public $descripcion;
        public $fecha_lanzamiento;
        public $desarrollador_id;
        public $portada;
        public $notaMedia;

        public function __construct($titulo=null, $descripcion=null, $fecha_lanzamiento=null, $desarrollador_id=null, $portada=null) {
            parent::__construct();
            $this->titulo = $titulo;
            $this->descripcion = $descripcion;
            $this->fecha_lanzamiento = $fecha_lanzamiento;
            $this->desarrollador_id = $desarrollador_id;
            $this->portada = $portada;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (titulo, descripcion, fecha_lanzamiento, desarrollador_id, portada) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("sssis", $this->titulo, $this->descripcion, $this->fecha_lanzamiento, $this->desarrollador_id, $this->portada);
            return $stmt->execute();
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET titulo = ?, descripcion = ?, fecha_lanzamiento = ?, desarrollador_id = ?, portada = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("sssisi", $this->titulo, $this->descripcion, $this->fecha_lanzamiento, $this->desarrollador_id, $this->portada,$id);
            return $stmt->execute();
        }
    }
?>
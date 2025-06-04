<?php
    require_once "Model.php";
    class Videojuego extends Model{
        
        protected $table = "videojuegos";
        public $id;
        public $titulo;
        public $descripcion;
        public $fecha_lanzamiento;
        public $desarrollador_id;
        public $plataforma_id;
        public $portada;
        public $notaMedia;

        public function __construct($titulo=null, $descripcion=null, $fecha_lanzamiento=null, $desarrollador_id=null, $plataforma_id=null ,$portada=null) {
            parent::__construct();
            $this->titulo = $titulo;
            $this->descripcion = $descripcion;
            $this->fecha_lanzamiento = $fecha_lanzamiento;
            $this->desarrollador_id = $desarrollador_id;
            $this->plataforma_id = $plataforma_id;
            $this->portada = $portada;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (titulo, descripcion, fecha_lanzamiento, desarrollador_id, plataforma_id, portada) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("sssiis", $this->titulo, $this->descripcion, $this->fecha_lanzamiento, $this->desarrollador_id, $this->plataforma_id, $this->portada);
            return $stmt->execute();
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET titulo = ?, descripcion = ?, fecha_lanzamiento = ?, desarrollador_id = ?, portada = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("sssisi", $this->titulo, $this->descripcion, $this->fecha_lanzamiento, $this->desarrollador_id, $this->portada,$id);
            return $stmt->execute();
        }

        public function getVideojugoConPlataformaYDesarrollador($id) {
            $sql = "SELECT {$this->table}.*, desarrolladores.nombre AS desarrollador_nombre, plataformas.nombre AS plataforma_nombre 
                    FROM {$this->table} 
                    JOIN desarrolladores ON videojuegos.desarrollador_id = desarrolladores.id 
                    JOIN plataformas ON videojuegos.plataforma_id = plataformas.id 
                    WHERE {$this->table}.id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $videojuego = $result->fetch_assoc();
            return $videojuego;
        }
    }
?>
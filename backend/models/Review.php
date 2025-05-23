<?php
    require_once "Model.php";
    class Review extends Model{
        
        protected $table = "reviews";
        public $id;
        public $usuario_id;
        public $videojuego_id;
        public $titulo;
        public $contenido;
        public $puntuacion;
        public $fecha;

        public function __construct($usuario_id=null, $videojuego_id=null, $titulo=null, $contenido=null, $puntuacion=null, $fecha=null) {
            $this->usuario_id = $usuario_id;
            $this->videojuego_id = $videojuego_id;
            $this->titulo = $titulo;
            $this->contenido = $contenido;
            $this->puntuacion = $puntuacion;
            $this->fecha = $fecha;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (usuario_id, videojuego_id, titulo, contenido, puntuacion, fecha) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->usuario_id, $this->videojuego_id, $this->titulo, $this->contenido, $this->puntuacion, $this->fecha]);
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET usuario_id = ?, videojuego_id = ?, titulo = ?, contenido = ?, puntuacion = ?, fecha = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->usuario_id, $this->videojuego_id, $this->titulo, $this->contenido, $this->puntuacion, $this->fecha, $id]);
        }

        public function delete($id) {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$id]);
        }
    }
?>
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

        public function __construct($usuario_id=null, $videojuego_id=null, $titulo=null, $contenido=null, $puntuacion=null) {
            parent::__construct();
            $this->usuario_id = $usuario_id;
            $this->videojuego_id = $videojuego_id;
            $this->titulo = $titulo;
            $this->contenido = $contenido;
            $this->puntuacion = $puntuacion;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (usuario_id, videojuego_id, titulo, contenido, puntuacion) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("iissi", $this->usuario_id, $this->videojuego_id, $this->titulo, $this->contenido, $this->puntuacion);
            $stmt->execute();

            $sql = "SELECT AVG(puntuacion) AS media FROM {$this->table} WHERE videojuego_id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("i", $this->videojuego_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $media = $result->fetch_assoc()['media'];

            $sqlUpdate = "UPDATE videojuegos SET nota_media = ? WHERE id = ?";
            $stmtUpdate = $this->db->db->prepare($sqlUpdate);
            $stmtUpdate->bind_param("di", $media, $this->videojuego_id);
            $stmtUpdate->execute();
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET usuario_id = ?, videojuego_id = ?, titulo = ?, contenido = ?, puntuacion = ?, fecha = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("iissisi", $this->usuario_id, $this->videojuego_id, $this->titulo, $this->contenido, $this->puntuacion, $this->fecha, $id);
            return $stmt->execute();
        }

        public function getReviewsByVideojuego($videojuego_id) {
            $sql = "SELECT {$this->table}.*, usuarios.nombre_usuario as nombre_usuario FROM {$this->table}  JOIN usuarios ON reviews.usuario_id = usuarios.id WHERE videojuego_id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("i", $videojuego_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function get($id) {
            $sql = "SELECT {$this->table}.*,usuarios.nombre_usuario FROM {$this->table} JOIN usuarios ON  {$this->table}.usuario_id = usuarios.id WHERE {$this->table}.id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_object();
        }

        public function delete($id){
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->db->db->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        
        $sql = "SELECT AVG(puntuacion) AS media FROM {$this->table} WHERE videojuego_id = ?";
        $stmt = $this->db->db->prepare($sql);
        $stmt->bind_param("i", $this->videojuego_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $media = $result->fetch_assoc()['media'];

        $sqlUpdate = "UPDATE videojuegos SET nota_media = ? WHERE id = ?";
        $stmtUpdate = $this->db->db->prepare($sqlUpdate);
        $stmtUpdate->bind_param("di", $media, $this->videojuego_id);
        $stmtUpdate->execute();
    } 

    }
?>
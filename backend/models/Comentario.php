<?php
    require_once "Model.php";
    class Comentario extends Model{
            
            protected $table = "comentarios";
            public $id;
            public $review_id;
            public $usuario_id;
            public $contenido;
            public $fecha;
    
            public function __construct($usuario_id=null, $review_id=null, $contenido=null, $fecha=null) {
                parent::__construct();
                $this->usuario_id = $usuario_id;
                $this->review_id = $review_id;
                $this->contenido = $contenido;
                $this->fecha = $fecha;
            }

             public function insert() {
                $sql = "INSERT INTO {$this->table} (usuario_id, review_id, contenido) VALUES (?, ?, ?)";
                $stmt = $this->db->db->prepare($sql);
                $stmt->bind_param("iis", $this->usuario_id, $this->review_id, $this->contenido);
                return $stmt->execute();
            }

            public function update($id) {
                $sql = "UPDATE {$this->table} SET usuario_id = ?, review_id = ?, contenido = ?, fecha = ? WHERE id = ?";
                $stmt = $this->db->db->prepare($sql);
                $stmt->bind_param("iissi", $this->usuario_id, $this->review_id, $this->contenido, $this->fecha, $id);
                return $stmt->execute();
            }

            public function get($id) {
                $sql = "SELECT {$this->table}.*, usuarios.nombre_usuario FROM {$this->table} JOIN usuarios ON {$this->table}.usuario_id = usuarios.id WHERE {$this->table}.id = ?";
                $stmt = $this->db->db->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_object();
            }

            public function getAll() {
                $sql = "SELECT {$this->table}.*, usuarios.nombre_usuario FROM {$this->table} JOIN usuarios ON {$this->table}.usuario_id = usuarios.id";
                $stmt = $this->db->db->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function getComentariosByReview($review_id) {        
                $sql = "SELECT {$this->table}.*, usuarios.nombre_usuario FROM {$this->table} JOIN usuarios ON {$this->table}.usuario_id = usuarios.id WHERE review_id = ?";
                $stmt = $this->db->db->prepare($sql);
                $stmt->bind_param("i", $review_id);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
    }
    
?>
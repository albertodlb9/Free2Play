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
                $this->usuario_id = $usuario_id;
                $this->review_id = $review_id;
                $this->contenido = $contenido;
                $this->fecha = $fecha;
            }

             public function insert() {
                $sql = "INSERT INTO {$this->table} (usuario_id, review_id, contenido, fecha) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->db->prepare($sql);
                return $stmt->execute([$this->usuario_id, $this->review_id, $this->contenido, $this->fecha]);
            }

            public function update($id) {
                $sql = "UPDATE {$this->table} SET usuario_id = ?, review_id = ?, contenido = ?, fecha = ? WHERE id = ?";
                $stmt = $this->db->db->prepare($sql);
                return $stmt->execute([$this->usuario_id, $this->review_id, $this->contenido, $this->fecha, $id]);
            }
    }
    
?>
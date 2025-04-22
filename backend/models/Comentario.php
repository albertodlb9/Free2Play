<?php
    require_once "Model.php";
    class Comentario extends Model{
            
            protected $table = "comentarios";
            public $id;
            public $review_id;
            public $usuario_id;
            public $contenido;
            public $fecha;
    
            public function __construct($id, $usuario_id, $review_id, $contenido, $fecha) {
                $this->id = $id;
                $this->usuario_id = $usuario_id;
                $this->review_id = $review_id;
                $this->contenido = $contenido;
                $this->fecha = $fecha;
            }
    }
?>
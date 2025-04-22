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
    }
?>
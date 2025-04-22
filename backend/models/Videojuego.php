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
            $this->titulo = $titulo;
            $this->descripcion = $descripcion;
            $this->fecha_lanzamiento = $fecha_lanzamiento;
            $this->desarrollador_id = $desarrollador_id;
            $this->portada = $portada;
        }
    }
?>
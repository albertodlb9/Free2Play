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

        public function __construct($id, $usuario_id, $videojuego_id, $titulo, $contenido, $puntuacion, $fecha) {
            $this->id = $id;
            $this->usuario_id = $usuario_id;
            $this->videojuego_id = $videojuego_id;
            $this->titulo = $titulo;
            $this->contenido = $contenido;
            $this->puntuacion = $puntuacion;
            $this->fecha = $fecha;
        }
    }
?>
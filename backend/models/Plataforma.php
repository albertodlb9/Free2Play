<?php
    require_once "Model.php";
    class Plataforma extends Model{
        
        protected $table = "plataformas";
        public $id;
        public $nombre;
        public $empresa;

        public function __construct($nombre=null, $empresa=null) {
            $this->nombre = $nombre;
            $this->empresa = $empresa;
        }
    }
?>
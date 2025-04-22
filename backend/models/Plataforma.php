<?php
    require_once "Model.php";
    class Plataforma extends Model{
        
        protected $table = "plataformas";
        public $id;
        public $nombre;
        public $empresa;

        public function __construct($id, $nombre, $empresa) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->empresa = $empresa;
        }
    }
?>
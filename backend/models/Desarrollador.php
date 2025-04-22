<?php
    require_once "Model.php";
    class Desarrollador extends Model{
        protected $table = "desarrolladores";
        public $id;
        public $nombre;
        public $pais;

        public function __construct($nombre=null, $pais=null) {
            $this->nombre = $nombre;
            $this->pais = $pais;
        }
    }
?>
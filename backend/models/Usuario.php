<?php
    require_once "Model.php";
    class Usuario extends Model{
        
        protected $table = "usuarios";
        public $nombreUsuario;
        public $nombre;
        public $apellido1;
        public $apellido2;
        public $email;
        public $password;
        public $rol;
        public $telefono;
        public $direccion;
        public $avatar;
        public $fecha_registro;

        public function __construct($nombreUsuario, $nombre, $apellido1, $apellido2, $email, $password, $rol, $telefono, $direccion, $avatar) {
            $this->nombreUsuario = $nombreUsuario;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->avatar = $avatar;
        }
    }
?>
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

        public function __construct($nombreUsuario = null, $nombre= null, $apellido1= null, $apellido2= null, $email= null, $password= null, $rol= null, $telefono= null, $direccion= null, $avatar= null) {
            parent::__construct();
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

        public function insert() {
            $sql = "INSERT INTO {$this->table} (nombre_usuario, nombre, apellido1, apellido2, email, password, rol, telefono, direccion, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->nombreUsuario, $this->nombre, $this->apellido1, $this->apellido2, $this->email, $this->password, $this->rol, $this->telefono, $this->direccion, $this->avatar]);
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET nombre_usuario = ?, nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, password = ?, rol = ?, telefono = ?, direccion = ?, avatar = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            return $stmt->execute([$this->nombreUsuario, $this->nombre, $this->apellido1, $this->apellido2, $this->email, $this->password, $this->rol, $this->telefono, $this->direccion, $this->avatar, $id]);
        }

    }
?>
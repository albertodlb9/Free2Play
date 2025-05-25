<?php
    require_once "Model.php";
    class Usuario extends Model{
        
        protected $table = "usuarios";
        public $id;
        public $nombreUsuario;
        public $nombre;
        public $apellido1;
        public $apellido2;
        public $email;
        public $password;
        public $salt;
        public $rol;
        public $telefono;
        public $direccion;
        public $avatar;

        public function __construct($id=null,$nombreUsuario = null, $nombre= null, $apellido1= null, $apellido2= null, $email= null, $password= null, $salt = null, $rol= null, $telefono= null, $direccion= null, $avatar= null) {
            parent::__construct();
            $this->id = $id;
            $this->nombreUsuario = $nombreUsuario;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->email = $email;
            $this->password = $password;
            $this->salt = $salt;
            $this->rol = $rol;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->avatar = $avatar;
        }

        public function insert() {
            $sql = "INSERT INTO {$this->table} (nombre_usuario, nombre, apellido1, apellido2, email, password, salt, rol, telefono, direccion, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("ssssssissss", $this->nombreUsuario, $this->nombre, $this->apellido1, $this->apellido2, $this->email, $this->password, $this->rol, $this->telefono, $this->direccion, $this->avatar);
            return $stmt->execute();
        }

        public function update($id) {
            $sql = "UPDATE {$this->table} SET nombre_usuario = ?, nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, password = ?, rol = ?, telefono = ?, direccion = ?, avatar = ? WHERE id = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("ssssssssssi", $this->nombreUsuario, $this->nombre, $this->apellido1, $this->apellido2, $this->email, $this->password, $this->rol, $this->telefono, $this->direccion, $this->avatar, $id);
            return $stmt->execute();
        }

        public function buscarPorUsuario($nombreUsuario) {
            $sql = "SELECT * FROM {$this->table} WHERE nombre_usuario = ?";
            $stmt = $this->db->db->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                return new Usuario($fila['id'],$fila['nombre_usuario'],$fila['nombre'],$fila['apellido1'],$fila['apellido2'],$fila['email'],$fila['password'],$fila['salt'],$fila['rol'],$fila['telefono'],$fila['direccion'],$fila['avatar']);
            } else {
                return null;
            }
        }

    }
?>
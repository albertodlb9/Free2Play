<?php
    class UsuarioController {
        public function index() {
            $usuario = new Usuario();
            $usuarios = $usuario->getAll();
            echo json_encode($usuarios);
        }

        public function show($id) {
            $usuario = new Usuario();
            $usuario = $usuario->get($id);
            echo json_encode($usuario);
        }
        public function delete($id) {
            $usuario = new Usuario();
            $usuario->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $usuario = new Usuario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $usuario->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $usuario = new Usuario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $usuario->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
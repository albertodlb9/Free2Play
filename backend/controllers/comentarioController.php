<?php
    class ComentarioController {
        public function index() {
            $comentario = new Comentario();
            $comentarios = $comentario->getAll();
            echo json_encode($comentarios);
        }

        public function show($id) {
            $comentario = new Comentario();
            $comentario = $comentario->get($id);
            echo json_encode($comentario);
        }
        public function delete($id) {
            $comentario = new Comentario();
            $comentario->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $comentario = new Comentario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $comentario->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $comentario = new Comentario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $comentario->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
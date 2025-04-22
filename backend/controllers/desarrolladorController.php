<?php
    class DesarrolladorController {
        public function index() {
            $desarrollador = new Desarrollador();
            $desarrolladores = $desarrollador->getAll();
            echo json_encode($desarrolladores);
        }

        public function show($id) {
            $desarrollador = new Desarrollador();
            $desarrollador = $desarrollador->get($id);
            echo json_encode($desarrollador);
        }
        public function delete($id) {
            $desarrollador = new Desarrollador();
            $desarrollador->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $desarrollador = new Desarrollador($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $desarrollador->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $desarrollador = new Desarrollador($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $desarrollador->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
<?php
    class PlataformaController {
        public function index() {
            $plataforma = new Plataforma();
            $plataformas = $plataforma->getAll();
            echo json_encode($plataformas);
        }

        public function show($id) {
            $plataforma = new Plataforma();
            $plataforma = $plataforma->get($id);
            echo json_encode($plataforma);
        }
        public function delete($id) {
            $plataforma = new Plataforma();
            $plataforma->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $plataforma = new Plataforma(/*Añadir los datos de la plataforma*/);
            $plataforma->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $plataforma = new Plataforma(/*Añadir los datos de la plataforma*/);
            $plataforma->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
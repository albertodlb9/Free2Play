<?php
    require_once __DIR__ . '/../models/Desarrollador.php';
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

        public function destroy($id) {
            $desarrollador = new Desarrollador();
            $desarrollador->delete($id);
            echo json_encode(["message" => "Desarrollador eliminado"]);
        }

        public function store() {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $desarrollador = new Desarrollador($data['nombre'], $data['pais']);
            $desarrollador->insert();
            echo json_encode(["message" => "Desarrollador creado"]);
        }

        public function update($id) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $desarrollador = new Desarrollador($data['nombre'], $data['pais']);
            $desarrollador->update($id);
            echo json_encode(["message" => "Desarrollador actualizado"]);
        }
    }

?>
<?php
    require_once __DIR__ . '/../models/Desarrollador.php';
    require_once __DIR__ . '/../helpers/auth.php';
    
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
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $desarrollador = new Desarrollador();
            $desarrollador->delete($id);
            echo json_encode(["message" => "Desarrollador eliminado"]);
        }

        public function store() {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $desarrollador = new Desarrollador($_POST['nombre'], $_POST['pais']);
            $desarrollador->insert();
            echo json_encode(["message" => "Desarrollador creado"]);
        }

        public function update($id) {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $desarrollador = new Desarrollador($_POST['nombre'], $_POST['pais']);
            $desarrollador->update($id);
            echo json_encode(["message" => "Desarrollador actualizado"]);
        }
    }

?>
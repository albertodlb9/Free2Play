<?php
    require_once __DIR__ . '/../models/Plataforma.php';
    require_once __DIR__ . '/../helpers/auth.php';
    
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
        public function destroy($id) {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(array("message" => "Acceso denegado"));
                return;
            }
            $plataforma = new Plataforma();
            $plataforma->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
       public function store() {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(array("message" => "Acceso denegado"));
                return;
            }
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);
            $plataforma = new Plataforma($data['nombre'], $data['empresa']);
            $plataforma->insert();
            echo json_encode(["message" => "Plataforma creada"]);
        }

        public function update($id) {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(array("message" => "Acceso denegado"));
                return;
            }
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);
            $plataforma = new Plataforma($data['nombre'], $data['empresa']);
            $plataforma->update($id);
            echo json_encode(["message" => "Plataforma actualizada"]);
        }
    }
?>
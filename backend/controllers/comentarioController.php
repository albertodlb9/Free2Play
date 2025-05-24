<?php
    require_once __DIR__ . '/../models/Comentario.php';
    require_once __DIR__ . '/../helpers/auth.php';

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
            $comentarioDatos = $comentario->get($id);
            $idUsuario = $comentarioDatos->usuario_id;
            $payload = verificarTokenYRol("admin", "usuario");
            if (!$payload || $payload->sub != $idUsuario) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $comentario->delete($id);
            echo json_encode(["message" => "Comentario eliminado"]);
        }
        public function store(){
            $payload = verificarTokenYRol("admin", "usuario");
            if (!$payload) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
             $json = file_get_contents('php://input');
             $data = json_decode($json, true);
             $comentario = new Comentario($data['usuario_id'], $data['review_id'], $data['contenido'], $data['fecha']);
             $comentario->insert();
    echo     json_encode(["message" => "Comentario creado"]);
        }

        public function update($id){
            $comentario = new Comentario();
            $comentarioDatos = $comentario->get($id);
            $idUsuario = $comentarioDatos->usuario_id;
            $payload = verificarTokenYRol("admin", "usuario");
            if (!$payload || $payload->sub != $idUsuario) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $comentario = new Comentario($data['usuario_id'], $data['review_id'], $data['contenido'], $data['fecha']);
            $comentario->update($id);
            echo json_encode(["message" => "Comentario actualizado"]);
        }

        public function destroy($id){
            $comentario = new Comentario();
            $comentarioDatos = $comentario->get($id);
            $idUsuario = $comentarioDatos->usuario_id;
            $payload = verificarTokenYRol("admin", "usuario");
            if (!$payload || $payload->sub != $idUsuario) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $comentario->delete($id);
            echo json_encode(["message" => "Comentario eliminado"]);
        }
    }
?>
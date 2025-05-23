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
        public function store(){
             $json = file_get_contents('php://input');
             $data = json_decode($json, true);
             $comentario = new Comentario($data['usuario_id'], $data['review_id'], $data['contenido'], $data['fecha']);
             $comentario->insert();
    echo     json_encode(["message" => "Comentario creado"]);
        }

        public function update($id){
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $comentario = new Comentario($data['usuario_id'], $data['review_id'], $data['contenido'], $data['fecha']);
            $comentario->update($id);
            echo json_encode(["message" => "Comentario actualizado"]);
        }

        public function destroy($id){
            $comentario = new Comentario();
            $comentario->delete($id);
            echo json_encode(["message" => "Comentario eliminado"]);
        }
    }
?>
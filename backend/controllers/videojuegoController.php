<?php
    class VideojuegoController {
        public function index() {
            $videojuego = new Videojuego();
            $videojuegos = $videojuego->getAll();
            echo json_encode($videojuegos);
        }

        public function show($id) {
            $videojuego = new Videojuego();
            $videojuego = $videojuego->get($id);
            echo json_encode($videojuego);
        }
        public function delete($id) {
            $videojuego = new Videojuego();
            $videojuego->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $videojuego = new Videojuego(/*Añadir los datos del videojuego*/);
            $videojuego->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $videojuego = new Videojuego(/*Añadir los datos del videojuego*/);
            $videojuego->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
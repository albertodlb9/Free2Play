<?php
    require_once __DIR__ . '/../models/Videojuego.php';
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

        public function destroy($id) {
            $videojuego = new Videojuego();
            $videojuego->delete($id);
            echo json_encode(["message" => "Videojuego eliminado"]);
        }

        public function store() {
            $data = json_decode(file_get_contents('php://input'), true);
            $videojuego = new Videojuego($data['titulo'], $data['descripcion'], $data['fecha_lanzamiento'], $data['desarrollador_id'], $data['portada']);
            $videojuego->insert();
            echo json_encode(["message" => "Videojuego creado"]);
        }

        public function update($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $videojuego = new Videojuego($data['titulo'], $data['descripcion'], $data['fecha_lanzamiento'], $data['desarrollador_id'], $data['portada']);
            $videojuego->update($id);
            echo json_encode(["message" => "Videojuego actualizado"]);
        }
    }
?>
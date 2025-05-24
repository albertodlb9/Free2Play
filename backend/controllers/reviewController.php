<?php
    require_once __DIR__ . '/../models/Review.php';
    class ReviewController {
        public function index() {
            $review = new Review();
            $reviews = $review->getAll();
            echo json_encode($reviews);
        }

        public function show($id) {
            $review = new Review();
            $review = $review->get($id);
            echo json_encode($review);
        }

        public function destroy($id) {
            $review = new Review();
            $review->delete($id);
            echo json_encode(["message" => "Review eliminado"]);
        }

        public function store() {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $review = new Review($data['usuario_id'], $data['videojuego_id'], $data['titulo'], $data['contenido'], $data['puntuacion'], $data['fecha']);
            $review->insert();
            echo json_encode(["message" => "Review creado"]);
        }

        public function update($id) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $review = new Review($data['usuario_id'], $data['videojuego_id'], $data['titulo'], $data['contenido'], $data['puntuacion'], $data['fecha']);
            $review->update($id);
            echo json_encode(["message" => "Review actualizado"]);
        }
    }
?>
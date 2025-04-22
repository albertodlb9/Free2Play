<?php
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
        public function delete($id) {
            $review = new Review();
            $review->delete($id);
            echo json_encode(array("message" => "Usuario eliminado"));
        }
        public function store($data){
            $review = new Review(/*añadir datos de review*/);
            $review->insert();
            echo json_encode(array("message" => "Usuario creado"));
        }

        public function update($id, $data){
            $review = new Review(/*añadir datos de review*/);
            $review->update($id);
            echo json_encode(array("message" => "Usuario actualizado"));
        }
    }
?>
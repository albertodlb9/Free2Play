<?php
    require_once __DIR__ . '/../models/Videojuego.php';
    require_once __DIR__ . '/../helpers/auth.php';
    
    class VideojuegoController {
        public function index() {
            $videojuego = new Videojuego();
            $videojuegos = $videojuego->getAll();
            echo json_encode($videojuegos);
        }

        public function show($id) {
            $videojuego = new Videojuego();
            $videojuego = $videojuego->getVideojugoConPlataformaYDesarrollador($id);
            echo json_encode($videojuego);
        }

        public function destroy($id) {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $videojuego = new Videojuego();
            $videojuego->delete($id);
            echo json_encode(["message" => "Videojuego eliminado"]);
        }

        public function store() {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }

            if (isset($_FILES['portada'])) {
                $nombre = $_FILES['portada']['name'];
                $rutaTemporal = $_FILES['portada']['tmp_name'];
                $extension = pathinfo($nombre, PATHINFO_EXTENSION);
                $portadaNombre = "http://localhost:8080/api/images/".$_POST['titulo'] . '.' . $extension;

                $directorioDestino = __DIR__ . '/../public/images/';
                if (!is_dir($directorioDestino)) {
                    mkdir($directorioDestino, 0777, true);
                }

                move_uploaded_file($rutaTemporal, $directorioDestino . $_POST['titulo'] . '.' . $extension);
            }

            $videojuego = new Videojuego(
                $_POST['titulo'],
                $_POST['descripcion'],
                $_POST['fecha'],
                $_POST['desarrolladorId'],
                $_POST['plataformaId'],
                $portadaNombre
            );
            $videojuego->insert();
            echo json_encode(["message" => "Videojuego creado"]);
        }

        public function update($id) {
            if(!verificarTokenYRol("admin")) {
                http_response_code(403);
                echo json_encode(["message" => "Acceso denegado"]);
                return;
            }
            $data = json_decode(file_get_contents('php://input'), true);
            $videojuego = new Videojuego($data['titulo'], $data['descripcion'], $data['fecha_lanzamiento'], $data['desarrollador_id'], $data['portada']);
            $videojuego->update($id);
            echo json_encode(["message" => "Videojuego actualizado"]);
        }
    }
?>
<?php
    // Aqui voy a poner las rutas de mi api
    require_once "./controllers/comentarioController.php";
    require_once "./controllers/reviewController.php";
    require_once "./controllers/usuarioController.php";
    require_once "./controllers/plataformaController.php";
    require_once "./controllers/videojuegoController.php";
    require_once "./controllers/desarrolladorController.php";

    $url = $_SERVER['REQUEST_URI'];
    $api = explode('/', $url)[2];
    $partesUrl = explode('/', $url);

    $metodo = $_SERVER['REQUEST_METHOD'];

    if($api === 'comentarios'){
        $comentarioController = new ComentarioController();
        if($metodo === 'GET' && $url === "/api/comentarios"){
            $comentarioController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $comentarioController->show($id);
        } elseif($metodo === 'POST'){
            $comentarioController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $comentarioController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $comentarioController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'reviews'){
        $reviewController = new ReviewController();
        if($metodo === 'GET' && $url === "/api/reviews"){
            $reviewController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $reviewController->show($id);
        } elseif($metodo === 'POST'){
            $reviewController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $reviewController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $reviewController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'usuarios'){
        $usuarioController = new UsuarioController();
        if($metodo === 'GET' && $url === "/api/usuarios"){
            $usuarioController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $usuarioController->show($id);
        } elseif($metodo === 'POST'){
            $usuarioController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $usuarioController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $usuarioController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'plataformas'){
        $plataformaController = new PlataformaController();
        if($metodo === 'GET' && $url === "/api/plataformas"){
            $plataformaController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $plataformaController->show($id);
        } elseif($metodo === 'POST'){
            $plataformaController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $plataformaController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $plataformaController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'videojuegos'){
        $videojuegoController = new VideojuegoController();
        if($metodo === 'GET' && $url === "/api/videojuegos"){
            $videojuegoController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $videojuegoController->show($id);
        } elseif($metodo === 'POST'){
            $videojuegoController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $videojuegoController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $videojuegoController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'desarrolladores'){
        $desarrolladorController = new DesarrolladorController();
        if($metodo === 'GET' && $url === "/api/desarrolladores"){
            $desarrolladorController->index();
        } elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $desarrolladorController->show($id);
        } elseif($metodo === 'POST'){
            $desarrolladorController->store();
        } elseif($metodo === 'PUT' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $desarrolladorController->update($partesUrl[3]);
        } elseif($metodo === 'DELETE' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $desarrolladorController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } else{
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint no encontrado']);
    }
?>
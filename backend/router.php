<?php
    require_once __DIR__."/controllers/reviewController.php";
    require_once __DIR__."/controllers/usuarioController.php";
    require_once __DIR__."/controllers/plataformaController.php";
    require_once __DIR__."/controllers/videojuegoController.php";
    require_once __DIR__."/controllers/desarrolladorController.php";
    require_once __DIR__."/controllers/comentarioController.php";

    $url = $_SERVER['REQUEST_URI'];
    $api = explode('/', $url)[2];
    $partesUrl = explode('/', $url);
    $metodo = $_SERVER['REQUEST_METHOD'];

    if($api === 'comentarios'){
        $comentarioController = new ComentarioController();
        if($metodo == 'GET' && $url == "/api/comentarios"){
            $comentarioController->index(); 
        } else if($metodo === 'GET' && count($partesUrl) === 5 && $partesUrl[3] === 'review' && $partesUrl[4] !== ''){
            $reviewId = $partesUrl[4];
            $comentarioController->getComentariosByReview($reviewId);
        }elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $comentarioController->show($id);
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $comentarioController->store();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $comentarioController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
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
        } elseif($metodo === 'GET' && count($partesUrl) === 5 && $partesUrl[3] === 'videojuego' && $partesUrl[4] !== ''){
            $videojuegoId = $partesUrl[4];
            $reviewController->getReviewsByVideojuego($videojuegoId);
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $reviewController->store();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $reviewController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $reviewController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'usuarios'){
        
        $usuarioController = new UsuarioController();
        if($metodo === 'GET' && $url === "/api/usuarios"){

            $usuarioController->index();
        } elseif($metodo === 'GET' && $url === "/api/usuarios/loged"){
            $usuarioController->verificarToken();
        }
        elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $usuarioController->show($id);
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $usuarioController->store();
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'login'){
            $usuarioController->login();
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'logout'){
            $usuarioController->logout();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $usuarioController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
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
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $plataformaController->store();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $plataformaController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $plataformaController->destroy($partesUrl[3]);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    } elseif($api === 'videojuegos'){
        $videojuegoController = new VideojuegoController();
        if($metodo === 'GET' && $url === "/api/videojuegos"){
            $videojuegoController->index();
        } else if($metodo === 'GET' && $url === "/api/videojuegos/videojuegosMasValorados"){
            $videojuegoController->getVideojuegosMasValorados();
        }elseif($metodo === 'GET' && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $id = $partesUrl[3];
            $videojuegoController->show($id);
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $videojuegoController->store();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $videojuegoController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
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
        } elseif($metodo === 'POST' && count($partesUrl) === 4 && $partesUrl[3] === 'store'){
            $desarrolladorController->store();
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "PUT"  && count($partesUrl) === 4 && $partesUrl[3] !== ''){
            $desarrolladorController->update($partesUrl[3]);
        } elseif($metodo === 'POST' && isset($_POST["_method"]) && $_POST["_method"] == "DELETE" && count($partesUrl) === 4 && $partesUrl[3] !== ''){
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
<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarTokenYRol(...$roles) {
    if (!isset($_COOKIE['token'])) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit;
    }

    try {
        $jwt = $_COOKIE['token'];
        $claveSecreta = CLAVE_SECRETA;
        $payload = JWT::decode($jwt, new Key($claveSecreta, 'HS256'));

        if (!empty($roles) && !in_array($payload->data->rol, $roles)) {
            http_response_code(403);
            echo json_encode(["error" => "Acceso denegado"]);
            return false;
        }

        return $payload; 

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido"]);
        exit;
    }
}

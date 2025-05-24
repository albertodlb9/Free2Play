<?php
    require_once __DIR__ . '/../models/Usuario.php';
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../helpers/auth.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    class UsuarioController {
        public function index() {
            $usuario = new Usuario();
            $usuarios = $usuario->getAll();
            echo json_encode($usuarios);
        }

        public function show($id) {
            $usuario = new Usuario();
            $usuario = $usuario->get($id);
            echo json_encode($usuario);
        }

        public function destroy($id) {
            $usuario = new Usuario();
            $usuario->delete($id);
            echo json_encode(["message" => "Usuario eliminado"]);
        }

        public function store() {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $usuario = new Usuario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $usuario->insert();
            echo json_encode(["message" => "Usuario creado"]);
        }

        public function update($id) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $usuario = new Usuario($data['nombreUsuario'], $data['nombre'], $data['apellido1'], $data['apellido2'], $data['email'], $data['password'], $data['rol'], $data['telefono'], $data['direccion'], $data['avatar']);
            $usuario->update($id);
            echo json_encode(["message" => "Usuario actualizado"]);
        }

        public function login() {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $usuario = new Usuario();
            $usuario = $usuario->buscarPorUsuario($data['nombreUsuario']);
            if ($usuario && password_verify($data['password'], $usuario->password)) {
                $payload = [
                            "iss" => "http://localhost",           
                            "sub" => $usuario->id,        
                            "iat" => time(),                       
                            "exp" => time() + 604800*3,                
                            "data" => [
                                "username" => $usuario->nombreUsuario,
                                "rol" => $usuario->rol,
                            ]
                        ];
                $jwt = JWT::encode($payload, CLAVE_SECRETA, 'HS256');
                setcookie("token", $jwt, time() + 604800*3, "/", "", false, true);
                echo json_encode(["message" => "Login exitoso", "usuario" => $usuario]);
            } else {
                http_response_code(401);
                echo json_encode(["message" => "Credenciales incorrectas"]);
            }
        }

        public function logout() {
            setcookie("token", "", time() - 3600, "/", "", false, true);
            echo json_encode(["message" => "Logout correcto"]);
        }

        public function verificarToken() {
            if (isset($_COOKIE['token'])) {
                try {
                    $decodificado = JWT::decode($_COOKIE['token'], new Key(CLAVE_SECRETA, 'HS256'));
                    $usuario = new Usuario();
                    $usuario = $usuario->get($decodificado->sub);
                    if ($usuario) {
                        return $usuario;
                    } else {
                        http_response_code(401);
                        echo json_encode(["message" => "Usuario no encontrado"]);
                    }  
                } catch (Exception $e) {
                    http_response_code(401);
                    echo json_encode(["message" => "Token inválido"]);
                }
            } else {
                http_response_code(401);
                echo json_encode(["message" => "No se ha proporcionado un token"]);
            }
        }
    }


?>
<?php
    if(file_exists('../config.php') && filesize('../config.php') > 0){
        header('Location: ../../frontend/index.html');
        exit();
    }
    if($_POST["instalar"] && is_writable('../')){
        $mensaje = "";
        $instalacion = true;
        $error = false;
        try{
            $host = $_POST["host"];
            $user = $_POST["user"];
            $password = $_POST["password"];
            $database = $_POST["database"];
            $port = $_POST["port"];

            $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

            $nombre = $_POST["admin_name"];
            $apellidos = $_POST["admin_apellido"];
            $login = $_POST["admin"];
            $admin_password = $_POST["admin_password"];
            $admin_email = $_POST["admin_email"];
            $salt = $salt=random_int(10000000,99999999);
            $admin_password = password_hash($admin_password.$salt, PASSWORD_DEFAULT);

            $sql['usuarios'] = <<<SQL
                CREATE TABLE usuarios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
                    nombre VARCHAR(50),
                    apellido1 VARCHAR(50),
                    apellido2 VARCHAR(50),
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    rol ENUM('admin', 'usuario'),
                    telefono VARCHAR(20),
                    direccion VARCHAR(255),
                    avatar VARCHAR(255),
                    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
                );
            SQL;
            $sql['insert_admin'] = <<<SQL
                INSERT INTO usuarios(nombre,nombre_usuario,email,password,salt,rol)
                VALUES('$nombre','$login','$admin_email','$admin_password',$salt,'admin');
            SQL;
            $sql['desarrolladores']=<<<SQL
                CREATE TABLE desarrolladores (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    pais VARCHAR(100)
                );
            SQL;
            $sql['videojuegos']=<<<SQL
                CREATE TABLE videojuegos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    titulo VARCHAR(100) NOT NULL,
                    descripcion TEXT,
                    fecha_lanzamiento DATE,
                    desarrollador_id INT,
                    nota_media DECIMAL(3,1) DEFAULT 0.0,
                    portada VARCHAR(255),
                    FOREIGN KEY (desarrollador_id) REFERENCES desarrolladores(id) ON DELETE SET NULL
                );
            SQL;
            $sql['plataformas']=<<<SQL
                CREATE TABLE plataformas (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    empresa VARCHAR(100)
                );
            SQL;
            $sql['videojuegos_plataformas']=<<<SQL
                CREATE TABLE videojuegos_plataformas (
                    videojuego_id INT,
                    plataforma_id INT,
                    PRIMARY KEY (videojuego_id, plataforma_id),
                    FOREIGN KEY (videojuego_id) REFERENCES videojuegos(id) ON DELETE CASCADE,
                    FOREIGN KEY (plataforma_id) REFERENCES plataformas(id) ON DELETE CASCADE
                );
            SQL;
            $sql['reviews']=<<<SQL
                CREATE TABLE reviews (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario_id INT NOT NULL,
                    videojuego_id INT NOT NULL,
                    titulo VARCHAR(100),
                    contenido TEXT,
                    puntuacion INT CHECK (puntuacion BETWEEN 0 AND 10),
                    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                    FOREIGN KEY (videojuego_id) REFERENCES videojuegos(id) ON DELETE CASCADE
                );
            SQL;
            $sql['comentarios']=<<<SQL
                CREATE TABLE comentarios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    review_id INT NOT NULL,
                    usuario_id INT NOT NULL,
                    contenido TEXT,
                    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
                );
            SQL;
            foreach($sql as $clave => $valor){
                try{
                    $sentencia = $conn->prepare($valor);
                    $sentencia->execute();
                }catch(PDOException $e){
                    $error = true;
                    $mensaje = $e->getMessage();
                }
            }
            if($error){
                $instalacion = false;
            } else{
                $config = <<<CONFIG
                <?php
                    define('DB_HOST', '$host');
                    define('DB_USER', '$user');
                    define('DB_PASSWORD', '$password');
                    define('DB_NAME', '$database');
                    define('DB_PORT', '$port');
                    define('DB_DRIVER', 'mysql');
                ?>
                CONFIG;

                $fp = fopen('../config.php', 'w');
                fwrite($fp, $config);
                fclose($fp);
                header('Location: ../../frontend/index.html');
            }  
        }catch(PDOException $e){
            $mensaje = $e->getMessage();
            $instalacion = false;
        }
    }else{
        $mensaje = "No se puede escribir en el directorio";
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacion Free2Play</title>
</head>
<body>
    <h1>Instalacion de la aplicacion Free2Play</h1>
    <h3>Requisitos para realizar la instalación:</h3>
    <ol>
        <li>IP o nombre del host para el sistema gestor de bases de datos Mysql</li>
        <li>Usuario con privilegios sobre una base de datos en ese SGBD</li>
        <li>Contraseña del usuario</li>
        <li>Nombre de la base de datos</li>
        <li>Puerto de conexión a esa base de datos (si no es el estándar)</li>
    </ol>
    
    <form action="install.php" method="post">
        <h3>Datos del SGDB:</h3>
        <label for="host">Host:</label>
        <input type="text" name="host" id="host" required>
        <br>
        <label for="user">Usuario:</label>
        <input type="text" name="user" id="user" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="database">Base de datos:</label>
        <input type="text" name="database" id="database" required>
        <br>
        <label for="port">Puerto:</label>
        <input type="number" name="port" id="port" value="3306">
        <br>
        <h3>Datos del administrador:</h3>
        <label for="admin_name">Nombre:</label>
        <input type="text" name="admin_name" id="admin_name" required>
        <br>
        <label for="admin">Usuario:</label>
        <input type="text" name="admin" id="admin" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="admin_email" id="admin_email" required>
        <label for="admin_password">Contraseña:</label>
        <input type="password" name="admin_password" id="admin_password" required>
        <br>
        <input type="submit" name ="instalar" value="Instalar">
    </form>

    <?php
        if(!$instalacion && isset($_POST["instalar"])){
            echo "<h2>Instalación fallida</h2>";
            echo "<p>$mensaje</p>";
        }
    ?>

</body>
</html>

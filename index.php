<?php
    if(file_exists('./backend/config.php') && filesize('./backend/config.php') > 0){
        header('Location: ./frontend/index.html');
        exit();
    } else{
        header('Location: ./backend/installer/install.php');
        exit();
    }
?>
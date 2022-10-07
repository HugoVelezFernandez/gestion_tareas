<?php
    // Mostrar errores de php
    ini_set('display_errors', 1);   

    // Si no existe el Token te redirecciona al login
    include('jwt.php');
    if(isset($_GET["salir"])){
        if($_GET["salir"] == true){
            setcookie("Token", 'z', time()-(60), "/"); 
            header('Location: /curso/');
        }
    }

    // Si existe el token guarda el id del usuario 
    if(isset($_COOKIE["Token"])){
        $token_cookie = jwt_decode($_COOKIE["Token"]);
        $id_token_decode = $token_cookie->sub;
    }else{
        header('Location: /curso/');
    }
?>
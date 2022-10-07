<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 

    // Comprobar que se han recogido datos y insertarlos en la base de datos, en cada caso mostrar un "problem" distinto
    if(!empty($_POST['name']) AND !empty($_POST['pass'])){
        $name = $_POST['name']; $pass = $_POST['pass']; $hash_pash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE `usuarios` SET `nombre` = '$name', `passwd` = '$hash_pash' WHERE `usuarios`.`id` = $id_token_decode";
        if(mysqli_query($conn, $sql)){header('Location: ../settings.php?problem=0');}else{header('Location: ../settings.php?problem=1');}
    }else{header('Location: ../settings.php?problemnid=1');}
?>
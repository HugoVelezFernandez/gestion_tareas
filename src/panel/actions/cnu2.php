<?php
        include('../../php/cnn.php');
        include('../../php/jwt.php');

        // Condicional para evitar variables indefinidas
        if(!empty($_POST['name']) AND !empty($_POST['pass']) ){
            // Recogida de datos
            $name = $_POST['name'];
            $pass = $_POST['pass'];

            $hash_pash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `passwd`) VALUES (NULL, '$name', '$hash_pash')";
            if(mysqli_query($conn, $sql)){header('Location: ../settings.php?problem=0');}else{header('Location: ../settings.php?problem=1');}
        }else{
            {header('Location: ../settings.php?problemnid=1');}
        }
    ?>
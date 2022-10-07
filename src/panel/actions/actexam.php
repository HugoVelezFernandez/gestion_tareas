<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php');  

    if(!empty($_POST['asignatura'])){
        $asig = $_POST['asignatura'];
        $texto = $_POST['texto'];
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];

        $sql_insert = "INSERT INTO `examenes` (`id`, `vinc_usuario`, `asignatura`, `texto`, `dia`, `mes`, `realizado`, `nota`) 
        VALUES (NULL, '$id_token_decode', '$asig', '$texto', '$dia', '$mes', 'No', '0')";

        if(mysqli_query($conn, $sql_insert)){header('Location: ../examenes.php');}else{echo "header('Location: ../examenes.php?problem=1')";}
    }
?>
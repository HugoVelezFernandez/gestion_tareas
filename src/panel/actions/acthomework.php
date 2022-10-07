<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php');  

    if(!empty($_POST['asignatura'])){
        $asig = $_POST['asignatura'];
        $texto = $_POST['texto'];
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];

        $sql_insert = "INSERT INTO `tareas` (`id`, `vinc_usuario`, `asignatura`, `texto`, `dia_entrega`, `mes_entrega`, `realizado`, `entregado`, `en_plazo`) 
        VALUES (NULL, '$id_token_decode', '$asig', '$texto', '$dia', '$mes', 'No', 'No', 'Por determinar')";

        if(mysqli_query($conn, $sql_insert)){header('Location: ../tareas.php');}else{echo "header('Location: ../tareas.php?problem=1')";}
    }
?>
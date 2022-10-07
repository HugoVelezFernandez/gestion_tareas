<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/general.css">
    <link rel="shortcut icon" href="../../imgs/hwf.png" type="image/x-icon">
    <title>Add Subject</title>
</head>
<body>
    <div class="barra-superior">

        <div class="seccion"> <h1 class="titulo-seccion">Add</h1> </div>
        <div class="apartados">
            <a href="../../panel"><button class="boton-apartados">Home</button></a>
            <a href="../tareas.php"><button class="boton-apartados">Homeworks</button></a>
            <a href="../trabajos.php"><button class="boton-apartados">Works</button></a>
            <a href="../examenes.php"><button class="boton-apartados">Exams</button></a>
            <a href="../settings.php"><button class="boton-apartados">Settings</button></a>
        </div>
        <div class="cerrar-sesion"> <a class="a-bcs" href="?salir=true"><button class="boton-cerrar-sesion">Log Out</button></a> </div>

    </div>
    <div class="caja-login border-g">
        <div class="div-titulo-login"><h1>New Subject</h1></div>
        <div>
            <form action="" method="post">
                <input class="input-login" name="asig" type="text" placeholder="Asignature"> <br>
                <input Class="boton-enviar" type="submit" value="New">

    <?php
        if(!empty($_POST['asig'])){
            $asig = $_POST['asig'];
            $sql = "INSERT INTO `asignaturas` (`id`, `name`, `vinc_usuario`) VALUES (NULL, '$asig', '$id_token_decode');";
            if(mysqli_query($conn, $sql)){header('Location: ../settings.php');}else{header('Location: ../settings.php');}
        }
    ?>

</body>
</html>
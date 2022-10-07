<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/general.css">
    <link rel="shortcut icon" href="../../imgs/hwf.png" type="image/x-icon">
    <title>Delete</title>
</head>
<body>
    <div class="caja-login border-g">
        <h1>Are you sure you want to delete this homework? </h1>
        <form action="" method="post">
            <input type="hidden" name="hid" value="yes">
            <input class="boton-enviar" type="submit" value="Yes">
        </form>
        <form action="" method="post">
            <input type="hidden" name="hid" value="no">
            <input class="boton-enviar" type="submit" value="No">
        </form>
    </div>
</body>
</html>
<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 

    // Comprobar que se han recogido datos y insertarlos en la base de datos, en cada caso mostrar un "problem" distinto
    if(!empty($_POST['hid'])){
        if($_POST['hid'] == "yes"){
            $id = $_GET['id'];
            $sql = "DELETE FROM `usuarios` WHERE `usuarios`.`id` = '$id'";
            if(mysqli_query($conn, $sql)){header('Location: ../settings.php');}else{header('Location: ../settings.php');}
        }else{header('Location: ../settings.php');}
    }
?>
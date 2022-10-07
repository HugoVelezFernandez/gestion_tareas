<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/general.css">
    <link rel="shortcut icon" href="../../imgs/hwf.png" type="image/x-icon">
    <title>Add user</title>
</head>
<body>
    <div class="barra-superior">

        <div class="seccion"> <h1 class="titulo-seccion">New User</h1> </div>
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
        <div class="div-titulo-login"><h1>New User</h1></div>
        <div>
            <form action="" method="post">
                <input class="input-login" name="name" type="text" placeholder="Name"> <br>
                <input class="input-login" name="pass" type="text" placeholder="Password"> <br>
                <input Class="boton-enviar" type="submit" value="New">
            </form>
        </div> 
    </div>

    <?php
        include('../../php/auth.php'); 
        include('../../php/cnn.php'); 

        // Comprobar que se han recogido datos y insertarlos en la base de datos, en cada caso mostrar un "problem" distinto
        if(!empty($_POST['name']) AND !empty($_POST['pass'])){
            $name = $_POST['name']; $pass = $_POST['pass']; $hash_pash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `passwd`) VALUES (NULL, '$name', '$hash_pash')";
            if(mysqli_query($conn, $sql)){header('Location: ../settings.php');}else{header('Location: ../settings.php');}
        }
    ?>

</body>
</html>
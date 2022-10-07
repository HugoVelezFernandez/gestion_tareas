<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="shortcut icon" href="../imgs/hwf.png" type="image/x-icon">
    <title>CNU</title>
</head>
<body>
    <div class="caja-login border-g">
        <div class="div-titulo-login"><h1>Create New User</h1></div>
        <div>
            <form action="" method="post">
                <input class="input-login" name="nombre" type="text" placeholder="Name" autocomplete="no"> <br>
                <input class="input-login" name="pass" type="password" placeholder="Password"> <br>
                <input Class="boton-enviar" type="submit" value="CNU">
            </form>
        </div> 
    </div>

    <?php
        include('../php/cnn.php');
        include('../php/jwt.php');

        $sql_find = "SELECT id FROM usuarios"; $z = 0;
        if($result = $conn->query($sql_find)){while($row = $result->fetch_assoc()){$z++;}}
       
        // Bloqueo si existen usuarios (Deshabilitar si surge fallo logico)
        if($z != 0){header('Location: ../');}

        // Condicional para evitar variables indefinidas
        if(!empty($_POST['nombre']) AND !empty($_POST['pass']) ){
            // Recogida de datos
            $name = $_POST['nombre'];
            $pass = $_POST['pass'];

            $hash_pash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `passwd`) VALUES (NULL, '$name', '$hash_pash')";
            if(mysqli_query($conn, $sql)){header('Location: ../');}else{echo "<script>alert('Ha ocurrido un error');</script>";}
        }
    ?>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="shortcut icon" href="imgs/hwf.png" type="image/x-icon">
    <title>Log In</title>
</head>
<body>
    <div class="caja-login border-g">
        <div class="div-titulo-login"><h1>Log in</h1></div>
        <div>
            <form action="" method="post">
                <input class="input-login" name="nombre" type="text" placeholder="Name"> <br>
                <input class="input-login" name="pass" type="password" placeholder="Password"> <br>
                <input Class="boton-enviar" type="submit" value="Log in">
            </form>
            <a class="link-dhu" href="php/cnu.php">Don't have a user?</a>
        </div> 
    </div>


    <?php
        include('php/cnn.php');
        include('php/jwt.php');

        if(isset($_COOKIE["Token"])){header('Location: panel/');}
        
        // Condicional para evitar variables indefinidas
        if(!empty($_POST['nombre'])){
            // Recogida de datos
            $name = $_POST['nombre'];
            $pass = $_POST['pass'];

            // Comprobar datos
            $sql_find = "SELECT * FROM usuarios WHERE nombre = '$name'";
            $nombre = ""; $passwd = "";
            if($result = $conn->query($sql_find)){
                while($row = $result->fetch_assoc()){
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $passwd = $row['passwd'];
                }
            }
            if(($name == $nombre) AND (password_verify($pass, $passwd))){
                $array_token = array(
                    'iat' => time(),
                    'exp' => time() + (60*60*24*30),
                    'sub' => $id
                );
                $token = jwt_encode($array_token);
                setcookie("Token", $token, time()+(60*60*24*30), "/");
                header('Location: panel/');
            }else{
                echo "<script>alert('Incorrect name or password');</script>";
            }
        }

    ?>

</body>
</html>
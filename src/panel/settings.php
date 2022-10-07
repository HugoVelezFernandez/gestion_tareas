<?php 
    include('../php/auth.php'); 
    include('../php/cnn.php');

    // Recoger el dato "name" del usuario actual
    $sql = "SELECT nombre FROM usuarios WHERE id = $id_token_decode";
    if($result = $conn->query($sql)){
        while($row = $result->fetch_assoc()){
            $name = $row['nombre'];
        }
    }

    // Mostrar distintos mensajes segun el metodo GET
    if(isset($_GET['problem']) AND $_GET['problem'] == 0){echo '<script>alert("Insert Data: OK");</script>';}
    if(isset($_GET['problem']) AND $_GET['problem'] == 1){echo '<script>alert("Insert Data: Error");</script>';}
    if(isset($_GET['problemnid']) AND $_GET['problemnid'] == 1){echo '<script>alert("Insert All Data.");</script>';}

    // Mostrar crear nuevo usuario si es admin (WHERE id = 1)
    $mcnu = "block";
    if($id_token_decode != 1){$mcnu = "none";}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="shortcut icon" href="../imgs/hwf.png" type="image/x-icon">
    <title>Panel</title>
</head>
<body class="body-panel">
    <div class="div-bs-c">

        <div class="barra-superior">

            <div class="seccion"> <h1 class="titulo-seccion">Settings</h1> </div>
            <div class="apartados">
                <a href="../panel"><button class="boton-apartados">Home</button></a>
                <a href="tareas.php"><button class="boton-apartados">Homeworks</button></a>
                <a href="trabajos.php"><button class="boton-apartados">Works</button></a>
                <a href="examenes.php"><button class="boton-apartados">Exams</button></a>
                <a href="settings.php"><button class="boton-apartados">Settings</button></a>
            </div>
            <div class="cerrar-sesion"> <a class="a-bcs" href="?salir=true"><button class="boton-cerrar-sesion">Log Out</button></a> </div>

        </div>

        <div class="contenido00">

            <!--
            <div style="display:<?php echo $mcnu; ?>" class="ud fr border-g">
                <h3 class="settings-title">Create new user</h3>

                <form class="form-settings" action="actions/cnu2.php" method="post">
                    <input class="input-login2" type="text" name="name" placeholder="Name">
                    <input class="input-login2" type="password" name="pass" placeholder="Password">
                    <input class="boton-enviar" type="submit" value="CNU">
                </form>

            </div>
            -->

        </div>

        <div class="ud fr border-g">
            <h3 class="settings-title">Subject list</h3>

            <table class="tabla-settings">

                <?php
                    $sql = "SELECT * FROM asignaturas WHERE vinc_usuario = '$id_token_decode'"; $cn = 0;
                    if($result = $conn->query($sql)){
                        while($row = $result->fetch_assoc()){
                            $cn++;
                            $id_asig = $row['id'];
                            $name_asig = $row['name'];
                            echo '
                                <tr class="trs">
                                    <td class="td1">'.$cn.'. '.$name_asig.'</td>
                                    <td class="td2"> <a class="a-li" href="actions/delete_asig.php?id='.$id_asig.'"> <img calss="img-delete" src="../imgs/delete_img.png" alt="" width="26px"> </a> </td>
                                </tr>
                            ';
                        }
                    }
                ?>

            </table>

            <div class="div-sub-table">
                <a class="mas-sub-table" href="actions/anhadir_asignatura.php">+</a>
            </div>

        </div>

        <div class="ud fr border-g">
            <h3 class="settings-title">User: <?php echo $name ?></h3>

            <form class="form-settings" action="actions/uu.php" method="post">
                <input class="input-login2" type="text" name="name" placeholder="Name" value="<?php echo $name; ?>">
                <input class="input-login2" type="password" name="pass" placeholder="Password">
                <input class="boton-enviar" type="submit" value="Change">
            </form>

        </div>

        <div style="display:<?php echo $mcnu; ?>" class="ud fr border-g">
            <h3 class="settings-title">Users</h3>

            <table class="tabla-settings">

                <?php
                    $sql = "SELECT * FROM usuarios"; $cn = 0;
                    if($result = $conn->query($sql)){
                        while($row = $result->fetch_assoc()){
                            $cn++;
                            $id_asig = $row['id'];
                            $name_asig = $row['nombre'];
                            echo '
                                <tr class="trs">
                                    <td class="td1">'.$cn.'. '.$name_asig.'</td>
                                    <td class="td2"> <a class="a-li" href="actions/delete_user.php?id='.$id_asig.'"> <img calss="img-delete" src="../imgs/delete_img.png" alt="" width="26px"> </a> </td>
                                </tr>
                            ';
                        }
                    }
                ?>

            </table>

            <div class="div-sub-table">
                <a class="mas-sub-table" href="actions/add_user.php">+</a>
            </div>

        </div>

    </div>
</body>
</html>
<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 

    if(isset($_GET['id'])){$id = $_GET['id'];}else{header('Location: ../tareas.php');}
    $sql_find = "SELECT * FROM examenes WHERE id = '$id'";
    if($result = $conn->query($sql_find)){
        while($row = $result->fetch_assoc()){
            $asig = $row['asignatura'];
            $text = $row['texto'];
            $day = $row['dia'];
            $month = $row['mes'];
            $realizado = $row['realizado'];
            $nota = $row['nota'];
        }
    }

    if($realizado == "No"){$re = "Yes";}else{$re = "No";}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/general.css">
    <link rel="shortcut icon" href="../../imgs/hwf.png" type="image/x-icon">
    <title>Change data</title>
</head>
<body>
    <div class="barra-superior">

        <div class="seccion"> <h1 class="titulo-seccion">Change</h1> </div>
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
        <div class="div-titulo-login"><h1>Change data</h1></div>
        <div>
            <form action="" method="post">
                <input class="input-login" name="asig" type="text" placeholder="Asignature" value="<?php echo $asig; ?>"> <br>
                <textarea class="input-login" name="pass" type="password" placeholder="Text"><?php echo $text; ?></textarea> <br>
                <input class="input-login" name="day" type="text" placeholder="Day" value="<?php echo $day; ?>"> <br>
                <select class="select-login" name="month" id="">
                    <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select> <br>
                <input class="input-login" name="nota" type="text" placeholder="Note" value="<?php echo $nota; ?>"> <br>
                <input Class="boton-enviar" type="submit" value="Change">
            </form>
            <div><p><b>Realized:</b> <?php echo $realizado; ?> <a href="realizadoe.php?id=<?php echo $id; ?>"><button class="boton-tareas-2"><?php echo $re; ?></button></a></p></div>
        </div> 
    </div>

    <div style="text-align: center;"><a href="deletee.php?id=<?php echo $id; ?>"><button Class="boton-enviar-delete">Delete</button></a></div>

    <?php
        if(!empty($_POST['asig'])){
            $asig_update = $_POST['asig'];
            $pass_update = $_POST['pass'];
            $day_update = $_POST['day'];
            $month_update = $_POST['month'];
            $nota = $_POST['nota'];
            
            $sql_update = "UPDATE `examenes` SET 
                `asignatura` = '$asig_update', 
                `texto` = '$pass_update', 
                `dia` = '$day_update', 
                `mes` = '$month_update', 
                `nota` = $nota 
                WHERE `examenes`.`id` = '$id'";

            if(mysqli_query($conn, $sql_update)){echo "<script>alert('Datos introducidos correctamente');</script>";}else{echo "<script>alert('Ha ocurrido un error');</script>";}
        }
    ?>

</body>
</html>
<?php 
    include('../php/auth.php'); 
    include('../php/cnn.php');  
    $inicio_mostrar_sql = 0;
    $max_mostrar_sql = 4;
    $m = 0; $me = 0; $n_paginas = 0; $contar = 0;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $inicio_mostrar_sql = ($page - 1) * $max_mostrar_sql;

    // Ver el mes actual
    $months = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July ',
        'August',
        'September',
        'October',
        'November',
        'December',
    );
     $actual_month =  date('n') - 1;
     $sm = $months[$actual_month];

    // No mostrar datos si no hay datos
    $csmdon = 0;
    $sql_find_tareas = "SELECT id FROM trabajos WHERE vinc_usuario = $id_token_decode  AND entregado = 'Yes'";
    if($result = $conn->query($sql_find_tareas)){
        while($row = $result->fetch_assoc()){$csmdon++;}}
    
    $mostrar = "";
    if($csmdon == 0){$mostrar = "display: none;";}
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

            <div class="seccion"> <h1 class="titulo-seccion">Works</h1> </div>
            <div class="apartados">
                <a href="../panel"><button class="boton-apartados">Home</button></a>
                <a href="tareas.php"><button class="boton-apartados">Homeworks</button></a>
                <a href="trabajos.php"><button class="boton-apartados">Works</button></a>
                <a href="examenes.php"><button class="boton-apartados">Exams</button></a>
                <a href="settings.php"><button class="boton-apartados">Settings</button></a>
            </div>
            <div class="cerrar-sesion"> <a class="a-bcs" href="?salir=true"><button class="boton-cerrar-sesion">Log Out</button></a> </div>

        </div>
        <div class="contenido">
            <div class="div-contenido">
                <div class="div-principal border-g">
                    <h2 class="titulo-md">Work list</h2>
                    <div class="caja-mostrar-tareas">
                        <div style="display: flex; <?php echo $mostrar; ?>">
                            <div class="caja-datos-tareas principal">Especific action</div>
                            <div class="caja-datos-tareas principal ns">Time limit</div>
                            <div class="caja-datos-tareas principal">Change data</div>
                        </div>
                        <?php
                            if(!empty($_GET['sdh']) AND $_GET['sdh'] == "on"){header('location: trabajos.php');}

                            $sql_ch2 = "SELECT id FROM trabajos WHERE vinc_usuario = $id_token_decode AND entregado = 'Yes'";
                            if($result = $conn->query($sql_ch2)){while($row = $result->fetch_assoc()){$contar = $contar + 1;}}

                            $sql_find_tareas = "SELECT id, asignatura, texto, dia, mes FROM trabajos WHERE vinc_usuario = $id_token_decode  AND entregado = 'Yes' LIMIT $inicio_mostrar_sql,$max_mostrar_sql";
                            if($result = $conn->query($sql_find_tareas)){
                                while($row = $result->fetch_assoc()){
                                    $id_homework = $row['id'];
                                    echo '
                                    <div style="display: flex;">
                                        <div class="caja-datos-tareas">'.$row["texto"].'</div>
                                        <div class="caja-datos-tareas ns">'.$row["dia"]." ".$row["mes"].'</div>
                                        <div class="caja-datos-tareas"><a href="actions/cdw.php?id='.$id_homework.'"><button class="boton-tareas">Change data</button></a></div>
                                    </div>';
                                }
                            }
                            
                            $n_paginas = ceil($contar / $max_mostrar_sql); if($n_paginas == 0){$n_paginas = $n_paginas + 1;}
                        ?>
                    </div>
                    <form action="" method="get">
                    <div id="pages" style="<?php echo $mostrar; ?>">Page: 
                        <?php
                            while($m < $n_paginas){
                                $m = $m + 1;
                                $me = $me + 1;
                                echo '<button class="bt_buscador" name="page" value="'.$m.'">'.$m.'</button>';
                                if($me >= 5){break;}
                            }
                        ?>
                    </div>
                    <div class="pages">
                        <input type="checkbox" name="sdh"> Show Normal Works
                        <input class="boton-tareas" type="submit" value="Find">
                    </div>
                    </form>
                </div>
                <div class="div-secundario">
                    <div class="div-sqlinsert border-g">
                        <h2 class="titulo-general-login">Config new work</h1>
                        <form action="actions/actwork.php" method="post">
                            <div>
                                <h4 class="titulo-insert-data">Select asignature</h4>
                                <select class="input-type-1" name="asignatura" id="">
                                    <option value="">Select asignature</option>
                                    <?php
                                        $sql_asignaturas = "SELECT * FROM asignaturas WHERE vinc_usuario = $id_token_decode";
                                        if($result = $conn->query($sql_asignaturas)){
                                            while($row = $result->fetch_assoc()){
                                                $options = $row['name'];
                                                echo '<option value="'.$options.'">'.$options.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <h4 class="titulo-insert-data">Descriptive text</h4>
                                <textarea class="input-type-1" name="texto" id="" placeholder="Descriptive text"></textarea>
                            </div>
                            <div>
                                <h4 class="titulo-insert-data">Insert expire time</h4>
                                <div class="ife">
                                    <div>Day: <input class="input-type-2" name="dia" type="number"></div>
                                    <div>Month: <select class="input-type-2" name="mes" id="">
                                        <option value="<?php echo $sm; ?>"><?php echo $sm; ?></option>
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
                                    </select>
                                </div></div>
                            </div>
                            <input class="boton-enviar" type="submit" value="Config">
                        </form>
                    </div>
                    <div class="div-extra border-g">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
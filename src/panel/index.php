<?php 
    include('../php/auth.php'); 
    include('../php/cnn.php');

    // Querys para recojer información necesaria (SQL y PHP)
        // Homeworks
        $ce = 0; $cr = 0; $cep = 0; $head = 0; $homewk_st = 0;
        $sql = "SELECT COUNT(id) FROM tareas WHERE vinc_usuario = $id_token_decode";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$homewk_started = $row['COUNT(id)'];}}

        $sql = "SELECT COUNT(id) FROM tareas WHERE vinc_usuario = $id_token_decode AND entregado = 'No'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$homewk_st = $row['COUNT(id)'];}}

        $sql = "SELECT COUNT(realizado) FROM tareas WHERE vinc_usuario = $id_token_decode AND realizado = 'Yes'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$cr = $row['COUNT(realizado)'];}}

        $sql = "SELECT COUNT(entregado) FROM tareas WHERE vinc_usuario = $id_token_decode AND entregado = 'Yes'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$ce = $row['COUNT(entregado)'];}}

        $sql = "SELECT COUNT(en_plazo) FROM tareas WHERE vinc_usuario = $id_token_decode AND en_plazo = 'Yes'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$cep = $row['COUNT(en_plazo)'];}}

        // Works
        $me = 0; $mr = 0; $mep = 0; $wrad = 0; $work_st = 0;
        $sql2 = "SELECT COUNT(id) FROM trabajos WHERE vinc_usuario = $id_token_decode";
        if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$work_started = $row['COUNT(id)'];}}

        $sql2 = "SELECT COUNT(id) FROM trabajos WHERE vinc_usuario = $id_token_decode AND entregado = 'No'";
        if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$work_st = $row['COUNT(id)'];}}

        $sql2 = "SELECT COUNT(realizado) FROM trabajos WHERE vinc_usuario = $id_token_decode AND realizado = 'Yes'";
        if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$mr = $row['COUNT(realizado)'];}}

        $sql2 = "SELECT COUNT(entregado) FROM trabajos WHERE vinc_usuario = $id_token_decode AND entregado = 'Yes'";
        if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$me = $row['COUNT(entregado)'];}}

        $sql2 = "SELECT COUNT(en_plazo) FROM trabajos WHERE vinc_usuario = $id_token_decode AND en_plazo = 'Yes'";
        if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$mep = $row['COUNT(en_plazo)'];}}

        //$sql2 = "SELECT nota FROM trabajos WHERE vinc_usuario = $id_token_decode AND entregado = 'Yes'";
        //if($result = $conn->query($sql2)){while($row = $result->fetch_assoc()){$mep = $row[''];}}

        // Exams
        $dr = 0; $passed = 0; $exam_srted = 0; $eead = 0; $exam_st = 0;
        $sql = "SELECT COUNT(id) FROM examenes WHERE vinc_usuario = $id_token_decode";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$exam_started = $row['COUNT(id)'];}}

        $sql = "SELECT COUNT(id) FROM examenes WHERE vinc_usuario = $id_token_decode AND realizado = 'No'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$exam_st = $row['COUNT(id)'];}}

        $sql = "SELECT COUNT(realizado) FROM examenes WHERE vinc_usuario = $id_token_decode AND realizado >= 'Yes'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$exam_srted = $row['COUNT(realizado)'];}}

        $sql = "SELECT COUNT(nota) FROM examenes WHERE vinc_usuario = $id_token_decode AND nota >= 4.99";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$passed = $row['COUNT(nota)'];}}

    // Datos avanzados
        if($exam_srted != 0){$eead = ($passed * 100) / $exam_srted;}else{$eead = 0;}
        if($work_started != 0){$wrad = ($mr * 100) / $work_started;}else{$wrad = 0;}
        if($work_started != 0){$wdad = ($me * 100) / $work_started;}else{$wdad = 0;}
        if($me != 0){$wepad = ($mep * 100) / $me;}else{$wepad = 0;}
        if($homewk_started != 0){$head = ($cr * 100) / $homewk_started;}else{$head = 0;}
        if($homewk_started != 0){$hdad = ($ce * 100) / $homewk_started;}else{$hdad = 0;}
        if($ce != 0){$hotad = ($cep * 100) / $ce;}else{$hotad = 0;}

    function redondeado ($numero, $decimales) {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
     }

    // Chart code
        // Crear array segun asignaturas
        $Asignaturas = array(); $i = 0; 

        $sql = "SELECT `name` FROM asignaturas WHERE vinc_usuario = '$id_token_decode'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){
            $i++;
            $asigs = $row['name'];
            $Asignaturas[$i] = $asigs;
        }}

        // SQL por asiganura
        $j = 0; $color1 = "black"; $color2 = "black";
        $data_chart = array();
        while($j < $i){
            $j++;
            $a = $Asignaturas[$j];
            
            if($j == 1 or $j == 1+5 or $j == 1+10){$color1 = "#7FFF00"; $color2 = "#7FFF00";}
            if($j == 2 or $j == 2+5 or $j == 2+10){$color1 = "#8A2BE2"; $color2 = "#8A2BE2";}
            if($j == 3 or $j == 3+5 or $j == 3+10){$color1 = "#FF8C00"; $color2 = "#FF8C00";}
            if($j == 4 or $j == 4+5 or $j == 4+10){$color1 = "#0000CD"; $color2 = "#0000CD";}
            if($j == 5 or $j == 5+5 or $j == 5+10){$color1 = "#00FF7F"; $color2 = "#00FF7F";}

            $sql = "SELECT COUNT(id) FROM tareas WHERE vinc_usuario = '$id_token_decode' AND asignatura = '$a'";
            if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){
                $b = $row['COUNT(id)'];
                $data_chart[$j] = '
                {
                    label: "'.$a.'",
                    color: "'.$color1.'",
                    highlight: "'.$color2.'",
                    value: '.$b.'
                }
                ';
            }}
        }

        $y = 0;
        $sql = "SELECT id FROM tareas WHERE vinc_usuario = '$id_token_decode'";
        if($result = $conn->query($sql)){while($row = $result->fetch_assoc()){$y++;}}

        if($y == 0){$mostrar_chart = "display: none;";}
        //var_dump($data_chart);
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

            <div class="seccion"> <h1 class="titulo-seccion">Home</h1> </div>
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
            <div class="contenido-superior">
                <div class="superior-cuatro border-g">
                    <h3 class="titulo-cuatro">Homeworks To Be Delivered</h3>
                    <p class="valor-cuatro"><?php echo $homewk_st; ?></p>
                </div>
                <div class="superior-cuatro border-g">
                    <h3 class="titulo-cuatro">Works To Be Delivered</h3>
                    <p class="valor-cuatro"><?php echo $work_st; ?></p>
                </div>
                <div class="superior-cuatro border-g">
                    <h3 class="titulo-cuatro">Exams To Be Realized</h3>
                    <p class="valor-cuatro"><?php echo $exam_st; ?></p>
                </div>
                <div class="superior-cuatro border-g">
                    <h3 class="titulo-cuatro">To be determined</h3>
                    <p class="valor-cuatro"><?php echo ""; ?></p>
                </div>
            </div>
            <div class="contenido-medio">
                <div class="div-mid-2 border-g">
                    <h3 class="titulo-cuatro">Homeworks Extended Data</h3>
                    <p class="hmwk-p">Homeworks: <?php echo $homewk_started; ?></p>
                    <p class="hmwk-p">Homeworks Ended: <?php echo $cr; ?></p>
                    <p class="hmwk-p">Homeworks Delivered: <?php echo $ce; ?></p>
                    <p class="hmwk-p">Homeworks On Time: <?php echo $cep; ?></p>
                </div>
                <div class="div-mid-3 border-g">
                    <h3 class="titulo-cuatro">Exams Extended Data</h3>
                    <p class="hmwk-p">Exams: <?php echo $exam_started; ?></p>
                    <p class="hmwk-p">Exams Ended: <?php echo $exam_srted; ?></p>
                    <p class="hmwk-p">Exams Passed: <?php echo $passed; ?></p>
                </div>
                <div class="div-mid-1 border-g">
                    <h3 class="titulo-cuatro">Things To Do</h3>

                    <?php
                        $sql = "SELECT texto FROM tareas WHERE vinc_usuario = '$id_token_decode' AND realizado = 'No'"; //$ccc = 0;
                        if($result = $conn->query($sql)){
                            while($row = $result->fetch_assoc()){
                                //$ccc++;
                                echo '<p class="hmwk-p">'.$row['texto'].'</p>';
                            }
                        }
                        //if($ccc == 0){echo '<p class="hmwk-p">Nothing to do</p>';}
                    ?>

                </div>
            </div>
            <div class="contenido-inferior">
                <div class="div-mid-2 border-g">
                    <h3 class="titulo-cuatro">Works Extended Data</h3>
                    <p class="hmwk-p">Works: <?php echo $work_started; ?></p>
                    <p class="hmwk-p">Works Ended: <?php echo $mr; ?></p>
                    <p class="hmwk-p">Works Delivered: <?php echo $me; ?></p>
                    <p class="hmwk-p">Works On Time: <?php echo $mep; ?></p>
                </div>
                <div class="div-mid-3 border-g">
                    <h3 class="titulo-cuatro">Homeworks by Subject</h3>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
                    <div style="<?php echo $mostrar_chart; ?>" class="chart">
                    <canvas id="property_types" class="pie"></canvas>
                    <div id="pie_legend"></div>
                    </div>

                    <script>
                            // global options variable
                        var options = {
                        responsive: true,
                        scaleBeginAtZero: true,
                        // you don't have to define this here, it exists inside the global defaults
                        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                        }

                        // PIE
                        // PROPERTY TYPE DISTRIBUTION
                        // context
                        var ctxPTD = $("#property_types").get(0).getContext("2d");
                        // data
                        var dataPTD = [
                            <?php
                                $s = 0;
                                while($s < $j){
                                    $s++;
                                    if($s == 1){$coma = "";}else{$coma = ",";}
                                    echo $coma.' '.$data_chart[$s];
                                }    
                            ?>
                        ]

                        // Property Type Distribution
                        var propertyTypes = new Chart(ctxPTD).Pie(dataPTD, options);
                        // pie chart legend
                        $("#pie_legend").html(propertyTypes.generateLegend());
                    </script> 

                </div>
                <div class="div-mid-1 border-g">
                    <h3 class="titulo-cuatro">Advanced Data</h3>
                    <div id="add">
                        <div class="advance-data">

                            <div style="display:flex;">
                                <p class="hmwk-p">Homeworks Ended: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($head, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($head, 0); ?>%</p>
                            </div>

                            <div style="display:flex;">
                                <p class="hmwk-p">Homeworks Delivered: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($hdad, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($hdad, 0); ?>%</p>
                            </div>

                            <div style="display:flex;">
                                <p class="hmwk-p">Homeworks On Time: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($hotad, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($hotad, 0); ?>%</p>
                            </div>

                            <div style="display:flex;">
                                <p class="hmwk-p">Works Ended: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($wrad, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($wrad, 0); ?>%</p>
                            </div>

                            <div style="display:flex;">
                                <p class="hmwk-p">Works Delivered: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($wdad, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($wdad, 0); ?>%</p>
                            </div>

                            <div style="display:flex;">
                                <p class="hmwk-p">Works On Time: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($wepad, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($wepad, 0); ?>%</p>
                            </div>

                            <!--
                            <div style="display:flex;">
                                <p class="hmwk-p">Current Works Note: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado(0, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado(0, 0); ?>%</p>
                            </div>
                            -->

                            <div style="display:flex;">
                                <p class="hmwk-p">Exams Passed: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado($eead, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado($eead, 0); ?>%</p>
                            </div>

                            <!--
                            <div style="display:flex;">
                                <p class="hmwk-p">Current Exams Note: </p> 
                                <progress class="bp" max="100" value="<?php echo redondeado(0, 0); ?>"></progress> 
                                <?php echo '<p class="bp2">'.redondeado(0, 0); ?>%</p>
                            </div>
                            -->

                        </div>
                        <div class="advance-data">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
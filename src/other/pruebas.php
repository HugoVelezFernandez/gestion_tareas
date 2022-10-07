<?php
    include('../php/cnn.php'); include('../php/auth.php');

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
    //var_dump($data_chart);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .pie-legend {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .pie-legend span {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 100%;
            margin-right: 16px;
            margin-bottom: -2px;
        }
        .chart{
            width: 300px;
        }
    </style>

</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
<div class="chart">
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

</body>
</html>